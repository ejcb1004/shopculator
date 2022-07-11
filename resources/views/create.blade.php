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

</x-app-layout>