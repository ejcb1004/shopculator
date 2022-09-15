<div>
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
                </div>
            </div>
            <div class="navbar flex flex-row justify-between">
                <div class="flex justify-start space-x-2">
                    <!-- Categories -->
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
                <div class="mr-20">
                    <button type="button" class="sc-btn-primary">
                        <span class="hidden md:inline"><i class="fa-solid fa-plus"></i>&nbsp;New Product</span>
                        <span class="md:hidden"><i class="fa-solid fa-plus"></i></span>
                    </button>
                </div>
            </div>
            <!-- Product Table -->
            <div class="pr-[75px]">
                <div class="pt-1">
                    <div class="grid grid-cols-2 border-2 sm:grid-cols-3 md:grid-cols-4">
                        <!-- Products -->
                        @foreach ($products as $product)
                        <div class="border bg-white">
                            <div class="flex flex-col min-h-full py-5 px-4 space-y-1 items-center">
                                <div class="flex flex-auto items-center">
                                    <img src="{{ $product->image_path }}" alt="{{ $product->product_name }}" width="125" />
                                </div>
                                <span class="text-black text-center">{{ $product->product_name }}</span>
                                <span class="text-black text-center text-lg">
                                    <b>PHP {{ number_format($product->price, 2, '.', ',') }}</b>
                                </span>
                                <div class="flex flex-row space-x-2">
                                    <div class="flex items-center justify-center">
                                        <div class="inline-flex" role="group">
                                            <button type="button" class="flex items-center border-2 border-emerald-600 rounded-full rounded-r text-emerald-600 hover:bg-emerald-100 hover:opacity-75 transition duration-300" wire:click="edit_product({{ $product->id }})">
                                                <span class="px-6 py-1 hidden xl:inline"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</span>
                                                <span class="px-6 py-1 xl:hidden"><i class="fa-solid fa-pen-to-square"></i></span>
                                            </button>
                                            <button type="button" class="flex items-center bg-red-500 text-white border-none rounded-full rounded-l hover:bg-red-600 transition duration-300" wire:click="delete_product({{ $product->id }})">
                                                <span class="px-6 py-1 hidden xl:inline"><i class="fa-solid fa-trash"></i>&nbsp;Delete</span>
                                                <span class="px-6 py-1 xl:hidden"><i class="fa-solid fa-trash"></i></span>
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