<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Add Button -->
        <div class="flex flex-row-reverse pt-5">
            <div class="flex space-x-4 min-w-full pb-6 pt-2 justify-end">
                <div class="flex rounded-full bg-white w-full max-w-xs h-10 items-center">
                    <i class="fa-solid fa-magnifying-glass z-1 pl-4 absolute"></i>
                    <input type="text" placeholder="Search" class="input bg-white pl-10 w-full rounded-full h-10" wire:model='searchterm' />
                </div>
                <button class="sc-btn-primary">
                    <a href="{{ route('admin/categories/create') }}">
                        <i class="fa-solid fa-plus"></i>&nbsp;Add Category
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
                                        <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" wire:model="selectall" />
                                    </label>
                                </th>                                
                                <th>Category</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                            <tr class="hover table-group">
                                <td class="table-item">
                                    <input type="checkbox" value="{{ $category->category_id }}" class="checkbox checkbox-sm checkbox-accent" wire:model="checkboxticked" />
                                </td>
                                <td class="table-item">{{ $category->category_name }}</td>
                                <td class="table-item">
                                    @php
                                    $dt = new DateTime($category->updated_at);
                                    $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                                    echo $dt->format('h:i:s a, M d, Y');
                                    @endphp
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td><i>No Result</i></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(count($categories))
                {{ $categories->links() }}
                @endif
            </div>
        </div>
        <!-- Options Menu when Checkbox Ticked -->
        @if (count($checkboxticked) == 1)
        <div class="sticky rounded-md bottom-0 bg-white p-3 bg-shadow w-full">
            <div class="flex justify-center space-x-3 lg:space-x-8">
                <button type="button" class="sc-btn-ghost"><a href="{{ url('admin/categories/edit/' . $checkboxticked[0]) }}"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</a></button>
                <button type="button" class="sc-btn-danger" wire:click="confirm_delete"><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            </div>
        </div>
        @elseif (count($checkboxticked) >= 2)
        <div class="sticky rounded-md bottom-0 bg-white p-3 bg-shadow w-full">
            <div class="flex justify-center space-x-3 lg:space-x-8">
                <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</span></button>
                <button type="button" class="sc-btn-danger" wire:click="confirm_delete"><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            </div>
        </div>
        @endif
    </div>
</div>