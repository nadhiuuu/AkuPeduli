<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\DisasterCategory;
use App\Models\Donation;
use App\Notifications\CampaignDonationReceivedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class DonationController extends Controller
{
    public function index()
    {
        $categories = DisasterCategory::pluck('name')->toArray();

        $campaignData = Campaign::with(['impact', 'category'])
            ->withCount(['donations' => function ($query) {
                $query->where('status', 'success');
            }])
            ->where('status', 'aktif')
            ->latest()
            ->get()
            ->map(function ($campaign) {
                $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
                $percentage = ($campaign->current_amount / $target) * 100;
                $daysLeft = Carbon::now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false);

                return [
                    'slug' => $campaign->slug,
                    'category' => $campaign->category->name ?? 'Umum',
                    'title' => $campaign->title,
                    'description' => Str::limit(strip_tags($campaign->description), 100),
                    'raised' => $campaign->current_amount,
                    'goal' => $campaign->target_amount,
                    'percentage' => min(100, $percentage),
                    'image' => asset('storage/'.$campaign->image),
                    'lat' => $campaign->impact->latitude ?? '-8.1724',
                    'lng' => $campaign->impact->longitude ?? '113.7003',
                    'donors_count' => $campaign->donations_count,
                    'days_left' => max(0, intval($daysLeft)),
                ];
            });

        return view('pages.donasi.index', [
            'campaigns' => $campaignData,
            'catList' => $categories,
        ]);
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['impact', 'category', 'user']);

        $donorsCount = $campaign->donations()->where('status', 'success')->count();

        $daysLeft = max(0, Carbon::now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false));

        $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
        $percentage = min(100, ($campaign->current_amount / $target) * 100);

        return view('pages.donasi.detail-campaign', [
            'campaign' => $campaign,
            'donorsCount' => $donorsCount,
            'daysLeft' => $daysLeft,
            'percentage' => $percentage,
        ]);
    }

    public function donate(Campaign $campaign)
    {
        $daysLeft = max(0, Carbon::now()->startOfDay()->diffInDays(Carbon::parse($campaign->end_date)->startOfDay(), false));
        $target = $campaign->target_amount > 0 ? $campaign->target_amount : 1;
        $percentage = min(100, ($campaign->current_amount / $target) * 100);

        return view('pages.donasi.form-donasi', [
            'campaign' => $campaign,
            'daysLeft' => $daysLeft,
            'percentage' => $percentage,
        ]);
    }

    public function process(Request $request, Campaign $campaign)
    {
        $request->validate([
            'amount' => 'required|string',
            'message' => 'nullable|string',
        ]);

        $amount = (int) preg_replace('/\D/', '', $request->amount);
        $user = $request->user();
        $isAnonymous = $request->has('is_anonymous');
        $donorName = $isAnonymous ? 'Hamba Allah (Anonim)' : $user->name;

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'user_id' => $user->id,
            'order_id' => 'DON-'.time().'-'.mt_rand(100, 999),
            'gross_amount' => $amount,
            'donor_name' => $donorName,
            'is_anonymous' => $isAnonymous,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $donation->order_id,
                'gross_amount' => $donation->gross_amount,
            ],
            'customer_details' => [
                'first_name' => $donation->donor_name,
                'email' => $user->email,
            ],

            'callbacks' => [
                'finish' => route('donation.thanks'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $donation->update(['snap_token' => $snapToken]);

        return view('pages.donasi.detail-transaksi', [
            'campaign' => $campaign,
            'donation' => $donation,
            'user' => $user,
            'date' => now()->translatedFormat('d M Y'),
            'snapToken' => $snapToken,
        ]);
    }

    public function thanks()
    {
        return view('pages.donasi.thanks');
    }

    public function webhook(Request $request)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');

        try {
            $notif = new Notification;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal verifikasi signature Midtrans'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;

        $donation = Donation::with('campaign.user')
            ->where('order_id', $orderId)
            ->first();

        if (! $donation) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $oldStatus = $donation->status;

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $donation->update(['status' => 'success']);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $donation->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'pending') {
            $donation->update(['status' => 'pending']);
        }

        if ($donation->status == 'success' && $oldStatus != 'success') {
            $donation->campaign->increment('current_amount', $donation->gross_amount);

            $campaignOwner = $donation->campaign?->user;

            if ($campaignOwner) {
                $campaignOwner->notify(new CampaignDonationReceivedNotification($donation));
            }
        }

        return response()->json(['message' => 'Webhook berhasil diproses']);
    }
}
