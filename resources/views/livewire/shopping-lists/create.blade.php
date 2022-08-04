<div>
    <div class="bg-emerald-700 min-w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="navbar flex flex-row-reverse">
                <!-- Search and Cart Button -->
                <div class="space-x-2">
                    <div class="flex rounded-full bg-white w-full h-10 items-center">
                        <i class="fa-solid fa-magnifying-glass z-1 pl-4 absolute"></i>
                        <input type="text" placeholder="Search" class="input input-bordered bg-white pl-10 w-72 rounded-full h-10" wire:model.debounce.150ms="searchproduct"/>
                    </div>
                    <!-- Cart Dropdown -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="badge badge-sm bg-emerald-400 border-none text-white indicator-item">{{ $items }}</span>
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
                                        <i class="fa-solid fa-peso-sign pl-3 absolute"></i>
                                        <input type="number" placeholder="Enter budget here" class="input input-bordered input-sm bg-white w-full pl-8" wire:model.lazy="budget" />
                                    </div>
                                </div>
                                <hr>
                                <!-- Card Content -->
                                <div class="overflow-y-auto max-h-80">
                                    <!-- Item -->
                                    @foreach ($list_details as $list_detail)
                                    <div class="flex-row max-h-24 px-2 py-2">
                                        <div class="flex space-x-5 items-center">
                                            <div class="flex space-x-2 items-center">
                                                <span class="relative h-2/3 flex rounded-full px-1 bg-emerald-600 text-xs text-white items-center">{{ $list_detail['index'] + 1 }}</span>
                                                <input type="checkbox" class="checkbox checkbox-accent checkbox-sm" value="{{ $list_detail['price'] * $list_detail['quantity'] }}" wire:model="prices" />
                                                <span><img src="{{ $prefix . $list_detail['image_path'] }}" width="100" alt="Image" /></span>
                                            </div>
                                            <div class="flex w-full justify-between">
                                                <div class="flex flex-col">
                                                    <span>{{ $list_detail['product_name'] }}</span>
                                                    <div class="flex flex-row items-center space-x-2">
                                                    <button wire:click="quantity_sub( {{ $list_detail['index'] }} )">
                                                            <i class="fa-solid fa-minus text-emerald-500"></i>
                                                        </button>
                                                        <span class="text-center w-8">{{ $list_detail['quantity'] }}</span>
                                                        <button wire:click="quantity_add( {{ $list_detail['index'] }} )">
                                                            <i class="fa-solid fa-plus text-emerald-500"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <button wire:click="remove_item( {{ $list_detail['index'] }} )">
                                                        <i class="fa-solid fa-xmark text-emerald-500"></i>
                                                    </button>
                                                    <span>₱&nbsp;{{ number_format($list_detail['price'] * $list_detail['quantity'], 2) }}</span>
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
                                            <span class="text-black"><i class="fa-solid fa-peso-sign"></i>&nbsp;{{ number_format(array_sum($prices), 2) }}</span>
                                        </div>
                                        <!-- Card Remaining Budget -->
                                        <div class="flex justify-between">
                                            <span class="text-black">Remaining:</span>
                                            <span class="text-black"><i class="fa-solid fa-peso-sign"></i>&nbsp;{{ number_format($budget - array_sum($prices), 2) }}</span>
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
        <div class="inline-flex justify-start space-x-4 py-3">
            <!-- Categories -->
            <div class="flex justify-start space-x-4 sticky top-32 py-3">
                <!-- Categories -->
                
                <div>
                    <select class="select bg-white text-black w-full max-w-xs" wire:model="selectedmarket">
                        <option value="">Markets (All)</option>
                        @foreach($markets as $market)
                        <option value="{{ $market->market_id }}" class="block py-2 px-5 break-words text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                            {{$market->market_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
            
                
                <div>
                    <select class="select bg-white text-black w-full max-w-xs" wire:model="selectedcategory">
                        <option value="">Categories (All)</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" class="block py-2 px-5 break-words text-base text-slate-600 hover:bg-slate-200 hover:bg-opacity-50">
                            {{$category->category_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
               
                <div>
                    <select class="select bg-white text-black w-full max-w-xs" wire:model="selectedsort">
                        <option disabled selected>Sort By</option>
                        <option value = "asc">Price (Lowest-Highest)</option>
                        <option value = "desc">Price (Highest-Lowest)</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Product Table -->
        <div class="pt-1">
            <div class="grid grid-cols-2 border-2 sm:grid-cols-3 md:grid-cols-4">
                <!-- Products -->
                @foreach ($products as $product)
                <div class="border bg-white">
                    <div class="flex flex-col min-h-full py-5 px-4 space-y-1 items-center">
                        <div class="flex flex-auto items-center">
                            <img src="{{ $prefix . $product->image_path }}" alt="{{ $product->product_name }}" width="125" />
                        </div>
                        <div class="h-1/4 text-black text-center">{{ $product->product_name }}</div>
                        <div class="h-1/4 text-black text-center">PHP {{ $product->price }}</div>
                        <div class="flex w-28 h-9 rounded-full text-white bg-emerald-600 hover:bg-emerald-700 hover:transition hover:duration-300">
                            <button class="rounded-full w-full" wire:click="product_add({{ $product->id }})">
                                Add
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @if(count($products))
        {{ $products->links() }}
        @endif
    </div>
</div>