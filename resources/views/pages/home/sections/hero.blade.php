<section class="relative text-white overflow-hidden min-h-screen flex items-start md:items-center pt-15">
    <div class="absolute inset-0">
        <img src="{{ asset('assets/Background.jpg') }}" 
             class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-b md:bg-gradient-to-r from-blue-900/90 via-blue-800/70 to-transparent"></div>
    </div>
    <div class="relative w-full max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 pt-32 pb-10 md:py-0">   
        <div class="max-w-2xl"> 
            <h1 class="text-5xl sm:text-5xl md:text-6xl font-bold leading-tight mb-2">
                Wujudkan kepedulian bersama <span class="text-yellow-400">AkuENGGAKPeduli</span>
            </h1>
            <p class="text-start text-xl text-blue-100 mb-6">
                Satu langkah kecil untuk kebaikan sedulur Jember. Pilih campaign yang dekat dengan kita dan salurkan bantuanmu dengan rasa aman dan transparan.
            </p>
            <a href="{{ route('donation.index') }}" class="inline-block px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl">
                Donasi Sekarang
            </a>
        </div>
    </div>
</section>