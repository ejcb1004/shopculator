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
                Edit Category
            </x-slot>

            <x-slot name="content">
                Are you sure you want to save this category's details?
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
            <span class="tracking-wide text-gray-700 text-2xl font-bold">Edit Category</span>
        </div>
        <div class="flex flex-row w-full min-h-[450px] justify-center">
            <div class="flex bg-white w-3/5 rounded-md h-full p-4 items-center">
                <form class="min-w-full max-w-lg justify-between">
                    <div class="mb-4">
                        <div class="w-full">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Category Name
                            </label>
                            <input wire:model="category_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="Category Name">
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