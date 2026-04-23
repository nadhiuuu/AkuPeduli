@extends('layouts.navbar')
@section('title', 'Dokumentasi Penyerahan Donasi - AkuPeduli')
@section('content')

    {{-- @php
        $docs = [];

        for ($i = 1; $i <= 10; $i++) {
            $docs[] = [
                'title' => 'Dokumentasi Penyaluran #' . $i,
                'description' => 'Bukti penyaluran bantuan kepada masyarakat yang membutuhkan.',
                'image' => 'https://picsum.photos/400/300?random=' . $i,
                'author' => 'Admin',
                'time' => rand(1, 24) . ' jam lalu',
                'avatar' => 'https://i.pravatar.cc/150?u=' . $i,
            ];
        }
    @endphp --}}
    {{-- @foreach ($documentations as $doc)
        <x-documentation-card :title="$doc->campaign->title" :description="$doc->deskripsi" :image="asset('storage/' . $doc->bukti_foto)" :author="'Admin'" :time="$doc->created_at->diffForHumans()"
            :avatar="'https://i.pravatar.cc/150?u=admin'" :slug="$doc->slug" />
    @endforeach --}}

    <main class="bg-gray-50 pt-28 pb-20">
        <section>
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-14">
                    <h2 class="text-3xl md:text-3xl font-bold mb-3">
                        Dokumentasi Penyerahan Donasi
                    </h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">
                        Dokumentasi ini menunjukkan dampak nyata dari setiap donasi yang Anda berikan.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach ($documentations as $doc)
                        <a href="{{ route('documentation.detail', $doc->slug) }}"
                            class="block bg-white rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden">

                            <img src="{{ asset('storage/' . $doc->bukti_foto) }}" class="w-full h-48 object-cover">

                            <div class="p-4">
                                <h3 class="font-bold text-slate-800">
                                    {{ $doc->campaign->title }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($doc->deskripsi), 80) }}
                                </p>

                                <div class="flex items-center gap-2 mt-4">
                                    <img src="https://i.pravatar.cc/150?u=admin" class="w-6 h-6 rounded-full">
                                    <span class="text-xs text-slate-400">
                                        {{ $doc->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

@endsection
