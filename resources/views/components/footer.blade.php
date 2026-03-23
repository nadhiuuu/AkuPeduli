<footer class="bg-gray-800 text-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <h3 class="font-semibold mb-4">Tentang Kami</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Profil</a></li>
                <li><a href="#" class="hover:underline">Karir</a></li>
                <li><a href="#" class="hover:underline">Blog</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-semibold mb-4">Bantuan</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Pusat Bantuan</a></li>
                <li><a href="#" class="hover:underline">Keamanan</a></li>
                <li><a href="#" class="hover:underline">Kontak</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-semibold mb-4">Pelayanan</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Donasi</a></li>
                <li><a href="#" class="hover:underline">FAQ</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-semibold mb-4">Ikuti Kami</h3>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-white">Facebook</a>
                <a href="#" class="hover:text-white">Twitter</a>
                <a href="#" class="hover:text-white">Instagram</a>
            </div>
        </div>
    </div>
    <div class="text-center text-sm py-4 bg-gray-900">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</footer>
