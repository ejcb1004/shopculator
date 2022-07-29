<div>
    <div class="bg-emerald-700 min-w-full top-[64px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="navbar flex flex-row-reverse">
                <!-- Search and Cart Button -->
                <div class="space-x-2">
                    <div class="flex rounded-full bg-white w-full h-10 items-center">
                        <i class="fa-solid fa-magnifying-glass z-99 pl-4 absolute"></i>
                        <input type="text" placeholder="Search" class="input input-bordered bg-white pl-10 w-72 rounded-full h-10" />
                    </div>
                    <!-- Cart Dropdown -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="badge badge-sm badge-secondary indicator-item">{{$items}}</span>
                            </div>
                        </label>
                        <!-- Card Body/Shopping List Preview -->
                        <div tabindex="0" class="mt-3 card card-compact dropdown-content w-96 bg-white shadow">
                            <!-- Card Header -->
                            <div class="font-bold text-lg bg-emerald-700 px-3 py-3 text-white flex justify-between">
                                <input type="text" placeholder="Shopping List Name" class="input bg-white w-full max-w-xs" />
                                <span class="pr-2"><i class="fa-solid fa-xmark"></i></span>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Card Header -->
                                <div class="flex flex-nowrap py-1">
                                    <div class="flex w-full items-center">
                                        <i class="fa-solid fa-peso-sign pl-3 relative z-1"></i>
                                        <input type="text" placeholder="Enter budget here" value="0" class="input input-bordered input-sm bg-white w-full pl-8" wire:model.lazy="budget" />
                                    </div>
                                </div>
                                <hr>
                                <!-- Card Content -->
                                <div class="overflow-y-auto max-h-80">
                                    <!-- Item -->
                                    @foreach($list_details as $list_detail)
                                    <div class="flex-row max-h-24 px-2 py-2">
                                        <div class="flex space-x-5 items-center">
                                            <div class="flex space-x-2">
                                                <input type="checkbox" class="checkbox checkbox-accent checkbox-sm" />
                                                <span><img src="{{ $prefix . $list_detail['image_path']}}" width="75" alt="Image" /></span>
                                            </div>
                                            <div class="flex w-full justify-between">
                                                <div class="flex flex-col">
                                                    <span>{{ $list_detail['product_name'] }}</span>
                                                    <div class="flex flex-row items-center space-x-2">
                                                        <button wire:click="quantity_sub">
                                                            <i class="fa-solid fa-circle-minus text-emerald-500"></i>
                                                        </button>
                                                        <span class="text-center w-8">{{ $list_detail['quantity'] }}</span>
                                                        <button wire:click="quantity_add">
                                                            <i class="fa-solid fa-circle-plus text-emerald-500"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex flex-wrap items-center">
                                                    <span>₱{{ $list_detail['price'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <hr>
                                <!-- Card Total -->
                                <div class="py-3">
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-black">Total:</span>
                                            <span class="text-black"><i class="fa-solid fa-peso-sign"></i> {{$total}}</span>
                                        </div>
                                        <!-- Card Remaining Budget -->
                                        <div class="flex justify-between">
                                            <span class="text-black">Remaining:</span>
                                            <span class="text-black"><i class="fa-solid fa-peso-sign"></i> {{$budget - $total}}</span>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="card-actions">
                                            <button class="btn btn-success bg-emerald-600 btn-block text-white">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Page -->
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8">
        <!-- Market -->
        <div class="inline-flex justify-start space-x-4 sticky top-32 py-3 z-1">
            <!-- Categories -->
            <div x-data="
                {
                    dropdownOpen: false
                }
                " @click.outside="dropdownOpen = false" class="relative inline-flex text-left">
                <button @click="dropdownOpen = !dropdownOpen" class="flex bg-white px-4 py-1.5 lg:space-x-24 sm:space-x-6 space-x-4 border-none justify-between shadow-md rounded hover:bg-slate-100 hover:transition hover:duration-300 hover:ease-out">
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
                " @click.outside="dropdownOpen = false" class="relative inline-flex text-left">
                <button @click="dropdownOpen = !dropdownOpen" class="flex bg-white px-4 py-1.5 lg:space-x-24 sm:space-x-6 space-x-4 border-none justify-between shadow-md rounded hover:bg-slate-100 hover:transition hover:duration-300 hover:ease-out">
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
                " @click.outside="dropdownOpen = false" class="relative inline-flex text-left">
                <button @click="dropdownOpen = !dropdownOpen" class="flex bg-white px-4 py-1.5 lg:space-x-24 sm:space-x-6 space-x-4 border-none justify-between shadow-md rounded hover:bg-slate-100 hover:transition hover:duration-300 hover:ease-out">
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
            <button wire:click="inspect_ld">Inspect List Details</button>
            <button wire:click="inspect_pr">Inspect Product Data</button>
        </div>
        <!-- Product Table -->
        <div class="pt-1">
            <div class="grid grid-cols-2 grid-flow-row border-2 sm:grid-cols-3 grid-flow-row md:grid-cols-4 grid-flow-row">
                <!-- Products -->
                @foreach ($products as $product) 
                <div class="border bg-white">
                    <div class="flex flex-col min-h-full py-5 px-4 space-y-1 items-center">
                        <div class="flex flex-auto items-center">
                            <img src="{{ $prefix . $product->image_path }}" alt="Image" />
                        </div>
                        <div class="h-1/4 text-black text-center">{{ $product->product_name }}</div>
                        <div class="h-1/4 text-black text-center">PHP {{ $product->price }}</div>
                        <div><button class="flex ml-1 px-12 py-1.5 rounded-full text-white bg-teal-600 hover:bg-teal-700 hover:transition hover:duration-300" wire:click="product_add({{ $product->id }})">Add</button></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>