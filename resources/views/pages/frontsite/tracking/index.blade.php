@extends('layouts.default')

@section('title', 'Home')

@section('content')

<section>
  <div class="max-w-6xl mx-auto px-4 sm:px-6">
      <div class="pt-32 pb-12 md:pt-40 md:pb-20">

      <div class="max-w-4xl mx-auto mb-12 text-center">
          <span class="inline-block py-px px-2 mb-4 text-xs leading-5 text-blue-500 bg-blue-100 font-medium uppercase rounded-full shadow-sm">Pantau Servis</span>
          <h3 class="mb-4 text-3xl md:text-4xl leading-tight font-bold tracking-tighter">Ketahui Status Perbaikan</h3>
          <p class="text-lg md:text-xl text-coolGray-500 font-medium">Pelacakan status perbaikan, silahkan isi nomer telepon kamu.</p>
      </div>

      <form action="{{ route('tracking.track') }}" method="POST" class="mb-11 md:max-w-md mx-auto">
        @csrf
        <div class="mb-5">
          <input class="px-4 py-4 w-full text-gray-500 font-medium text-center placeholder-gray-500 outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" type="tel" id="contact" type="text" name="contact" placeholder="Masukan Nomer Hp Kamu" required>
        </div>
        <button class="py-4 px-6 w-full text-white font-semibold rounded-xl shadow-4xl focus:ring focus:ring-blue-300 bg-blue-600 hover:bg-blue-700 transition ease-in-out duration-200" type="submit">Pantau Sekarang</button>
      </form>

    </div>
  </div>
</section>

@endsection