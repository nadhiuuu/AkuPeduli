@extends('layouts.app')
@section('title', 'AkuPeduli! - Wujudkan Kepedulian Melalui Donasi')
@section('content')

@include('pages.home.sections.hero')
@include('pages.home.sections.campaign')
@include('pages.home.sections.statistics')
@include('pages.home.sections.documentation')

@include('layouts.footer')
@endsection
