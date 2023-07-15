@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="py-16 xl:pb-56 bg-gradient-to-b from-gray-100 to-white">
    <div class="container px-4 mx-auto">
      <div class="text-center max-w-md mx-auto">
        <a class="mb-10 inline-block" href="/">
            <img class="h-16" src="{{ asset('/assets/frontsite/images/logo.png') }}"
            alt="Sinar Cell Logo"/>
          </a>
        <h2 class="mb-8 text-2xl md:text-3xl text-center font-bold font-heading tracking-px-n leading-tight">Welcome Back, Admin/Teknisi</h2>
        
        <form method="POST" action="{{ route('login') }}">
           @csrf 

            <label class="block mb-5">
                <input for="email" type="email" id="email" name="email"
                class="px-4 py-3.5 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                placeholder="Alamat Email" value="{{ old('email') }}" required autofocus/>
            </label>

            <label class="relative block mb-5">
                <div class="absolute right-4 top-1/2 transform -translate-y-1/2"><a class="text-sm text-blue-600 hover:text-blue-700 font-medium" href="#">Lupa Password?</a></div>
                <input for="password" type="password" id="password" name="password"
                class="px-4 pr-36 py-3.5 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                placeholder="Password"/>
            </label>

            <button class="mb-8 py-4 px-9 w-full text-white font-semibold rounded-xl shadow-4xl focus:ring focus:ring-indigo-300 bg-blue-600 hover:bg-blue-700 transition ease-in-out duration-200">
                Login
            </button>

            <p class="font-medium">
                <span>Belum punya akun?</span>
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700">
                    Buat akun baru
                </a>
            </p>
        </form>
      </div>
    </div>
</div>

@endsection
