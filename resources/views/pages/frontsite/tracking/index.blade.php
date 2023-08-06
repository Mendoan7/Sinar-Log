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
          
          @if(session('error'))
            <div class="mb-5" x-show="open" x-data="{ open: true }">
              <div class="px-4 py-2 rounded-sm text-sm bg-rose-100 border border-rose-200 text-rose-600">
                  <div class="flex w-full justify-between items-start">
                      <div class="flex">
                          <svg class="w-4 h-4 shrink-0 fill-current opacity-80 mt-[3px] mr-3" viewBox="0 0 16 16">
                              <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm3.5 10.1l-1.4 1.4L8 9.4l-2.1 2.1-1.4-1.4L6.6 8 4.5 5.9l1.4-1.4L8 6.6l2.1-2.1 1.4 1.4L9.4 8l2.1 2.1z" />
                          </svg>
                          <div>{{ session('error') }}</div>
                      </div>
                      <button class="opacity-70 hover:opacity-80 ml-3 mt-[3px]" @click="open = false">
                          <div class="sr-only">Close</div>
                          <svg class="w-4 h-4 fill-current">
                              <path d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                          </svg>
                      </button>
                  </div>
              </div>
            </div>
          @endif
          
          <div class="mb-5">
            <input class="px-4 py-4 w-full text-gray-500 font-medium text-center placeholder-gray-500 outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" type="tel" id="contact" type="text" name="contact" placeholder="Masukan Nomer Hp Kamu" required>
          </div>
          <button class="py-4 px-6 w-full text-white font-semibold rounded-xl shadow-4xl focus:ring focus:ring-blue-300 bg-blue-600 hover:bg-blue-700 transition ease-in-out duration-200" type="submit">Pantau Sekarang</button>
        </form>

    </div>
  </div>
</section>

@endsection