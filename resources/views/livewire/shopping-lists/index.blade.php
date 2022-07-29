<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Add Button -->
        <div class="flex flex-row-reverse pt-5">
            <div class="flex space-x-2 min-w-full justify-end">
                <div class="flex rounded-full bg-white w-full max-w-xs h-10 items-center">
                    <i class="fa-solid fa-magnifying-glass z-1 pl-4 absolute"></i>
                    <input type="text" placeholder="Search" class="input bg-white pl-10 w-full rounded-full h-10" wire:model='searchterm' />
                </div>
                <button class="bg-emerald-700 px-6 py-1.5 text-white border-none rounded-full hover:bg-emerald-800 transition:1s"><i class="fa-solid fa-plus"></i>
                    <a href="{{ route('/shopping-lists/create') }}">
                        &nbsp;Add List
                    </a>
                </button>

            </div>
        </div>
        <!-- List Management Table -->
        <div class="py-5">
            <div class="overflow-auto rounded-lg">
                <div data-theme="mytheme">
                    <table class="table w-full">
                        <!-- head -->
                        <thead class="text-white">
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" />
                                    </label>
                                </th>
                                <th>LIST NAME</th>
                                <th>TOTAL</th>
                                <th>BUDGET</th>
                                <th>UPDATED AT</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($shoppinglists && $shoppinglists->count() > 0)
                            @foreach($shoppinglists as $shoppinglist)
                            <tr class="hover table-group">

                                <td class="table-item">
                                    <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" />
                                </td>
                                <td class="table-item">{{ $shoppinglist->list_name }}</td>
                                <td class="table-item">{{ $shoppinglist->budget }}</td>
                                <td class="table-item">{{ $shoppinglist->total }}</td>
                                <td class="table-item">{{ $shoppinglist->updated_at }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>No Result</td>
                            </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- Options Menu when Checkbox Ticked -->
        <div id="contextmenu" class="sticky bottom-0 bg-white p-3 bg-shadow w-full hidden">
            <div class="flex justify-center space-x-10">
                <button class="btn btn-sm bg-emerald-700 text-white border-none hover:bg-emerald-500"><i class="fa-solid fa-pen"></i>&nbsp;Edit</button>
                <button class="btn btn-sm bg-yellow-700 text-white border-none hover:bg-yellow-500"><i class="fa-solid fa-folder"></i>&nbsp;Archive</button>
                <button class="btn btn-sm bg-orange-700 text-white border-none hover:bg-orange-500"><i class="fa-solid fa-file-import"></i>&nbsp;Import</button>
            </div>
        </div>
    </div>
</div>