@extends('layouts.navbar')
@section('title', 'AkuPeduli! - Wujudkan Kepedulian Melalui Donasi')
@section('content')

@include('pages.home.sections.hero')
@include('pages.home.sections.campaign')
@include('pages.home.sections.statistics')
@include('pages.home.sections.documentation')
@include('pages.home.sections.reason')
@include('layouts.footer')
@endsection
