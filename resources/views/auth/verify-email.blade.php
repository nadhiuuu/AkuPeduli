@extends('layouts.navbar')

@section('title', 'Verify Email')

@section('content')
<div class="max-w-md mx-auto px-4">
    <h2 class="text-2xl font-semibold mb-6">Verify your email address</h2>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <p class="mb-4 text-gray-700">
        Before proceeding, please check your email for a verification link. If you didn't receive the email,
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Resend Verification Email</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="text-red-600 underline">Logout</button>
    </form>
</div>
@endsection
