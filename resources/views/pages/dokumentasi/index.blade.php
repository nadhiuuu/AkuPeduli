@extends('layouts.navbar')
@section('title', 'Dokumentasi Penyerahan Donasi - AkuPeduli!')
@section('content')

@php
    $docs = [];

    for($i=1; $i<=10; $i++){
        $docs[] = [
            'title' => "Dokumentasi Penyaluran #".$i,
            'description' => "Bukti penyaluran bantuan kepada masyarakat yang membutuhkan.",
            'image' => "https://picsum.photos/400/300?random=".$i,
            'author' => "Admin",
            'time' => rand(1,24)." jam lalu",
            'avatar' => "https://i.pravatar.cc/150?u=".$i
        ];
    }
@endphp

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
                @foreach($docs as $item)
                    <x-documentation-card
                        :title="$item['title']"
                        :description="$item['description']"
                        :image="$item['image']"
                        :author="$item['author']"
                        :time="$item['time']"
                        :avatar="$item['avatar']"
                    />
                @endforeach
            </div>
        </div>
    </section>
</main>

@include('layouts.footer')
@endsection