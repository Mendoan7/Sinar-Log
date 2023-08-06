<!-- Site header -->
<header class="fixed w-full z-30 md:bg-opacity-90 transition duration-300 ease-in-out" x-data="{ top: true }" @scroll.window="top = window.pageYOffset > 10 ? false : true" :class="{ 'bg-white backdrop-blur-sm shadow-lg' : !top }">
    <div class="max-w-6xl mx-auto px-5 sm:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">

            <!-- Site branding -->
            <div class="shrink-0 mr-4">
                <!-- Logo -->
                <a href="/" aria-label="Sinarcell">
                <img
                    class="h-10 lg:h-14 w-auto"
                    src="{{ asset('/assets/frontsite/images/logo.png') }}"
                    alt="Sinar Cell Logo"/>
                </a>
                
            </div>

            <!-- Desktop navigation -->
            <nav class="hidden md:flex md:grow">

                <!-- Desktop sign in links -->
                <ul class="flex grow justify-end flex-wrap items-center">
                    <li>
                        <a class="font-medium text-gray-800 hover:text-blue-700 px-5 py-3 flex items-center transition duration-150 ease-in-out" href="/tracking">Pantau Servis</a>
                    </li>
                    <li>
                        <a class="btn-sm text-white bg-blue-600 hover:bg-blue-700 ml-3" href="https://bit.ly/3qdjkQs" target="_blank">
                            <span>Konsultasi</span>
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
                            <a class="flex font-medium w-full text-gray-800 hover:text-blue-700 py-2 justify-center" href="signin.html">Pantau Servis</a>
                        </li>
                        <li>
                            <a class="btn-sm text-gray-200 bg-blue-700 hover:bg-blue-600 w-full my-2" href="signup.html">
                                <span>Konsultasi Gratis</span>
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
