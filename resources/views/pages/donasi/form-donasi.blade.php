@extends('layouts.navbar')
@section('title', 'Berdonasi - AkuPeduli!')

@section('content')
<main class="pt-32 pb-10 bg-slate-50 min-h-screen">
    <div class="max-w-xl mx-auto px-4">
        <x-donasi-ringkasan />
        <form action="#" method="POST" class="mt-2" id="donationForm">
            @csrf
            <x-donasi-form />
            <div class="mt-5">
                <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg rounded-xl shadow-xl shadow-blue-100 transition-all active:scale-[0.97] flex items-center justify-center gap-3">
                    <span>Lanjutkan Pembayaran</span>
                </button>
                
                <p class="text-center text-slate-400 text-xs mt-6 leading-relaxed">
                    Setiap donasi yang masuk akan disalurkan 100% kepada penerima manfaat.<br>
                    <span class="font-bold text-blue-600">#AkuPeduli Jember</span>
                </p>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nominalInput = document.getElementById('input-nominal');
        const nominalButtons = document.querySelectorAll('.btn-nominal');

        nominalButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                nominalButtons.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50', 'text-blue-600'));
                this.classList.add('border-blue-600', 'bg-blue-50', 'text-blue-600');
                const rawValue = this.getAttribute('data-nominal');
                nominalInput.value = formatRupiah(rawValue);
            });
        });

        nominalInput.addEventListener('input', function(e) {
            nominalButtons.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50', 'text-blue-600'));
            
            let value = this.value.replace(/\D/g, '');
            this.value = formatRupiah(value);
        });

        function formatRupiah(angka) {
            if (!angka) return '';
            return new Intl.NumberFormat('id-ID').format(angka);
        }
    });
</script>

@include('layouts.footer')
@endsection