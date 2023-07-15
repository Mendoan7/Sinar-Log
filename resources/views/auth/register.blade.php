@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    
<div class="py-16 xl:pb-56 bg-gradient-to-b from-gray-100 to-white">
    <div class="container px-4 mx-auto">
      <div class="text-center max-w-md mx-auto">
        <a class="mb-10 inline-block" href="/">
          <img class="h-16" src="{{ asset('/assets/frontsite/images/logo.png') }}"
          alt="Sinar Cell Logo"/>
        </a>
        <h2 class="mb-4 text-2xl md:text-3xl text-center font-bold font-heading tracking-px-n leading-tight">Buat Akun Baru</h2>
        <p class="mb-12 font-medium text-lg text-gray-600 leading-normal">Daftar akun kalau kamu baru di Sinar Cell.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label class="block mb-5">
                <input for="name" type="text" id="name" name="name"
                class="px-4 py-3.5 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus/>
            </label>

            <label class="block mb-5">
                <input for="email" type="email" id="email" name="email"
                class="px-4 py-3.5 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                placeholder="Email" value="{{ old('email') }}" required autofocus/>
            </label>

            <label class="block mb-5">
                <input for="password" type="password" id="password" name="password"
                class="px-4 py-3.5 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                placeholder="Password" value="{{ old('password') }}" required autofocus/>
            </label>

            <label class="block mb-5">
                <input for="password_confirmation" type="password" id="password_confirmation" name="password_confirmation"
                class="px-4 py-3.5 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300"
                placeholder="Konfirmasi Password" required autofocus/>
            </label>

            <button type="submit" class="mb-8 py-4 px-9 w-full text-white font-semibold border rounded-xl shadow-4xl focus:ring focus:ring-indigo-300 bg-blue-600 hover:bg-blue-700 transition ease-in-out duration-200" type="button">
                Buat Akun
            </button>
            <p class="font-medium">
                <span>Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700">
                    Login
                </a>
            </p>
        </form>
      </div>
    </div>
  </div>

@endsection
