<div class="bg-[url('/public/img/shopping.jpg')]">
    <div class="hero min-h-screen">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h1 class="text-4xl text-white font-bold">Make your shopping life easier with ShopCulator.</h1>
                <p class="py-6 text-white">With ShopCulator, an easier shopping budget management experience is at your fingertips. Save more time and money with ShopCulator.</p>
                <!-- Buttons -->
                <div class="flex max-w-sm space-x-8 items-center mx-auto">
                    @if (Route::has('login'))
                    @auth
                    <button class="btn btn-ghost text-emerald-300 px-6 py-2 border-2 solid border-emerald-300 rounded-full hover:bg-gray-700 hover:opacity-75 hover:border-emerald-300">
                        <a href="{{ route('shopping-lists') }}">
                            <i class="fa-regular fa-eye"></i>&nbsp;View Lists
                        </a>
                    </button>
                    <button class="btn btn-accent border-none text-emerald-800 px-6 py-2 bg-emerald-300 rounded-full hover:text-emerald-200">
                        <a href="{{ route('create') }}">
                            <i class="fa-solid fa-plus"></i>&nbsp;Create a new list
                        </a>
                    </button>
                    @else
                    <button class="btn btn-ghost text-emerald-300 px-6 py-2 border-2 solid border-emerald-300 rounded-full hover:bg-gray-700 hover:opacity-75 hover:border-emerald-300">
                        <a href="{{ route('login') }}">Sign in</a>
                    </button>
                    <button class="btn btn-accent border-none text-emerald-800 px-6 py-2 bg-emerald-300 rounded-full hover:text-emerald-200">
                        <a href="{{ route('register') }}">Create a free account</a>
                    </button>
                    @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>