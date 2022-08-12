<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Add Button -->
        <div class="flex flex-row-reverse pt-5">
            <div class="flex space-x-2 min-w-full justify-end">
                <div class="flex rounded-full bg-white w-full max-w-xs h-10 items-center">
                    <i class="fa-solid fa-magnifying-glass z-1 pl-4 absolute"></i>
                    <input type="text" placeholder="Search" class="input bg-white pl-10 w-full rounded-full h-10" wire:model='searchterm' />
                </div>
                <button class="sc-btn-primary">
                    <a href="{{ route('shopping-lists/create') }}">
                        <i class="fa-solid fa-plus"></i>&nbsp;Add List
                    </a>
                </button>

                <button class="sc-btn-primary" wire:click = "check_listid">Check List ID</button>

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
                                        <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" wire:model="selectall" />
                                    </label>
                                </th>
                                <th>List Name</th>
                                <th>Total</th>
                                <th>Budget</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($shoppinglists as $shoppinglist)
                            <tr class="hover table-group">

                                <td class="table-item">
                                    <input type="checkbox" value="{{ $shoppinglist->list_id }}" class="checkbox checkbox-sm checkbox-accent" wire:model="checkboxticked" />
                                </td>
                                <td class="table-item">{{ $shoppinglist->list_name }}</td>
                                <td class="table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($shoppinglist->total, 2, '.') }}</td>
                                <td class="table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($shoppinglist->budget, 2, '.') }}</td>
                                <td class="table-item">{{ $shoppinglist->updated_at }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td>No Result</td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
        <!-- Options Menu when Checkbox Ticked -->
        @if (count($checkboxticked) == 1)
        <div class="sticky bottom-0 bg-white p-3 bg-shadow w-full">
            <div class="flex justify-center space-x-10">
                <a class="btn btn-sm bg-emerald-700 text-white border-none hover:bg-emerald-800" href="{{ route('shopping-lists/edit') }}"><i class="fa-solid fa-pen"></i>&nbsp;Edit</a>
                <button class="btn btn-sm bg-indigo-700 text-white border-none hover:bg-indigo-800"><i class="fa-solid fa-folder"></i>&nbsp;Archive</button>
                <a class="btn btn-sm bg-red-700 text-white border-none hover:bg-red-800" href="{{ route('list.pdf') }}"><i class="fa-solid fa-file-import"></i>&nbsp;Export PDF</a>
            </div>
        </div>
        @elseif (count($checkboxticked) >= 2)
        <div class="sticky bottom-0 bg-white p-3 bg-shadow w-full">
            <div class="flex justify-center space-x-10">
                <button class="btn btn-sm bg-emerald-700 text-white border-none hover:bg-emerald-800" disabled><i class="fa-solid fa-pen"></i>&nbsp;Edit</button>
                <button class="btn btn-sm bg-indigo-700 text-white border-none hover:bg-indigo-800"><i class="fa-solid fa-folder"></i>&nbsp;Archive</button>
                <a class="btn btn-sm bg-red-700 text-white border-none hover:bg-red-800" href="{{ route('list.pdf') }}"><i class="fa-solid fa-file-import"></i>&nbsp;Export PDF</a>
            </div>
        </div>
        @endif
    </div>
</div>