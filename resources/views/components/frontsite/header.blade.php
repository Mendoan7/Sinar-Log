{{-- <!-- Header -->
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
                    <a href="/" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mr-4 hover:text-blue-700 focus:no-underline">
                        Home
                    </a>
                    <a href="/tracking" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mx-4 hover:text-blue-700 focus:no-underline">
                        Pantau Servis
                    </a>
                    <a href="#" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mx-4 hover:text-blue-700 focus:no-underline">
                        Layanan
                    </a>
                    <a href="#" class="box-border inline-block text-center text-gray-800 no-underline bg-transparent cursor-pointer md:mx-4 hover:text-blue-700 focus:no-underline">
                        Tentang Kami
                    </a>
                    <a href="#" class="inline-block px-5 py-4 text-lg font-medium text-center text-white bg-blue-600 shadow-xl md:hidden hover:bg-blue-700 rounded-2xl" data-rounded="rounded-2xl">Sign Up</a>
                </div>
                <div class="relative hidden mt-2 font-medium leading-10 md:inline-block lg:flex-grow-0 lg:flex-shrink-0 lg:mt-0 lg:text-right">
                    <a href="#" class="px-5 py-4 text-lg font-medium text-white bg-blue-600 shadow-xl hover:bg-blue-700 rounded-2xl" data-primary="purple-600">Sign Up</a>
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
<!-- End Header --> --}}
  
<!-- Site header -->
<header class="fixed w-full z-30 md:bg-opacity-90 transition duration-300 ease-in-out" x-data="{ top: true }" @scroll.window="top = window.pageYOffset > 10 ? false : true" :class="{ 'bg-white backdrop-blur-sm shadow-lg' : !top }">
    <div class="max-w-6xl mx-auto px-5 sm:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">

            <!-- Site branding -->
            <div class="shrink-0 mr-4">
                <!-- Logo -->
                <img
                    class="h-10 lg:h-14 w-auto"
                    src="{{ asset('/assets/frontsite/images/logo.png') }}"
                    alt="Sinar Cell Logo"/>
            </div>

            <!-- Desktop navigation -->
            <nav class="hidden md:flex md:grow">

                <!-- Desktop menu links -->
                <ul class="flex grow justify-end flex-wrap items-center">
                    <li>
                        <a class="text-gray-800 hover:text-blue-700 px-3 lg:px-5 py-2 flex items-center transition duration-150 ease-in-out" href="/">Home</a>
                    </li>
                    <li>
                        <a class="text-gray-800 hover:text-blue-700 px-3 lg:px-5 py-2 flex items-center transition duration-150 ease-in-out" href="/tracking">Pantau Servis</a>
                    </li>
                    <li>
                        <a class="text-gray-800 hover:text-blue-700 px-3 lg:px-5 py-2 flex items-center transition duration-150 ease-in-out" href="#">Layanan</a>
                    </li>
                    <li>
                        <a class="text-gray-800 hover:text-blue-700 px-3 lg:px-5 py-2 flex items-center transition duration-150 ease-in-out" href="#">Tentang Kami</a>
                    </li>
                </ul>

                <!-- Desktop sign in links -->
                <ul class="flex grow justify-end flex-wrap items-center">
                    <li>
                        <a class="font-medium text-gray-800 hover:text-blue-700 px-5 py-3 flex items-center transition duration-150 ease-in-out" href="signin.html">Sign in</a>
                    </li>
                    <li>
                        <a class="btn-sm text-white bg-blue-600 hover:bg-blue-700 ml-3" href="signup.html">
                            <span>Sign up</span>
                            <svg class="w-3 h-3 fill-current text-white shrink-0 ml-2 -mr-1" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.707 5.293L7 .586 5.586 2l3 3H0v2h8.586l-3 3L7 11.414l4.707-4.707a1 1 0 000-1.414z" fill-rule="nonzero" />
                            </svg>
                        </a>
                    </li>
                </ul>

            </nav>
            
            <!-- Mobile menu -->
            <div class="flex md:hidden" x-data="{ expanded: false }">

                <!-- Hamburger button -->
                <button
                    class="hamburger"
                    :class="{ 'active': expanded }"
                    @click.stop="expanded = !expanded"
                    aria-controls="mobile-nav"
                    :aria-expanded="expanded"
                >
                    <span class="sr-only">Menu</span>
                    <svg class="w-6 h-6 fill-current text-gray-900" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect y="4" width="24" height="2" />
                        <rect y="11" width="24" height="2" />
                        <rect y="18" width="24" height="2" />
                    </svg>
                </button>

                <!-- Mobile navigation -->
                <nav
                    id="mobile-nav"
                    class="absolute top-full h-screen pb-16 z-20 left-0 w-full overflow-scroll bg-white"
                    @click.outside="expanded = false"
                    @keydown.escape.window="expanded = false"
                    x-show="expanded"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"                    
                    x-cloak
                >
                    <ul class="px-5 py-2">
                        <li>
                            <a class="flex text-gray-800 hover:text-blue-700 py-2" href="pricing.html">Pricing</a>
                        </li>
                        <li>
                            <a class="flex text-gray-800 hover:text-blue-700 py-2" href="about.html">About us</a>
                        </li>
                        <li>
                            <a class="flex text-gray-800 hover:text-blue-700 py-2" href="tutorials.html">Tutorials</a>
                        </li>
                        <li>
                            <a class="flex text-gray-800 hover:text-blue-700 py-2" href="blog.html">Blog</a>
                        </li>
                        <li>
                            <a class="flex font-medium w-full text-gray-800 hover:text-blue-700 py-2 justify-center" href="signin.html">Sign in</a>
                        </li>
                        <li>
                            <a class="btn-sm text-gray-200 bg-blue-700 hover:bg-blue-600 w-full my-2" href="signup.html">
                                <span>Sign up</span>
                                <svg class="w-3 h-3 fill-current text-gray-400 shrink-0 ml-2 -mr-1" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.707 5.293L7 .586 5.586 2l3 3H0v2h8.586l-3 3L7 11.414l4.707-4.707a1 1 0 000-1.414z" fill="#999" fill-rule="nonzero" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

        </div>
    </div>
</header>
