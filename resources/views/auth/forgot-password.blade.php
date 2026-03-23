@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Reset Password</h2>
        </div>
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                        placeholder="Email address" value="{{ old('email') }}">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Email Password Reset Link
                </button>
            </div>
        </form>
        <p class="mt-2 text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                Back to login
            </a>
        </p>
    </div>
</div>
@endsection
