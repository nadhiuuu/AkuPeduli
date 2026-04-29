@extends('layouts.navbar')
@section('title', 'Pengaturan - AkuPeduli')

@section('content')
    <main class="pt-20 pb-20">
        <div class="min-h-screen bg-slate-50/50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto" x-data="{
                tab: '{{ session('tab') ?? (request('tab') ?? 'profile') }}'
            }">
                <div class="md:hidden mb-6 text-center">
                    <h1 class="text-2xl font-bold text-slate-800">Pengaturan Profil</h1>
                </div>

                <div class="flex flex-col md:flex-row gap-8">

                    @include('components.profile-sidebar') <main class="w-full md:w-3/4">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-5 min-h-[500px]">
                            <div class="tab-content">
                                @include('pages.profil.informasi-profil')
                                @include('pages.profil.donasi-saya')
                                @include('pages.profil.password')
                                @include('pages.profil/sesi-browser')
                            </div>
                        </div>
                    </main>

                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
@endsection
