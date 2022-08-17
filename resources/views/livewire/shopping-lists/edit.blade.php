<div>
    @if ($errors->any())
    <div class="flex min-w-full bg-red-300 justify-center items-center">
        <ul>
            @foreach ($errors->all() as $error)
            <li class="text-red-800"><i class="fa-solid fa-circle-xmark"></i>&nbsp;{{ $error }}</li>
            @endforeach
        </ul>
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="navbar flex flex-row justify-between">
            <div class="flex justify-start space-x-2 pl-[75px]">
                <!-- Categories -->
                <div>
                    <select class="select select-sm rounded-full bg-white text-black text-xs w-full max-w-xs border-emerald-400 border-2 leading-none" wire:model="selectedmarket">
                        <option value="">Markets (All)</option>
                        @foreach($markets as $market)
                        <option value="{{ $market->market_id }}">
                            {{$market->market_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="select select-sm rounded-full bg-white text-black text-xs w-full max-w-xs border-emerald-400 border-2 leading-none" wire:model="selectedcategory">
                        <option value="">Categories (All)</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">
                            {{$category->category_name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="select select-sm rounded-full bg-white text-black text-xs w-full max-w-xs border-emerald-400 border-2 leading-none" wire:model="selectedsort">
                        <option disabled selected>Sort By</option>
                        <option value="asc">Price (Lowest-Highest)</option>
                        <option value="desc">Price (Highest-Lowest)</option>
                    </select>
                </div>
                <button type="button" wire:click="inspect_dbd" class="sc-btn-ghost">
                    <span>DB Details</span>
                </button>
                <button type="button" wire:click="inspect_ld" class="sc-btn-primary">
                    <span>Inspect List</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Content Page -->
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8">
        <div class="flex flex-row">
            <div class="mt-1 fixed flex flex-col w-[70px] justify-center space-y-2">
                <!-- Cart Dropdown -->
                <div class="dropdown dropdown-right">
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
                <div class="dropdown dropdown-right">
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
                        <div class="card-body">
                            <!-- Card Header -->
                            <div class="flex flex-nowrap py-1">
                                <div class="flex w-full items-center">
                                    <i class="fa-solid fa-peso-sign pl-3 absolute"></i>
                                    <input type="number" name="budget" id="budget" placeholder="Enter budget here" min="0" class="input input-bordered input-sm bg-white w-full pl-8" wire:model.lazy="budget" />
                                </div>
                            </div>
                            <hr>
                            <!-- Card Content -->
                            <div class="overflow-y-auto max-h-28">
                                <!-- Item -->
                                @forelse ($list_details as $list_detail)
                                @if ($list_detail['is_deleted'] == 0)
                                <div class="flex flex-row max-h-24 px-2 py-2">
                                    <div class="flex space-x-5 items-center">
                                        <div class="flex space-x-2 items-center">
                                            <span class="relative h-2/3 flex rounded-full px-1 bg-emerald-600 text-xs text-white items-center">{{ $list_detail['list_index'] + 1 }}</span>
                                            <input type="checkbox" class="checkbox checkbox-accent checkbox-sm" value="{{ $list_detail['product_id'] }}" wire:model="productchecked" />
                                            <span><img src="{{ $prefix . $list_detail['image_path'] }}" width="100" alt="Image" /></span>
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
                                                <span>₱&nbsp;{{ number_format($list_detail['price'] * $list_detail['quantity'], 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                                        <span class="text-black"><i class="fa-solid fa-peso-sign"></i>&nbsp;{{ number_format($total, 2) }}</span>
                                    </div>
                                    <!-- Card Remaining Budget -->
                                    <div class="flex justify-between">
                                        <span class="text-black">Remaining:</span>
                                        <span><i class="fa-solid fa-peso-sign text-black"></i>
                                            @if( !empty($budget) )
                                            @if (number_format($budget - $total, 2) < 0) <span class="text-red-600">{{ number_format($budget - $total, 2) }}</span>
                                        @else <span class="text-black">{{ number_format($budget - $total, 2) }}</span>
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
            </div>
            <!-- Product Table -->
            <div class="pl-[75px]">
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
                                <button type="button" class="sc-btn-primary" wire:click="product_add({{ $product->id }})">
                                    <span>Add</span>
                                </button>
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