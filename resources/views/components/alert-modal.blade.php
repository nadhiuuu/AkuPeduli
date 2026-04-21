<div id="custom-alert-modal" class="fixed inset-0 z-[999] hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeCustomAlert()"></div>
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0 pointer-events-none">
        <div class="relative bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full pointer-events-auto scale-95 translate-y-4 duration-300" id="custom-alert-box">
            
            <div class="bg-white px-6 py-8 sm:p-8">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-blue-50 sm:mx-0 sm:h-12 sm:w-12">
                        <svg class="h-8 w-8 text-blue-600 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    
                    <div class="mt-4 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-xl leading-6 font-bold text-slate-900" id="custom-alert-title">
                            Judul
                        </h3>
                        <div class="mt-3">
                            <p class="text-sm text-slate-500 leading-relaxed" id="custom-alert-message">
                                Pesan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3">
                <button type="button" id="custom-alert-confirm" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-blue-600 text-base font-bold text-white hover:bg-blue-700 focus:outline-none active:scale-95 transition-all sm:w-auto sm:text-sm">
                    Konfirmasi
                </button>
                <button type="button" onclick="closeCustomAlert()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-200 shadow-sm px-6 py-3 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none active:scale-95 transition-all sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT PENGENDALI MODAL --}}
<script>
    function showCustomAlert(title, message, confirmUrl, confirmText = "Lanjutkan") {
        const modal = document.getElementById('custom-alert-modal');
        const box = document.getElementById('custom-alert-box');
        
        document.getElementById('custom-alert-title').innerText = title;
        document.getElementById('custom-alert-message').innerText = message;
        
        const confirmBtn = document.getElementById('custom-alert-confirm');
        confirmBtn.innerText = confirmText;
        confirmBtn.onclick = function() {
            window.location.href = confirmUrl;
        };

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            box.classList.remove('scale-95', 'translate-y-4');
            box.classList.add('scale-100', 'translate-y-0');
        }, 10);
    }

    function closeCustomAlert() {
        const modal = document.getElementById('custom-alert-modal');
        const box = document.getElementById('custom-alert-box');
        
        modal.classList.add('opacity-0');
        box.classList.remove('scale-100', 'translate-y-0');
        box.classList.add('scale-95', 'translate-y-4');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>