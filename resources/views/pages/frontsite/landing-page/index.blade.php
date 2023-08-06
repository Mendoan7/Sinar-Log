@extends('layouts.default')

@section('title', 'Home')

@section('content')

  {{-- Hero --}}
  <section class="relative">

    <!-- Bg -->
    <div class="absolute inset-0 rounded-bl-[100px] bg-gray-50 pointer-events-none -z-10" aria-hidden="true"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <!-- Hero content -->
            <div class="relative max-w-xl mx-auto md:max-w-none text-center md:text-left flex flex-col md:flex-row">

                <!-- Content -->
                <div class="md:w-[640px]">
                    <!-- Copy -->
                    <h1 class="h1 mb-6" data-aos="fade-right" data-aos-delay="100">Solusi untuk masalah device kamu <span class="relative inline-flex text-blue-600">
                        <svg class="absolute left-0 top-full -mt-4 max-w-full -z-10" width="220" height="24" viewBox="0 0 220 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M134.66 13.107c-10.334-.37-20.721-.5-31.12-.291l-2.6.06c-4.116.04-8.193.602-12.3.749-14.502.43-29.029 1.196-43.514 2.465-6.414.63-12.808 1.629-19.04 2.866-7.93 1.579-16.113 3.71-23.367 5.003-2.211.374-3.397-1.832-2.31-4.906.5-1.467 1.838-3.456 3.418-4.813a16.047 16.047 0 0 1 6.107-3.365c16.88-4.266 33.763-6.67 51.009-7.389C71.25 3.187 81.81 1.6 92.309.966c11.53-.65 23.097-.938 34.66-.96 7.117-.054 14.25.254 21.36.318l16.194.803 4.62.39c3.85.32 7.693.618 11.53.813 8.346.883 16.673.802 25.144 2.159 1.864.276 3.714.338 5.566.873l.717.225c6.162 1.977 7.92 3.64 7.9 7.197l-.003.203c-.017.875.05 1.772-.112 2.593-.581 2.762-4.066 4.12-8.637 3.63-13.696-1.06-27.935-3.332-42.97-4.168-11.055-.83-22.314-1.459-33.596-1.603l-.022-.332Z" fill="#D1D5DB" fill-rule="evenodd" />
                        </svg>
                        Sinar Cell
                    </span>.</h1>
                    <p class="text-xl text-gray-500 mb-10" data-aos="fade-right" data-aos-delay="200">Bersama Teknisi Kami Yang Berpengalaman dan Berkompeten.</p>
                    <!-- Buttons -->
                    <div class="max-w-xs mx-auto sm:max-w-none sm:flex sm:justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-4 mb-12 md:mb-20" data-aos="fade-right" data-aos-delay="300">
                        <div>
                            <a class="btn text-white bg-blue-600 hover:bg-blue-700 w-full shadow-sm" href="https://bit.ly/3qdjkQs" target="_blank">Konsultasi Gratis</a>
                        </div>
                        <div>
                            <a class="btn text-blue-600 bg-white hover:bg-blue-100 hover:text-blue-600 w-full shadow-sm" href="{{ url('/') }}#pantau-servis">Pantau Servis</a>
                        </div>
                    </div>
                    <!-- Stats -->
                    {{-- <div class="inline-flex items-center space-x-4 md:space-x-6" data-aos="fade-right" data-aos-delay="400">
                        <div>
                            <div class="font-cabinet-grotesk text-2xl font-extrabold">27M</div>
                            <div class="text-gray-500">Inspiration</div>
                        </div>
                        <svg class="fill-gray-300" width="14" height="10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.039 0c.099.006 1.237.621 1.649.787.391.17.735.41 1.067.667.682.515 1.387.995 2.089 1.48.102.071.196.153.284.245l.497-.172 1.76-.342.13-.097a.402.402 0 0 1 .206-.09l.107-.012c.218-.035.677-.132 1.143-.122l1.11-.062c.16-.001 1.67.295 1.691.339a.639.639 0 0 1 .026.129c.018.125-.035.29.09.352.045.022.167.292.084.41l-.137.203a.726.726 0 0 1-.147.164 5.18 5.18 0 0 1-.658.404l-.182.089a.534.534 0 0 0-.257.327c-.046.133-.134.134-.204.189-.376.26-.736.581-1.102.868L11 5.965l.219.284.55.784c.093.129.187.255.286.375.052.073.137.1.147.242.022.324.182.399.314.529.184.179.363.368.528.581.081.107.123.285.179.437.049.138-.138.362-.186.37-.137.023-.128.197-.178.312a.618.618 0 0 1-.058.116c-.03.034-1.375-.105-1.67-.162l-.09-.028-1.004-.368c-.552-.157-1.05-.462-1.167-.498-.117-.043-.19-.173-.275-.278l-1.604-.847c-.138-.113-.294-.199-.433-.311l-.162.083-.174.068c-.8.26-1.602.514-2.39.808-.385.15-.778.278-1.198.327-.439.038-1.692.294-1.788.271a3.114 3.114 0 0 1-.505-.227c-.09-.049-.306-.58-.324-.78-.056-.628.013-1.007.285-.96.11.02.29-.51.395-.536.06-.016.165-.088.287-.182l.334-.266c.157-.126.297-.234.363-.252.697-.205 1.325-.62 2.004-.878l.063-.035.07-.057-.01-.013a.425.425 0 0 0-.094-.115c-.586-.448-1.082-1.031-1.7-1.434-.058-.036-.165-.181-.284-.349L1.55 2.72c-.12-.168-.233-.316-.3-.356-.095-.056-.131-.619-.24-.632C.734 1.696.765 1.31.982.725 1.05.537 1.396.09 1.495.07c.192-.037.38-.07.544-.07Z" fill-rule="evenodd" />
                        </svg>
                        <div>
                            <div class="font-cabinet-grotesk text-2xl font-extrabold">44K</div>
                            <div class="text-gray-500">Collections</div>
                        </div>
                        <svg class="fill-gray-300" width="14" height="10" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.039 0c.099.006 1.237.621 1.649.787.391.17.735.41 1.067.667.682.515 1.387.995 2.089 1.48.102.071.196.153.284.245l.497-.172 1.76-.342.13-.097a.402.402 0 0 1 .206-.09l.107-.012c.218-.035.677-.132 1.143-.122l1.11-.062c.16-.001 1.67.295 1.691.339a.639.639 0 0 1 .026.129c.018.125-.035.29.09.352.045.022.167.292.084.41l-.137.203a.726.726 0 0 1-.147.164 5.18 5.18 0 0 1-.658.404l-.182.089a.534.534 0 0 0-.257.327c-.046.133-.134.134-.204.189-.376.26-.736.581-1.102.868L11 5.965l.219.284.55.784c.093.129.187.255.286.375.052.073.137.1.147.242.022.324.182.399.314.529.184.179.363.368.528.581.081.107.123.285.179.437.049.138-.138.362-.186.37-.137.023-.128.197-.178.312a.618.618 0 0 1-.058.116c-.03.034-1.375-.105-1.67-.162l-.09-.028-1.004-.368c-.552-.157-1.05-.462-1.167-.498-.117-.043-.19-.173-.275-.278l-1.604-.847c-.138-.113-.294-.199-.433-.311l-.162.083-.174.068c-.8.26-1.602.514-2.39.808-.385.15-.778.278-1.198.327-.439.038-1.692.294-1.788.271a3.114 3.114 0 0 1-.505-.227c-.09-.049-.306-.58-.324-.78-.056-.628.013-1.007.285-.96.11.02.29-.51.395-.536.06-.016.165-.088.287-.182l.334-.266c.157-.126.297-.234.363-.252.697-.205 1.325-.62 2.004-.878l.063-.035.07-.057-.01-.013a.425.425 0 0 0-.094-.115c-.586-.448-1.082-1.031-1.7-1.434-.058-.036-.165-.181-.284-.349L1.55 2.72c-.12-.168-.233-.316-.3-.356-.095-.056-.131-.619-.24-.632C.734 1.696.765 1.31.982.725 1.05.537 1.396.09 1.495.07c.192-.037.38-.07.544-.07Z" fill-rule="evenodd" />
                        </svg>
                        <div>
                            <div class="font-cabinet-grotesk text-2xl font-extrabold">2M+</div>
                            <div class="text-gray-500">Creatives</div>
                        </div>
                    </div> --}}
                </div>

                <!-- Image -->
                <div class="max-w-sm mx-auto md:max-w-none md:absolute md:left-[25rem] md:ml-16 lg:ml-32 xl:ml-52 mt-12 md:-mt-12" data-aos="fade-left" data-aos-duration="1100">
                  <img src="{{ asset('/assets/frontsite/images/hero-image.png') }}" class="md:max-w-none" width="554" height="629" alt="Hero Illustration" />
                </div>

            </div>

        </div>
    </div>
  </section>
  {{-- End Hero --}}

  <section>
    <div class="max-w-6xl py-20 mx-auto px-4 sm:px-6">
        <div class="pt-10 pb-10 md:pt-16 md:pb-18">

            <!-- Section header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h2 class="h2 mb-4 text-gray-800" data-aos="fade-up">Mengapa percaya kami?</h2>
                <p class="text-xl text-gray-600" data-aos="fade-up" data-aos-delay="200">Kami adalah pilihan yang tepat untuk kebutuhan perbaikan device Anda.</p>
            </div>

            <!-- Items -->
            <div class="max-w-sm mx-auto grid gap-8 md:grid-cols-3 lg:gap-16 items-start md:max-w-none">

                <!-- 1st item -->
                <div class="relative flex flex-col items-center" data-aos="fade-up">
                    <div class="w-16 h-16 mb-4 bg-blue-600 rounded-full flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path class="stroke-current text-white" stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                      </svg>
                    </div>
                    <h4 class="h4 mb-2">Berpengalaman</h4>
                    <p class="text-lg text-gray-600 text-center">Teknisi yang berpengalaman seusai dengan bidang spesialis pengerjaan masing-masing.</p>
                </div>

                <!-- 2nd item -->
                <div class="relative flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 mb-4 bg-blue-600 rounded-full flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path class="stroke-current text-white" stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                    <h4 class="h4 mb-2">Murah dan Jujur</h4>
                    <p class="text-lg text-gray-600 text-center">Kami menjanjikan harga yang ditawarkan dapat bersaing dan tetap mengutamakan kualitas.</p>
                </div>

                <!-- 3rd item -->
                <div class="relative flex flex-col items-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 mb-4 bg-blue-600 rounded-full flex items-center justify-center">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path class="stroke-current text-white" stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                      </svg>
                    </div>
                    <h4 class="h4 mb-2">Berkualitas & Bergaransi</h4>
                    <p class="text-lg text-gray-600 text-center">Kami memberikan pelayanan service profesional dengan menyediakan sparepart berkualitas dan bergaransi.</p>
                </div>

            </div>

        </div>
    </div>
  </section>

  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="py-12 md:py-20 border-t border-gray-200">

            <!-- Section header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h2 class="h2 mb-4 text-gray-800">Now Open</h2>
                <p class="text-xl text-gray-600" data-aos="fade-up" data-aos-delay="200">Datang langsung ke tempat?</p>
            </div>

            <!-- Items -->
            <div class="max-w-sm mx-auto grid gap-8 md:grid-cols-3 lg:gap-16 items-start md:max-w-none">

                <!-- 1st item -->
                <a class="flex flex-col p-5 group text-white bg-gradient-to-tr from-blue-600 to-blue-500 shadow-2xl" href="{{ url('https://maps.app.goo.gl/N6x1LwXyhq2tHprW9') }}" target="_blank" data-aos="fade-down" data-aos-anchor="[data-aos-id-featbl]">
                    <div class="text-xl font-bold mb-1">Kediri</div>
                    <div class="grow opacity-80 mb-4">Jl. Joyoboyo No.22, Karangrejo, Kec. Ngasem, Kabupaten Kediri, Jawa Timur 64182</div>
                    <svg class="w-6 h-6 self-end transform -translate-x-2 group-hover:translate-x-0 transition duration-150 ease-in-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-current" d="M13 11V5.057L22.72 12 13 18.943V13H2v-2h11zm2 4.057L19.28 12 15 8.943v6.114z" />
                    </svg>
                </a>

                <!-- 2nd item -->
                <a class="flex flex-col p-5 group text-white bg-gradient-to-tr from-blue-600 to-blue-500 shadow-2xl" href="{{ url('https://maps.app.goo.gl/5HnCHZx66EftZonq5') }}" target="_blank" data-aos="fade-down" data-aos-anchor="[data-aos-id-featbl]" data-aos-delay="100">
                    <div class="text-xl font-bold mb-1">Kediri</div>
                    <div class="grow opacity-80 mb-4">Jl. Tunggul Wulung, Karangrejo, Kec. Ngasem, Kabupaten Kediri, Jawa Timur 64182</div>
                    <svg class="w-6 h-6 self-end transform -translate-x-2 group-hover:translate-x-0 transition duration-150 ease-in-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-current" d="M13 11V5.057L22.72 12 13 18.943V13H2v-2h11zm2 4.057L19.28 12 15 8.943v6.114z" />
                    </svg>
                </a>

                <!-- 3rd item -->
                <a class="flex flex-col p-5 group text-white bg-gradient-to-tr from-blue-600 to-blue-500 shadow-2xl" href="{{ url('https://goo.gl/maps/VgGUDwmvdbbHrF73A') }}" target="_blank" data-aos="fade-down" data-aos-anchor="[data-aos-id-featbl]" data-aos-delay="200">
                    <div class="text-xl font-bold mb-1">Pare</div>
                    <div class="grow opacity-80 mb-4">Bendo Lor, Bendo, Kec. Pare, Kabupaten Kediri, Jawa Timur 64225</div>
                    <svg class="w-6 h-6 self-end transform -translate-x-2 group-hover:translate-x-0 transition duration-150 ease-in-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-current" d="M13 11V5.057L22.72 12 13 18.943V13H2v-2h11zm2 4.057L19.28 12 15 8.943v6.114z" />
                    </svg>
                </a>

            </div>

        </div>
    </div>
  </section>

  <section class="bg-gray-50" id="pantau-servis">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <!-- CTA box -->
        <div class="relative py-10 px-8 md:py-16 md:px-12" data-aos="fade-up">

            <div class="relative flex flex-col lg:flex-row justify-between items-center">

                <!-- CTA content -->
                <div class="mb-6 lg:mr-16 lg:mb-0 text-center lg:text-left lg:w-1/2">
                    <h3 class="h3 text-gray-800 mb-2">Pantau Perbaikan Anda</h3>
                    <p class="text-gray-500 text-lg">Setelah servis telah kami terima, Anda dapat memantau perbaikan dengan memasukan nomer HP yang telah Anda berikan pada saat pendataan servis.</p>
                </div>

                <!-- CTA form --> 
                <form action="{{ route('tracking.track') }}" method="POST" class="w-full lg:w-1/2">
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
                    <div class="flex flex-col sm:flex-row justify-center max-w-xs mx-auto sm:max-w-md lg:max-w-none">
                        <input class="text-gray-500 border-blue-500 focus:border-blue-300 w-full mb-2 sm:mb-0 sm:mr-2 rounded-sm" type="tel" id="contact" type="text" name="contact" placeholder="Masukan Nomer Hp Anda Diawali 62" required>
                        <button class="btn text-white bg-blue-600 hover:bg-blue-700 shadow" type="submit">Pantau</button>
                    </div>
                </form>

            </div>

        </div>

    </div>
  </section>

  <!-- Features zigzag -->
  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="py-12 md:py-20">

            <!-- Section header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                <h2 class="h2 mb-4 text-gray-800">Cara Kerja</h2>
                <p class="text-xl text-gray-600">Servis handphone Anda
                  di rumah atau kantor Anda dengan 3 cara mudah ini.</p>
            </div>

            <!-- Items -->
            <div class="grid gap-20">

                <!-- 1st item -->
                <div class="md:grid md:grid-cols-12 md:gap-6 items-center">
                    <!-- Image -->
                    <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-5 lg:col-span-6 mb-8 md:mb-0 md:order-1" data-aos="fade-up">
                        <img class="max-w-full mx-auto md:max-w-none h-auto" src="{{ asset('/assets/frontsite/images/step1.png') }}" width="520" height="385" alt="Features 01" />
                    </div>
                    <!-- Content -->
                    <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-7 lg:col-span-6" data-aos="fade-right">
                        <div class="md:pr-4 lg:pr-12 xl:pr-16">
                            <h3 class="h3 mb-3 text-gray-800">1. Konsultasi</h3>
                            <p class="text-xl text-gray-600 mb-4">Konsultasikan masalah handphone Anda melalui whatsapp Kami.</p>
                            <ul class="text-lg text-gray-600 -mb-2">
                                <li class="flex items-center mb-2">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span>Kami akan melakukan diagnosa tahap awal.</span>
                                </li>
                                <li class="flex items-center mb-2">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span>Kami akan memberikan kemungkinan perbaikan yang dibutuhkan.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 2nd item -->
                <div class="md:grid md:grid-cols-12 md:gap-6 items-center">
                    <!-- Image -->
                    <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-5 lg:col-span-6 mb-8 md:mb-0 rtl" data-aos="fade-up">
                        <img class="max-w-full mx-auto md:max-w-none h-auto" src="{{ asset('/assets/frontsite/images/step2.png') }}" width="540" height="405" alt="Features 02" />
                    </div>
                    <!-- Content -->
                    <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-7 lg:col-span-6" data-aos="fade-left">
                        <div class="md:pl-4 lg:pl-12 xl:pl-16">
                            <h3 class="h3 mb-3 text-gray-800">2. Jadwalkan Servis</h3>
                            <p class="text-xl text-gray-600 mb-4">Berikan lokasi dan waktu sesuai keinginan Anda.</p>
                            <ul class="text-lg text-gray-600 -mb-2">
                                <li class="flex items-center mb-2">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span> Kami akan mempersiapkan kebutuhan perbaikan Anda.</span>
                                </li>
                                <li class="flex items-center mb-2">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span> Kami akan membuat jadwal kunjungan ke tempat Anda.</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span> Memberikan estimasi biaya & kesepakatan untuk perbaikan Anda.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 3rd item -->
                <div class="md:grid md:grid-cols-12 md:gap-6 items-center">
                    <!-- Image -->
                    <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-5 lg:col-span-6 mb-8 md:mb-0 md:order-1" data-aos="fade-up">
                        <img class="max-w-full mx-auto md:max-w-none h-auto" src="{{ asset('/assets/frontsite/images/step3.png') }}" width="520" height="485" alt="Features 03" />
                    </div>
                    <!-- Content -->
                    <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-7 lg:col-span-6" data-aos="fade-right">
                        <div class="md:pr-4 lg:pr-12 xl:pr-16">
                            <h3 class="h3 mb-3 text-gray-800">3. Device Anda di Servis</h3>
                            <p class="text-xl text-gray-600 mb-4">Teknisi kami akan datang dan menservis device Anda.</p>
                            <ul class="text-lg text-gray-600 -mb-2">
                                <li class="flex items-center mb-2">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span> Kami melakukan diagnosa tahap lanjut langsung.</span>
                                </li>
                                <li class="flex items-center mb-2">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span> Melakukan perbaikan sesuai kerusakan yang terjadi.</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 fill-current text-green-500 mr-2 shrink-0" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z" />
                                    </svg>
                                    <span> Kami memastikan perbaikan & device Anda normal kembali.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
  </section>

  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="py-12 md:py-20 border-t border-gray-200">

            <!-- Section content -->
            <div class="relative max-w-xl mx-auto md:max-w-none text-center md:text-left flex flex-col md:flex-row items-center">

                <!-- Content -->
                <div class="w-[512px] max-w-full shrink-0">

                    <!-- Copy -->
                    <h2 class="h2 mb-4 text-gray-800" data-aos="fade-up" data-aos-anchor="[data-aos-id-4]" data-aos-delay="100">Kerusakan device yang sering kami tangani</h2>
                    <p class="text-lg text-gray-800 mb-6" data-aos="fade-up" data-aos-anchor="[data-aos-id-4]" data-aos-delay="200">Mungkin sekarang kamu sedang mengalaminya! </p>

                    <!-- Lists -->
                    <div class="sm:columns-2 mb-8 space-y-8 sm:space-y-0" data-aos="fade-up" data-aos-anchor="[data-aos-id-4]" data-aos-delay="300">
                        <!-- Column #1 -->
                        <div>
                            <h5 class="font-bold mb-5">Kerusakan Hardware</h5>
                            <ul class="inline-flex flex-col text-gray-800 space-y-2.5">
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Layar pecah</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Sentuh tidak fungsi</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Baterai boros/mengembung</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Tidak bisa charger</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Tombol tidak berfungsi</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Kamera buram/blank</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>IC Rusak (Ganti EMMC, Power, dll)</span>
                                </li>
                            </ul>
                        </div>
                        <!-- Column #2 -->
                        <div>
                            <h5 class="font-bold mb-5">Kerusakan Software</h5>
                            <ul class="inline-flex flex-col text-gray-800 space-y-2.5">
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Flash semua tipe</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Bootloop/Stuck logo</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Stuck recovery</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Imei Null</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="shrink-0 mr-3" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                                        <circle class="fill-blue-100" cx="10" cy="10" r="10" />
                                        <path class="fill-blue-600" d="M15.335 7.933 14.87 7c-4.025 1.167-6.067 3.733-6.067 3.733l-1.867-1.4-.933.934L8.802 14c2.158-4.025 6.533-6.067 6.533-6.067Z" />
                                    </svg>
                                    <span>Brick/Unbrick</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- Image -->
                <div class="w-full max-w-sm md:max-w-none md:ml-8 mt-8 md:mt-0">
                    <div class="relative -mx-8 md:mx-0">
                        <img src="{{ asset('/assets/frontsite/images/kerusakan.jpg') }}" class="md:max-w-none ml-auto" width="496" height="496" alt="Features 04" data-aos="fade-up" data-aos-anchor="[data-aos-id-4]" />
                    </div>
                </div>

            </div>

        </div>
    </div>
  </section>

  <!-- Cta -->
  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pb-12 md:pb-20">

            <!-- CTA box -->
            <div class="bg-blue-600 rounded py-10 px-8 md:py-16 md:px-12 shadow-2xl" data-aos="zoom-y-out">
    
                <div class="flex flex-col lg:flex-row justify-between items-center">
    
                    <!-- CTA content -->
                    <div class="mb-6 lg:mr-16 lg:mb-0 text-center lg:text-left">
                        <h3 class="h3 text-white mb-2">Tunggu apa lagi?</h3>
                        <p class="text-white text-lg opacity-75">Konsultasikan kepada kami segala keluhan device kamu.</p>
                    </div>
    
                    <!-- CTA button -->
                    <div>
                        <a class="btn text-blue-600 bg-gradient-to-r from-blue-100 to-white" href="#0">Konsultasi Gratis</a>
                    </div>
    
                </div>
    
            </div>

        </div>
    </div>
  </section>

@endsection
