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
    <form wire:submit.prevent="store" enctype="multipart/form-data">
        @csrf
        <x-jet-confirmation-modal wire:model="to_confirm">
            <x-slot name="title">
                Create Product
            </x-slot>

            <x-slot name="content">
                Are you sure you want to create this product?
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
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8 pt-12">
        <div class="flex flex-row w-full h-16 items-center justify-center">
            <span class="tracking-wide text-gray-700 text-2xl font-bold">New Product</span>
        </div>
        <div class="flex flex-row w-full h-[450px]">
            <div class="flex w-2/5 h-full p-4 justify-center items-center">
                <img src="{{ $image_path }}" alt="Product Image">
            </div>
            <div class="flex bg-white w-3/5 rounded-md h-full p-4 items-center">
                <form class="min-w-full max-w-lg justify-between">
                    <div class="mb-4">
                        <div class="w-full">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Product Name
                            </label>
                            <input wire:model="product_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="Product Name">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="w-1/3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Subcategory
                            </label>
                            <select wire:model="subcategory_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option selected disabled>Choose subcategory</option>
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
                    </div>
                    <div class="mb-4">
                        <div class="w-1/3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Price
                            </label>
                            <input wire:model="price" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="number" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="w-full">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Image URL
                            </label>
                            <input wire:model="image_path" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="https://" wire:model="image_path">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-3">
                        <button class="sc-btn-primary" type="button" wire:click="confirm">
                            <span>Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>