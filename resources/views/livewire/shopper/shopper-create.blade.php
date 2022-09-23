<div>
    @if ($errors->any())
    <div class="bg-red-600">
        <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center min-w-0">
                    <span class="flex p-2 rounded-lg bg-red-500">
                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    @foreach ($errors->all() as $error)
                    <p class="ml-3 font-medium text-sm text-white truncate">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($product_added)
    <div class="bg-emerald-600">
        <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center min-w-0">
                    <span class="flex p-2 rounded-lg bg-emerald-500">
                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <p class="ml-3 font-medium text-sm text-white truncate">
                        <span>{{ $this->get_product_name($new_detail['product_id']) }} has been added to your list.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($comp_added)
    <div class="bg-emerald-600">
        <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center min-w-0">
                    <span class="flex p-2 rounded-lg bg-emerald-500">
                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <p class="ml-3 font-medium text-sm text-white truncate">
                        <span>{{ $this->get_product_name($newcompare_detail['product_id']) }} has been added for comparison.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <form wire:submit.prevent="store" enctype="multipart/form-data">
        @csrf
        <x-jet-confirmation-modal wire:model="to_confirm">
            <x-slot name="title">
                Save List
            </x-slot>

            <x-slot name="content">
                Are you sure you want to save this list?
            </x-slot>

            <x-slot name="footer">
                <button class="sc-btn-ghost" type="button" wire:click="$toggle('to_confirm')" wire:loading.attr="disabled">
                    <span>No</span>
                </button>

                <button class="sc-btn-primary ml-3" type="submit" wire:target="store" wire:loading.attr="disabled">
                    <span>Save</span>
                </button>
            </x-slot>
        </x-jet-confirmation-modal>
    </form>
    <!-- Content Page -->
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="flex justify-end">
                <div class="mt-1 fixed flex flex-col w-[70px] justify-end space-y-2">
                    <!-- Cart Dropdown -->
                    <div class="dropdown dropdown-left">
                        <label tabindex="0" class="btn btn-ghost btn-circle btn-lg">
                            <div class="indicator relative left-5 bottom-2">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <span class="relative top-4 right-2 text-xs normal-case leading-none">Search</span>
                        </label>
                        <div tabindex="0" class="card card-compact dropdown-content w-96 bg-white shadow-md ml-3 rounded-full">
                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Card Content -->
                                <div class="flex rounded-full bg-white w-full h-6 items-center">
                                    <i class="fa-solid fa-magnifying-glass z-1 pl-4 absolute"></i>
                                    <input type="text" placeholder="Search for products" class="input input-bordered bg-white pl-10 w-full rounded-full h-10" wire:model.debounce.150ms="searchproduct" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown dropdown-left">
                        <label tabindex="1" class="btn btn-ghost btn-circle btn-lg">
                            <div class="indicator relative left-3 bottom-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#94a3b8">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="badge badge-sm bg-emerald-400 border-none text-white indicator-item">{{ $items }}</span>
                            </div>
                            <span class="relative top-5 right-4 text-xs normal-case leading-none">Cart</span>
                        </label>
                        <div tabindex="1" class="card card-compact dropdown-content w-96 bg-white shadow ml-3">
                            <!-- Card Header -->
                            <div class="font-bold text-lg bg-emerald-700 px-3 py-3 flex justify-between">
                                <input type="text" name="list_name" id="list_name" placeholder="Shopping List Name" class="input input-sm bg-white w-full max-w-xs" wire:model.lazy="list_name" />
                                <span class="pr-2"></span>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body max-h-[440px]">
                                <!-- Card Header -->
                                <div class="flex flex-nowrap py-1">
                                    <div class="flex w-full items-center">
                                        <i class="fa-solid fa-peso-sign pl-3 absolute"></i>
                                        <input type="number" name="budget" id="budget" placeholder="Enter budget here" min="0" class="input input-bordered input-sm bg-white w-full pl-8" wire:model.lazy="budget" />
                                    </div>
                                </div>
                                <hr>
                                <!-- Card Content -->
                                <div class="overflow-y-auto max-h-96">
                                    <!-- Item -->
                                    @forelse ($list_details as $list_detail)
                                    <div class="flex flex-row max-h-24 px-2 py-2">
                                        <div class="flex space-x-5 items-center">
                                            <div class="flex space-x-2 items-center">
                                                <span class="relative h-2/3 flex rounded-full px-1 bg-emerald-600 text-xs text-white items-center">{{ $list_detail['list_index'] + 1 }}</span>
                                                <input type="checkbox" class="checkbox checkbox-accent checkbox-sm" value="{{ $list_detail['product_id'] }}" wire:model="productchecked" />
                                                <span><img src="{{ $list_detail['image_path'] }}" width="100" alt="Image" /></span>
                                            </div>
                                            <div class="flex w-full justify-between">
                                                <div class="flex flex-col">
                                                    <span>{{ $list_detail['product_name'] }}</span>
                                                    <div class="flex flex-row items-center space-x-2">
                                                        <button type="button" wire:click="quantity_sub( {{ $list_detail['list_index'] }} )">
                                                            <i class="fa-solid fa-minus text-emerald-500"></i>
                                                        </button>
                                                        <span class="text-center w-8">{{ $list_detail['quantity'] }}</span>
                                                        <button type="button" wire:click="quantity_add( {{ $list_detail['list_index'] }} )">
                                                            <i class="fa-solid fa-plus text-emerald-500"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <button type="button" wire:click="remove_item( {{ $list_detail['list_index'] }} )">
                                                        <i class="fa-solid fa-xmark text-emerald-500"></i>
                                                    </button>
                                                    <span>₱&nbsp;{{ number_format($list_detail['price'] * $list_detail['quantity'], 2, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <span class="flex-row max-h-24 px-2 py-2 italic flex justify-center">Add items here</span>
                                    @endforelse
                                </div>
                                <hr>
                                <!-- Card Total -->
                                <div class="py-3">
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-black">Total:</span>
                                            <span class="text-black"><i class="fa-solid fa-peso-sign"></i>&nbsp;{{ number_format($total, 2, '.', ',') }}</span>
                                        </div>
                                        <!-- Card Remaining Budget -->
                                        <div class="flex justify-between">
                                            <span class="text-black">Remaining:</span>
                                            <span><i class="fa-solid fa-peso-sign text-black"></i>
                                                @if( !empty($budget) )
                                                @if (number_format($budget - $total, 2) < 0) <span class="text-red-600">{{ number_format($budget - $total, 2, '.', ',') }}</span>
                                            @else <span class="text-black">{{ number_format($budget - $total, 2, '.', ',') }}</span>
                                            @endif
                                            @else <span class="text-black">0.00</span>
                                            @endif
                                            </span>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="card-actions flex justify-center">
                                            <button type="button" wire:click="confirm" class="sc-btn-primary">
                                                <span>{{ __('Save')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compare Dropdown -->
                    <div class="dropdown dropdown-left">
                        <label tabindex="2" class="btn btn-ghost btn-circle btn-lg">
                            <div class="indicator top-3 relative bottom-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 640 512" fill="#94a3b8">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M554.9 154.5c-17.62-35.25-68.12-35.38-85.87 0c-87 174.3-84.1 165.9-84.1 181.5c0 44.13 57.25 80 128 80s127.1-35.88 127.1-80C639.1 319.9 641.4 327.3 554.9 154.5zM439.1 320l71.96-144l72.17 144H439.1zM256 336c0-16.12 1.375-8.75-85.12-181.5c-17.62-35.25-68.12-35.38-85.87 0c-87 174.3-84.1 165.9-84.1 181.5c0 44.13 57.25 80 127.1 80S256 380.1 256 336zM127.9 176L200.1 320H55.96L127.9 176zM495.1 448h-143.1V153.3C375.5 143 393.1 121.8 398.4 96h113.6c17.67 0 31.1-14.33 31.1-32s-14.33-32-31.1-32h-128.4c-14.62-19.38-37.5-32-63.62-32S270.1 12.62 256.4 32H128C110.3 32 96 46.33 96 64S110.3 96 127.1 96h113.6c5.25 25.75 22.87 47 46.37 57.25V448H144c-26.51 0-48.01 21.49-48.01 48c0 8.836 7.165 16 16 16h416c8.836 0 16-7.164 16-16C544 469.5 522.5 448 495.1 448z" />
                                </svg>
                                <span class="badge badge-sm bg-emerald-400 border-none text-white indicator-item">{{ $compitems }}</span>
                            </div>
                            <span class="relative top-1 text-xs normal-case leading-none">Compare</span>
                        </label>
                        <div tabindex="2" class="card card-compact dropdown-content w-96 bg-white shadow ml-3">
                            <!-- Card Header -->
                            <div class="font-bold text-lg bg-emerald-700 px-3 py-3 flex justify-between">
                                <span class="text-white">Compare</span>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body max-h-[385px]">
                                <!-- Card Header -->
                                <hr>
                                <!-- Card Content -->
                                <div class="overflow-y-auto max-h-96">
                                    <!-- Item -->
                                    @forelse ($compare_details as $list_detail)
                                    <div class="flex flex-row max-h-24 px-2 py-2">
                                        <div class="flex space-x-5 items-center">
                                            <div class="flex space-x-2 items-center">
                                                <span class="relative h-2/3 flex rounded-full px-1 bg-emerald-600 text-xs text-white items-center">{{ $list_detail['list_index'] + 1 }}</span>
                                                <span><img src="{{ $list_detail['image_path'] }}" width="100" alt="Image" /></span>
                                            </div>
                                            <div class="flex w-full justify-between">
                                                <div class="flex flex-col">
                                                    <span>{{ $list_detail['product_name'] }}</span>
                                                    <div class="flex flex-row items-center space-x-2">
                                                        <button type="button" wire:click="comparequantity_sub( {{ $list_detail['list_index'] }} )">
                                                            <i class="fa-solid fa-minus text-emerald-500"></i>
                                                        </button>
                                                        <span class="text-center w-8">{{ $list_detail['quantity'] }}</span>
                                                        <button type="button" wire:click="comparequantity_add( {{ $list_detail['list_index'] }} )">
                                                            <i class="fa-solid fa-plus text-emerald-500"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col items-end">
                                                    <button type="button" wire:click="remove_compitem( {{ $list_detail['list_index'] }} )">
                                                        <i class="fa-solid fa-xmark text-emerald-500"></i>
                                                    </button>
                                                    <span>₱&nbsp;{{ number_format($list_detail['price'] * $list_detail['quantity'], 2, '.', ',') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <span class="flex-row max-h-24 px-2 py-2 italic flex justify-center">Add items here</span>
                                    @endforelse
                                </div>
                                <hr>
                                <!-- Card Total -->
                                <div class="py-3">
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-black">Lowest Price:</span>
                                            <span class="text-black" wire:model="complow"><i class="fa-solid fa-peso-sign"></i>&nbsp;{{ number_format($complow, 2, '.', ',') }}</span>
                                        </div>
                                        <!-- Save Button -->
                                        <div class="card-actions flex justify-center">
                                            <button type="button" wire:click="getlow" class="sc-btn-primary">
                                                <span>Get lowest price</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar flex flex-row justify-between">
                <div class="flex justify-start space-x-2">
                    <!-- Categories -->
                    <div>
                        <select class="select select-sm rounded-full bg-white text-black text-sm w-full max-w-xs border-emerald-400 border-2 leading-none" wire:model="selectedmarket">
                            <option value="">Markets (All)</option>
                            @foreach($markets as $market)
                            <option value="{{ $market->market_id }}">
                                {{$market->market_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="select select-sm rounded-full bg-white text-black text-sm w-full max-w-xs border-emerald-400 border-2 leading-none" wire:model="selectedsubcategory">
                            <option value="">Categories (All)</option>
                            @foreach($categories as $category)
                            <optgroup label="{{ $category->category_name }}">
                                @foreach($subcategories as $subcategory)
                                @if($subcategory->category_id == $category->category_id)
                                <option value="{{ $subcategory->subcategory_id }}">{{ $subcategory->subcategory_name }}</option>
                                @endif
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="select select-sm rounded-full bg-white text-black text-sm w-full max-w-xs border-emerald-400 border-2 leading-none" wire:model="selectedsort">
                            <option disabled selected>Sort By</option>
                            <option value="asc">Price (Lowest-Highest)</option>
                            <option value="desc">Price (Highest-Lowest)</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Product Table -->
            <div class="pr-[75px]">
                <div class="pt-1">
                    <div class="grid grid-cols-2 border-2 sm:grid-cols-3 md:grid-cols-4">
                        <!-- Products -->
                        @foreach ($products as $product)
                        <div class="flex flex-col border bg-white min-h-full justify-between">
                            <div class="p-3">
                                <img src="{{ '../storage/' . $this->logo($product->market_id) }}" width="35" />
                            </div>
                            <div class="flex mx-auto">
                                <img src="{{ $product->image_path }}" alt="{{ $product->product_name }}" width="100" />
                            </div>
                            <div class="flex flex-col py-5 px-4 space-y-1 items-center">
                                <span class="text-black text-center">{{ $product->product_name }}</span>
                                <span class="text-black text-center text-lg">
                                    <b>PHP {{ number_format($product->price, 2, '.', ',') }}</b>
                                </span>
                                <div class="flex flex-row space-x-2">
                                    <div class="flex items-center justify-center">
                                        <div class="inline-flex" role="group">
                                            <button type="button" class="flex items-center bg-emerald-600 text-white border-none rounded-full rounded-r hover:bg-emerald-700 transition duration-300" wire:click="product_add({{ $product->id }})">
                                                @if (is_null($this->get_product_id($product->product_id)))
                                                <span class="px-6 py-1 hidden xl:inline"><i class="fa-solid fa-cart-plus"></i>&nbsp;Add</span>
                                                <span class="px-6 py-1 xl:hidden"><i class="fa-solid fa-cart-plus"></i></span>
                                                @else
                                                <span class="px-6 py-1 hidden xl:inline"><i class="fa-solid fa-plus"></i></span>
                                                <span class="px-6 py-1 xl:hidden"><i class="fa-solid fa-plus"></i></span>
                                                @endif
                                            </button>
                                            <button type="button" class="flex items-center border-2 border-emerald-600 rounded-full rounded-l text-emerald-600 hover:bg-emerald-100 hover:opacity-75 transition duration-300" wire:click="compare_add({{ $product->id }})">
                                                @if (is_null($this->get_product_comp_id($product->product_id)))
                                                <span class="px-6 py-1 hidden xl:inline"><i class="fa-solid fa-scale-balanced"></i>&nbsp;Compare</span>
                                                <span class="px-6 py-1 xl:hidden"><i class="fa-solid fa-scale-balanced"></i></span>
                                                @else
                                                <span class="px-6 py-1 hidden xl:inline">Added</span>
                                                <span class="px-6 py-1 xl:hidden">Added</span>
                                                @endif
                                            </button>
                                        </div>
                                    </div>
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
    </div>
</div>