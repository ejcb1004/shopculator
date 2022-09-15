<div>
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
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="Product Name">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="w-1/3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Subcategory
                            </label>
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
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
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="number" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="w-full">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Image URL
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="https://" wire:model="image_path">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-3">
                        <!-- <button class="sc-btn-danger">
                            <span>Delete</span>
                        </button> -->
                        <button class="sc-btn-primary">
                            <span>Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>