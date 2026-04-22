<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\CampaignerProfile;
use App\Models\BankAccount;

class CampaignerVerification extends Component
{
    use WithFileUploads;

    public $step = null;
    
    // Data Profile (from DB if exists)
    public $profile;
    
    // Status
    public $wa_verified = false;
    public $email_verified = false;
    public $ktp_verified = false;
    public $bank_verified = false;

    // Form inputs for WA
    public $no_wa;
    public $wa_otp;
    public $wa_otp_sent = false;
    public $expected_wa_otp;

    // Form inputs for Email
    public $email_campaigner;
    public $email_otp;
    public $email_otp_sent = false;
    public $expected_email_otp;

    // Form inputs for KTP
    public $nik;
    public $foto_ktp;
    public $foto_selfie_ktp;

    // Form inputs for Bank
    public $nama_bank;
    public $nomor_rekening;
    public $nama_pemilik;

    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $this->profile = CampaignerProfile::firstOrCreate(
            ['user_id' => $user->id]
        );

        // Intialize values from DB
        $this->no_wa = $this->profile->no_wa;
        $this->email_campaigner = $this->profile->email_campaigner;
        $this->wa_verified = !is_null($this->profile->wa_verified_at);
        $this->email_verified = !is_null($this->profile->email_verified_at);
        $this->nik = $this->profile->nik;
        
        $this->ktp_verified = $this->profile->nik && $this->profile->foto_ktp && $this->profile->foto_selfie_ktp;
        $bank = BankAccount::where('user_id', $user->id)->first();
        if ($bank) {
            $this->nama_bank = $bank->nama_bank;
            $this->nomor_rekening = $bank->nomor_rekening;
            $this->nama_pemilik = $bank->nama_pemilik;
            $this->bank_verified = true;
        }

        // Check if all verified
        if ($this->ktp_verified && $this->bank_verified && $this->profile->status_verifikasi == 'menunggu') {
            // Already submitted, do nothing
        }
    }

    public function setStep($step)
    {
        $this->step = ($this->step === $step) ? null : $step;
    }

    // --- WA OTP ---
    public function sendWaOtp()
    {
        $this->validate([
            'no_wa' => 'required|numeric'
        ]);

        $this->expected_wa_otp = rand(100000, 999999);
        
        // Setup Fonnte call
        $token = env('FONNTE_TOKEN');
        if ($token) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $this->no_wa,
                    'message' => "Kode OTP Verifikasi AkuPeduli Anda adalah: *{$this->expected_wa_otp}*.\nJangan berikan kode ini kepada siapapun.",
                ]);
            } catch (\Exception $e) {
                Log::error("Fonnte OTP Error: " . $e->getMessage());
            }
        } else {
            Log::info("WA OTP for {$this->no_wa} is: {$this->expected_wa_otp} (Fonnte Token missing)");
        }

        $this->wa_otp_sent = true;
    }

    public function verifyWaOtp()
    {
        if ($this->wa_otp == $this->expected_wa_otp) {
            $this->profile->update([
                'no_wa' => $this->no_wa,
                'wa_verified_at' => now(),
            ]);
            $this->wa_verified = true;
            $this->wa_otp_sent = false;
            $this->step = null;
        } else {
            $this->addError('wa_otp', 'Kode OTP tidak valid.');
        }
    }

    // --- Email OTP ---
    public function sendEmailOtp()
    {
        $this->validate([
            'email_campaigner' => 'required|email'
        ]);

        $this->expected_email_otp = rand(100000, 999999);

        try {
            Mail::raw("Kode OTP Verifikasi Email AkuPeduli Anda adalah: {$this->expected_email_otp}", function($msg) {
                $msg->to($this->email_campaigner)->subject('OTP Verifikasi AkuPeduli');
            });
        } catch (\Exception $e) {
            Log::error("Email OTP Error: " . $e->getMessage());
        }

        $this->email_otp_sent = true;
    }

    public function verifyEmailOtp()
    {
        if ($this->email_otp == $this->expected_email_otp) {
            $this->profile->update([
                'email_campaigner' => $this->email_campaigner,
                'email_verified_at' => now(),
            ]);
            $this->email_verified = true;
            $this->email_otp_sent = false;
            $this->step = null;
        } else {
            $this->addError('email_otp', 'Kode OTP tidak valid.');
        }
    }

    // --- KTP ---
    public function saveKtp()
    {
        $this->validate([
            'nik' => 'required|string|unique:campaigner_profiles,nik,' . $this->profile->id,
        ]);

        if (is_object($this->foto_ktp) && is_object($this->foto_selfie_ktp)) {
             $ktpPath = $this->foto_ktp->store('campaigner_docs', 'public');
             $selfiePath = $this->foto_selfie_ktp->store('campaigner_docs', 'public');

             $this->profile->update([
                 'nik' => $this->nik,
                 'foto_ktp' => $ktpPath,
                 'foto_selfie_ktp' => $selfiePath,
             ]);
             $this->ktp_verified = true;
             $this->step = null;
             
             $this->checkSubmitStatus();
        } else {
            $this->addError('foto_ktp', 'Mohon unggah kedua foto.');
        }
    }

    // --- Bank ---
    public function saveBank()
    {
        $this->validate([
            'nama_bank' => 'required|string',
            'nomor_rekening' => 'required|string',
            'nama_pemilik' => 'required|string',
        ]);

        BankAccount::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nama_bank' => $this->nama_bank,
                'nomor_rekening' => $this->nomor_rekening,
                'nama_pemilik' => $this->nama_pemilik,
            ]
        );

        $this->bank_verified = true;
        $this->step = null;
        
        $this->checkSubmitStatus();
    }

    public function checkSubmitStatus()
    {
        // If all 4 are verified, set profile status to menunggu automatically
        if ($this->wa_verified && $this->email_verified && $this->ktp_verified && $this->bank_verified) {
             if ($this->profile->status_verifikasi === 'ditolak' || empty($this->profile->status_verifikasi)) {
                $this->profile->update(['status_verifikasi' => 'menunggu']);
             }
        }
    }

    public function resetVerification()
    {
        if ($this->profile && $this->profile->status_verifikasi == 'ditolak') {
            $this->profile->update([
                'status_verifikasi' => 'menunggu',
                'alasan_penolakan' => null,
                'foto_ktp' => null,
                'foto_selfie_ktp' => null,
            ]);
            
            $this->foto_ktp = null;
            $this->foto_selfie_ktp = null;
            $this->ktp_verified = false;
        }
    }

    public function render()
    {
        return view('livewire.campaigner-verification')
            ->extends('layouts.navbar')
            ->section('content');
    }
}
