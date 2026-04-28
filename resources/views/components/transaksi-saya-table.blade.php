@props(['donations'])

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 py-4 text-sm font-bold text-slate-500">Judul Donasi</th>
                <th class="px-6 py-4 text-sm font-bold text-slate-500">Tanggal</th>
                <th class="px-6 py-4 text-sm font-bold text-slate-500">Nominal</th>
                <th class="px-6 py-4 text-sm font-bold text-slate-500 text-center">Status</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100">

            @forelse ($donations as $donation)
                <tr class="hover:bg-slate-50/50 transition-colors">

                    <!-- Judul -->
                    <td class="px-6 py-4">
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $donation->campaign->title ?? '-' }}
                        </p>
                    </td>

                    <!-- Tanggal -->
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $donation->created_at->translatedFormat('d F Y') }}
                    </td>

                    <!-- Nominal -->
                    <td class="px-6 py-4 font-bold text-slate-800 text-sm">
                        Rp {{ number_format($donation->gross_amount, 0, ',', '.') }}
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4 text-center">
                        @if ($donation->status == 'success')
                            <span
                                class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">
                                Berhasil
                            </span>
                        @elseif ($donation->status == 'pending')
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-bold rounded-full uppercase">
                                Pending
                            </span>
                        @else
                            <span
                                class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-full uppercase">
                                Gagal
                            </span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-slate-400">
                        Belum ada riwayat donasi
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <div class="mt-6 flex flex-col items-center gap-3">

        <!-- INFO + PER PAGE -->
        <div class="flex items-center justify-center gap-4 text-sm text-slate-500">

            <!-- info -->
            <span>
                Menampilkan {{ $donations->firstItem() ?? 0 }} - {{ $donations->lastItem() ?? 0 }}
                dari {{ $donations->total() }} data
            </span>

            <!-- dropdown perPage -->
            <form method="GET">
                <!-- 🔥 WAJIB -->
                <input type="hidden" name="tab" value="donations">

                <select name="perPage" onchange="this.form.submit()"
                    class="border border-slate-200 rounded-lg px-2 py-1 text-sm">

                    @foreach ([5, 10, 25, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('perPage') == $size ? 'selected' : '' }}>
                            {{ $size }} data
                        </option>
                    @endforeach

                </select>
            </form>

        </div>

        <!-- pagination -->
        <div>
            {{ $donations->appends(request()->query())->links() }}
        </div>

    </div>
</div>
