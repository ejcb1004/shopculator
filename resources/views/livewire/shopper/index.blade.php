<div>
    <form wire:submit.prevent="delete" enctype="multipart/form-data">
        @csrf
        <x-jet-confirmation-modal wire:model="to_confirm_delete">
            <x-slot name="title">
                Delete List
            </x-slot>

            <x-slot name="content">
                @if (count($checkboxticked) == 1)
                Are you sure you want to delete this list? 
                @elseif (count($checkboxticked) > 1)
                Are you sure you want to delete these lists? 
                @endif
                This cannot be undone.
            </x-slot>

            <x-slot name="footer">
                <button class="sc-btn-red-ghost ml-3" type="button" wire:click="$toggle('to_confirm_delete')" wire:loading.attr="disabled">
                    <span>No</span>
                </button>

                <button class="sc-btn-danger ml-3" type="submit" wire:target="delete" wire:loading.attr="disabled">
                    <span>Delete</span>
                </button>

            </x-slot>
        </x-jet-confirmation-modal>
    </form>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Add Button -->
        <div class="flex flex-row-reverse pt-5">
            <div class="flex space-x-4 min-w-full pb-6 pt-2 justify-end">
                <div class="flex rounded-full bg-white w-full max-w-xs h-10 items-center">
                    <i class="fa-solid fa-magnifying-glass z-1 pl-4 absolute"></i>
                    <input type="text" placeholder="Search" class="input bg-white pl-10 w-full rounded-full h-10" wire:model='searchterm' />
                </div>
                <button class="sc-btn-primary">
                    <a href="{{ route('shopper/create') }}">
                        <i class="fa-solid fa-plus"></i>&nbsp;Add List
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
                                <th>List Name</th>
                                <th>Total</th>
                                <th>Budget</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($lists as $list)
                            <tr class="hover table-group">
                                <input value="{{ $list->id }}" name="id" id="id" hidden />
                                <td class="table-item">
                                    <input type="checkbox" value="{{ $list->list_id }}" class="checkbox checkbox-sm checkbox-accent" wire:model="checkboxticked" />
                                </td>
                                <td class="table-item">{{ $list->list_name }}</td>
                                <td class="table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($list->total, 2, '.') }}</td>
                                <td class="table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($list->budget, 2, '.') }}</td>
                                <td class="table-item">{{ $list->updated_at }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td><i>No Result</i></td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
        <!-- Options Menu when Checkbox Ticked -->
        @if (count($checkboxticked) == 1)
        <div class="sticky rounded-md bottom-0 bg-white p-3 bg-shadow w-full">
            <div class="flex justify-center space-x-3 lg:space-x-8">
                <button type="button" class="sc-btn-ghost"><a href="{{ url('shopper/edit/' . $checkboxticked[0]) }}"><i class="fa-solid fa-pen"></i>&nbsp;Edit</a></button>
                <button type="button" class="sc-btn-red-ghost"><a href="{{ url('shopper/download/'. $checkboxticked[0]) }}"><i class="fa-solid fa-file-pdf"></i>&nbsp;Save PDF</a></button>
                <button type="button" class="sc-btn-danger" wire:click="confirm_delete"><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            </div>
        </div>
        @elseif (count($checkboxticked) >= 2)
        <div class="sticky rounded-md bottom-0 bg-white p-3 bg-shadow w-full">
            <div class="flex justify-center space-x-3 lg:space-x-8">
                <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-pen"></i>&nbsp;Edit</span></button>
                <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-file-pdf"></i>&nbsp;Save as PDF</span></button>
                <button type="button" class="sc-btn-danger" wire:click="confirm_delete"><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            </div>
        </div>
        @endif
    </div>
</div>