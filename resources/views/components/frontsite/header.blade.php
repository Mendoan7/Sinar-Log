<!-- Header -->
<nav x-data="{ navbarMobileOpen: false }" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 lg:px-14 pt-6 lg:py-10">
        <div class="flex justify-between h-10">
            <div class="flex flex-wrap items-center justify-between w-full h-24 text-gray-800 tails-selected-element" x-data="{ showMenu: false }">
                <div class="relative z-10 flex items-center w-auto px-0 leading-10 md:px-2 lg:flex-grow-0 lg:flex-shrink-0 lg:text-left">
                    <img
                    class="h-12 lg:h-16 w-auto"
                    src="{{ asset('/assets/frontsite/images/logo.png') }}"
                    alt="Sinar Cell Logo"/>
                </div>
                <div class="left-0 z-0 flex-col justify-center w-full px-4 space-y-3 font-semibold leading-10 md:space-y-0 lg:flex-grow-0 md:flex-row lg:text-left lg:text-center hidden md:flex absolute" :class="{'flex z-30 top-0 bg-white h-full fixed': showMenu, 'hidden md:flex absolute': !showMenu }">
                    <a href="#_" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mr-4 hover:text-blue-700 focus:no-underline">
                        Home
                    </a>
                    <a href="#_" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mx-4 hover:text-blue-700 focus:no-underline">
                        Pantau Servis
                    </a>
                    <a href="#_" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mx-4 hover:text-blue-700 focus:no-underline">
                        Layanan
                    </a>
                    <a href="#_" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mx-4 hover:text-blue-700 focus:no-underline">
                        Tentang Kami
                    </a>
                    <a href="#_" class="inline-block px-5 py-4 text-lg font-medium text-center text-white bg-blue-600 shadow-xl md:hidden hover:bg-blue-700 rounded-2xl" data-rounded="rounded-2xl">Sign Up</a>
                </div>
                <div class="relative hidden mt-2 font-medium leading-10 md:inline-block lg:flex-grow-0 lg:flex-shrink-0 lg:mt-0 lg:text-right">
                    <a href="#_" class="px-5 py-4 text-lg font-medium text-white bg-blue-600 shadow-xl hover:bg-blue-700 rounded-2xl" data-primary="purple-600">Sign Up</a>
                </div>
            
                <div @click="showMenu = !showMenu" class="absolute right-0 z-40 flex flex-col items-center items-end justify-center w-10 h-10 mr-8 rounded-full cursor-pointer md:hidden hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-700" x-show="!showMenu" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6 text-gray-700" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            
            </div>
        </div>
    </div>
</nav>
<!-- End Header -->
  
