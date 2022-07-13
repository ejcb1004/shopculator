<x-app-layout>
    <!-- Add List Nav -->
    <div class="bg-emerald-700 min-w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="navbar flex flex-row-reverse">
                <!-- Search and Cart Button -->
                <div class="space-x-2">
                    <div class="flex rounded-full bg-white w-full h-10 items-center">
                        <i class="fa-solid fa-magnifying-glass z-99 pl-4 absolute"></i>
                        <input type="text" placeholder="Search" class="input input-bordered bg-white pl-10 w-72 rounded-full h-10" />
                    </div>
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="badge badge-sm badge-secondary indicator-item">1</span>
                            </div>
                        </label>
                        <div tabindex="0" class="mt-3 card card-compact dropdown-content w-52 bg-base-100 shadow">
                            <div class="card-body">
                                <span class="font-bold text-lg">1 Items</span>
                                <span class="text-info">Subtotal: P69</span>
                                <div class="card-actions">
                                    <button class="btn btn-success btn-block">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Page -->
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">

        <!-- Market -->
        <div class="flex justify-end space-x-4">
            <!-- Categories -->
            <div x-data="
              {
                dropdownOpen: false
              }
              " @click.outside="dropdownOpen = false" class="relative mb-8 inline-flex text-left">
                <button @click="dropdownOpen = !dropdownOpen" class="flex bg-white px-4 py-1.5 lg:space-x-24 sm:space-x-6 space-x-4 border-none justify-between shadow-md rounded hover:bg-slate-200 hover:transition hover:duration-300 hover:ease-out">
                    <span class="text-slate-600 font-semibold">Market</span>
                    <span class="text-slate-600 "><i class="fa-solid fa-angle-down"></i></span>
                </button>
                <div :class="dropdownOpen ? 'top-full opacity-100 visible' : 'top-[110%] invisible opacity-0' " class="absolute left-0 z-40 mt-2 w-full rounded border-[.5px] border-light bg-white py-5 shadow-md transition-all">
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        All
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        SM Supermarket
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        AllDay Supermarket
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        EasyMart
                    </a>
                </div>
            </div>
            <div x-data="
              {
                dropdownOpen: false
              }
              " @click.outside="dropdownOpen = false" class="relative mb-8 inline-flex text-left">
                <button @click="dropdownOpen = !dropdownOpen" class="flex bg-white px-4 py-1.5 lg:space-x-24 sm:space-x-6 space-x-4 border-none justify-between shadow-md rounded hover:bg-slate-200 hover:transition hover:duration-300 hover:ease-out">
                    <span class="text-slate-600 font-semibold">Categories</span>
                    <span class="text-slate-600 "><i class="fa-solid fa-angle-down"></i></span>
                </button>
                <div :class="dropdownOpen ? 'top-full opacity-100 visible' : 'top-[110%] invisible opacity-0' " class="absolute left-0 z-40 mt-2 w-full rounded border-[.5px] border-light bg-white py-5 shadow-md transition-all">
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        All
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Food
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Frozen
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Beverages
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Dairy
                    </a>
                </div>
            </div>
            <div x-data="
              {
                dropdownOpen: false
              }
              " @click.outside="dropdownOpen = false" class="relative mb-8 inline-flex text-left">
                <button @click="dropdownOpen = !dropdownOpen" class="flex bg-white px-4 py-1.5 lg:space-x-24 sm:space-x-6 space-x-4 border-none justify-between shadow-md rounded hover:bg-slate-200 hover:transition hover:duration-300 hover:ease-out">
                    <span class="text-slate-600 font-semibold">Sort by</span>
                    <span class="text-slate-600 "><i class="fa-solid fa-angle-down"></i></span>
                </button>
                <div :class="dropdownOpen ? 'top-full opacity-100 visible' : 'top-[110%] invisible opacity-0' " class="absolute left-0 z-40 mt-2 w-full rounded border-[.5px] border-light bg-white py-5 shadow-md transition-all">
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Alphabetical (A-Z)
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Alphabetical (Z-A)
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Price (Ascending)
                    </a>
                    <a href="javascript:void(0)" class="block py-2 px-5 text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                        Price (Descending)
                    </a>
                </div>
            </div>
        </div>
        <!-- Product Table -->
        <div class="pt-1">
            <div class="grid grid-cols-2 grid-flow-row border-2 sm:grid-cols-3 grid-flow-row md:grid-cols-3 grid-flow-row">
                <!-- Products -->
                <div class="border">
                    <div class="grid grid-rows-6 grid-flow-col py-5 px-4 space-y-1 justify-items-center">
                        <div class="row-span-3">Image</div>
                        <div class="text-black">B2 Maling Chicken Luncheon Meat 397g</div>
                        <div class="text-black">197.00</div>
                        <div><button class="flex ml-1 px-12 py-1.5 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300">Add</button></div>
                    </div>
                </div>
                <div class="border">
                    <div class="grid grid-rows-6 grid-flow-col py-5 px-4 space-y-1 justify-items-center">
                        <div class="row-span-3">Image</div>
                        <div class="text-black">B2 Maling Chicken Luncheon Meat 397g</div>
                        <div class="text-black">197.00</div>
                        <div><button class="flex ml-1 px-12 py-1.5 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300">Add</button></div>
                    </div>
                </div>
                <div class="border">
                    <div class="grid grid-rows-6 grid-flow-col py-5 px-4 space-y-1 justify-items-center">
                        <div class="row-span-3">Image</div>
                        <div class="text-black">B2 Maling Chicken Luncheon Meat 397g</div>
                        <div class="text-black">197.00</div>
                        <div><button class="flex ml-1 px-12 py-1.5 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300">Add</button></div>
                    </div>
                </div>
                <div class="border">
                    <div class="grid grid-rows-6 grid-flow-col py-5 px-4 space-y-1 justify-items-center">
                        <div class="row-span-3">Image</div>
                        <div class="text-black">B2 Maling Chicken Luncheon Meat 397g</div>
                        <div class="text-black">197.00</div>
                        <div><button class="flex ml-1 px-12 py-1.5 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300">Add</button></div>
                    </div>
                </div>
                <div class="border">
                    <div class="grid grid-rows-6 grid-flow-col py-5 px-4 space-y-1 justify-items-center">
                        <div class="row-span-3">Image</div>
                        <div class="text-black">B2 Maling Chicken Luncheon Meat 397g</div>
                        <div class="text-black">197.00</div>
                        <div><button class="flex ml-1 px-12 py-1.5 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300">Add</button></div>
                    </div>
                </div>
                <div class="border">
                    <div class="grid grid-rows-6 grid-flow-col py-5 px-4 space-y-1 justify-items-center">
                        <div class="row-span-3">Image</div>
                        <div class="text-black">B2 Maling Chicken Luncheon Meat 397g</div>
                        <div class="text-black">197.00</div>
                        <div><button class="flex ml-1 px-12 py-1.5 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300">Add</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>