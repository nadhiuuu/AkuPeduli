<section class="relative-mt-2 mb-12">
    <div class="w-full">
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-900 to-blue-400 p-12 md:p-16 shadow-2xl">

            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100" stroke="white" stroke-width="0.3" fill="none" />
                    <path d="M0 80 C 30 10 60 10 100 80" stroke="white" stroke-width="0.2" fill="none" />
                </svg>
            </div>

            <div
                class="relative z-10 max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center text-white">
                <div class="flex flex-col items-center justify-center">
                    <h3 class="text-3xl md:text-5xl font-bold tracking-tight mb-2">
                        Rp{{ number_format($totalDonations, 0, ',', '.') }}</h3>
                    <p class="text-blue-100 text-sm md:text-lg font-medium opacity-90">Dana Terkumpul</p>
                </div>

                <div class="flex flex-col items-center justify-center md:border-l border-white/20">
                    <h3 class="text-3xl md:text-5xl font-bold tracking-tight mb-2">
                        {{ number_format($totalTransactions, 0, ',', '.') }}</h3>
                    <p class="text-blue-100 text-sm md:text-lg font-medium opacity-90">Kali Donasi</p>
                </div>

                <div class="flex flex-col items-center justify-center border-l border-white/20">
                    <h3 class="text-3xl md:text-5xl font-bold tracking-tight mb-2">
                        {{ number_format($totalUsers, 0, ',', '.') }}</h3>
                    <p class="text-blue-100 text-sm md:text-lg font-medium opacity-90">Orang Terdaftar</p>
                </div>

                <div class="flex flex-col items-center justify-center border-l border-white/20">
                    <h3 class="text-3xl md:text-5xl font-bold tracking-tight mb-2">
                        {{ number_format($totalCampaigns, 0, ',', '.') }}</h3>
                    <p class="text-blue-100 text-sm md:text-lg font-medium opacity-90">Campaign Dibuat</p>
                </div>
            </div>
        </div>
    </div>
</section>
