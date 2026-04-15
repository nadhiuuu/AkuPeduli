@extends('layouts.navbar')
@section('title', 'Detail Campaign - AkuPeduli')

@section('content')
<main class="pt-32 pb-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-10">
            <div class="lg:w-2/3">
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100">
                    <img src="{{ asset('storage/' . $campaign->image) }}" class="w-full h-[400px] object-cover">
                    <div class="p-6">
                        <h1 class="text-3xl font-bold text-slate-900 mb-3">{{ $campaign->title }}</h1>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                            {!! $campaign->description !!} </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3">
                <x-campaign-sidebar
                    :slug="$campaign->slug"
                    :raised="$campaign->current_amount" 
                    :goal="$campaign->target_amount"
                    :percentage="$percentage"
                    :donors="$donorsCount"
                    :daysLeft="$daysLeft"
                    :author="$campaign->user->name"
                />
            </div>

        </div>
    </div>
</main>

@include('layouts.footer')
@endsection