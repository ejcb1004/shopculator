<div>
    <form wire:submit.prevent="delete" enctype="multipart/form-data">
        @csrf
        <x-jet-confirmation-modal wire:model="confirm_delete">
            <x-slot name="title">
                Delete List
            </x-slot>

            <x-slot name="content">
                Are you sure you want to delete this product? This cannot be undone.
            </x-slot>

            <x-slot name="footer">
                <button class="sc-btn-red-ghost ml-3" type="button" wire:click="$toggle('confirm_delete')" wire:loading.attr="disabled">
                    <span>No</span>
                </button>

                <button class="sc-btn-danger ml-3" type="submit" wire:target="delete" wire:loading.attr="disabled">
                    <span>Delete</span>
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
                            <div class="indicator relative left-5 bottom-2">
                                <i class="fa-solid fa-file-import"></i>
                                @if (!empty($file))
                                <span class="border-none text-emerald-400 indicator-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-3 w-3" fill="currentColor" stroke="#94a3b8">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512z" />
                                    </svg>
                                </span>
                                @endif
                            </div>
                            <span class="relative top-4 right-2 text-xs normal-case leading-none">Import</span>
                        </label>
                        <div tabindex="1" class="card card-compact dropdown-content w-[575px] bg-white shadow-md ml-3 rounded-full">
                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Card Content -->
                                <form class="flex flex-row" action="{{ route('market/import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex items-center w-2/3">
                                        <input type="file" name="file" id="file" wire:model="file" />
                                    </div>
                                    @if (!empty($file))
                                    <button type="submit" class="flex items-center bg-emerald-600 text-white border-none rounded-full rounded-r hover:bg-emerald-700 transition duration-300 w-1/2 justify-center">
                                        <span class="hidden md:inline px-6 py-1"><i class="fa-solid fa-file-import"></i>&nbsp;Import</span>
                                        <span class="px-6 py-1 md:hidden"><i class="fa-solid fa-file-import"></i></span>
                                    </button>
                                    @else
                                    <button type="button" class="flex items-center bg-gray-300 text-gray-600 border-none rounded-full rounded-r w-1/2 justify-center" disabled>
                                        <span class="hidden md:inline px-6 py-1"><i class="fa-solid fa-file-import"></i>&nbsp;Import</span>
                                        <span class="px-6 py-1 md:hidden"><i class="fa-solid fa-file-import"></i></span>
                                    </button>
                                    @endif
                                    <button type="button" class="flex items-center border-y-2 border-r-2 border-l border-emerald-600 rounded-full rounded-l text-emerald-600 hover:bg-emerald-100 hover:opacity-75 transition duration-300 w-1/2 justify-center">
                                        <a href="{{ url('market/template/'. $market) }}" class="hidden md:inline px-6 py-1"><i class="fa-solid fa-download"></i>&nbsp;Template</a>
                                        <a class="px-6 py-1 md:hidden"><i class="fa-solid fa-download"></i></a>
                                    </button>
                                </form>
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
                <div class="mr-20 inline-flex" role="group">
                    <button type="button" class="flex items-center border-y-2 border-l-2 border-r border-emerald-600 rounded-full rounded-r text-emerald-600 hover:bg-emerald-100 hover:opacity-75 transition duration-300">
                        <a href="{{ url('market/export/'. $market) }}" class="hidden md:inline px-6 py-0.5"><i class="fa-solid fa-file-export"></i>&nbsp;Export</a>
                        <span class="px-6 py-0.5 md:hidden"><i class="fa-solid fa-file-export"></i></i></span>
                    </button>
                    <button type="button" class="flex items-center bg-emerald-600 text-white border-none rounded-full rounded-l hover:bg-emerald-700 transition duration-300">
                        <a href="{{ route('market/create') }}" class="hidden md:inline px-6 py-1"><i class="fa-solid fa-plus"></i>&nbsp;New Product</a>
                        <span class="px-6 py-1 md:hidden"><i class="fa-solid fa-plus"></i></span>
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
                                            <button type="button" class="flex items-center border-2 border-emerald-600 rounded-full rounded-r text-emerald-600 hover:bg-emerald-100 hover:opacity-75 transition duration-300">
                                                <a class="px-6 py-1 hidden xl:inline" href="{{ url('market/edit/' . $product->product_id) }}"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</a>
                                                <span class="px-6 py-1 xl:hidden"><i class="fa-solid fa-pen-to-square"></i></span>
                                            </button>
                                            <button type="button" class="flex items-center bg-red-500 text-white border-none rounded-full rounded-l hover:bg-red-600 transition duration-300" wire:click="confirm_delete_fn({{ $product->id }})">
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