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
                <span class="text-red-600">This cannot be undone.</span>
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
    <form wire:submit.prevent="mark_complete" enctype="multipart/form-data">
        @csrf
        <x-jet-confirmation-modal wire:model="to_confirm">
            <x-slot name="title">
                @if (count($checkboxticked) == 1)
                Mark List as Completed
                @elseif (count($checkboxticked) > 1)
                Mark Lists as Completed
                @endif
            </x-slot>

            <x-slot name="content">
                @if (count($checkboxticked) == 1)
                Are you sure you want to mark this list as completed?
                <br>
                <span class="text-red-600">This list cannot be edited afterwards, and these changes cannot be undone.</span>
                @elseif (count($checkboxticked) > 1)
                Are you sure you want to mark these lists as completed?
                <br>
                <span class="text-red-600">These lists cannot be edited afterwards, and these changes cannot be undone.</span>
                @endif
            </x-slot>

            <x-slot name="footer">
                <button class="sc-btn-ghost ml-3" type="button" wire:click="$toggle('to_confirm')" wire:loading.attr="disabled">
                    <span>No</span>
                </button>
                <button class="sc-btn-primary ml-3" type="submit" wire:target="mark_complete" wire:loading.attr="disabled">
                    <span>Save</span>
                </button>
            </x-slot>
        </x-jet-confirmation-modal>
    </form>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Add Button -->
        <div class="flex flex-row-reverse pt-8">
            <div class="flex space-x-4 min-w-full justify-end">
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
        <!-- Summary of Trends -->
        <div class="grid grid-cols-5 gap-4 mb-12">
            <div class="grid grid-cols-3 mx-auto w-full text-left text-blue-500 px-6 py-4 mt-8 bg-white shadow-md h-full sm:rounded-xl">
                <div class="col-span-2 flex flex-col h-full justify-center">
                    <span class="text-3xl">{{ $list_count }}</span>
                    <span class="font-bold text-md">Total Lists</span>
                </div>
                <div class="flex justify-end items-center">
                    <i class="fa-solid fa-list text-[40px]"></i>
                </div>
            </div>
            <div class="grid grid-cols-3 mx-auto w-full text-left text-emerald-500 px-6 py-4 mt-8 bg-white shadow-md h-full sm:rounded-xl">
                <div class="col-span-2 flex flex-col h-full justify-center">
                    <span class="text-3xl">{{ $active_list_count['total'] }}</span>
                    <span class="font-bold text-md">Active Lists</span>
                    <span class="text-sm">{{ $active_list_count['this_month'] }}&nbsp;this month</span>
                </div>
                <div class="flex justify-end items-center">
                    <i class="fa-solid fa-list-ul text-[40px]"></i>
                </div>
            </div>
            <div class="grid grid-cols-3 mx-auto w-full text-left text-indigo-500 px-6 py-4 mt-8 bg-white shadow-md h-full sm:rounded-xl">
                <div class="col-span-2 flex flex-col h-full justify-center">
                    <span class="text-3xl">{{ $completed_list_count['total'] }}</span>
                    <span class="font-bold text-md">Completed Lists</span>
                    <span class="text-sm">{{ $completed_list_count['this_month'] }}&nbsp;this month</span>
                </div>
                <div class="flex justify-end items-center">
                    <i class="fa-solid fa-list-check text-[40px]"></i>
                </div>
            </div>
            <div class="grid grid-cols-3 col-span-2 mx-auto w-full px-6 py-4 mt-8 bg-white shadow-md h-full sm:rounded-xl">
                <div class="col-span-2 flex flex-col h-full justify-center">
                    <span class="text-yellow-500 text-3xl">₱&nbsp;{{ number_format($spendings['total'], 2, '.', ',') }}</span>
                    <span class="text-yellow-500 font-bold text-md">Total Spendings</span>
                    <div class="flex flex-col text-sm">
                        <div>
                            <span class="text-yellow-500 text-sm">₱&nbsp;{{ number_format($spendings['this_month'], 2, '.', ',') }}&nbsp;this month</span>
                            @if ( $spendings['this_month'] < $spendings['last_month'] )
                            <span class="text-green-600">&nbsp;
                                <i class="fa-solid fa-caret-down"></i>
                                <span>{{ number_format(($spendings['this_month'] / $spendings['last_month']) * 100 - 100, 2) }}</span>
                            </span>
                            @elseif ( $spendings['this_month'] > $spendings['last_month'] )
                            <span class="text-red-600">&nbsp;
                                <i class="fa-solid fa-caret-up"></i>
                                <span>{{ number_format(($spendings['this_month'] / $spendings['last_month']) * 100 - 100, 2) }}</span>
                            </span>
                            @else
                            @endif
                        </div>
                        <div>
                            <span class="text-yellow-500 text-sm">₱&nbsp;{{ number_format($spendings['this_year'], 2, '.', ',') }}&nbsp;this year</span>
                            @if ( $spendings['this_year'] < $spendings['last_year'] )
                            <span class="text-green-600">&nbsp;
                                <i class="fa-solid fa-caret-down"></i>
                                <span>{{ number_format(($spendings['this_year'] / $spendings['last_year']) * 100 - 100, 2) }}</span>
                            </span>
                            @elseif ( $spendings['this_year'] > $spendings['last_year'] )
                            <span class="text-red-600">&nbsp;
                                <i class="fa-solid fa-caret-up"></i>
                                <span>{{ number_format(($spendings['this_year'] / $spendings['last_year']) * 100 - 100, 2) }}</span>
                            </span>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex justify-end items-center text-yellow-500">
                    <i class="fa-solid fa-coins text-[40px]"></i>
                </div>
            </div>
        </div>
        <!-- List Management Table -->
        <div class="pt-4 pb-14">
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
                                <th>Status</th>
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
                                <td class="table-item">
                                    @switch ($list->list_status)
                                    @case(1)
                                    Active
                                    @break

                                    @case(2)
                                    Completed
                                    @break

                                    @default
                                    @endswitch
                                </td>
                                <td class="table-item">{{ $list->list_name }}</td>
                                <td class="table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($list->total, 2, '.') }}</td>
                                <td class="table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($list->budget, 2, '.') }}</td>
                                <td class="table-item">
                                    @php
                                    $dt = new DateTime($list->updated_at);
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
                @if(count($lists))
                {{ $lists->links() }}
                @endif
            </div>
        </div>
    </div>
    <!-- Options Menu when Checkbox Ticked -->
    @if (count($checkboxticked) == 1)
    <div class="fixed rounded-md bottom-0 bg-white p-3 bg-shadow w-full">
        <div class="flex justify-center space-x-3 lg:space-x-8">
            <button type="button" class="sc-btn-ghost"><a href="{{ url('shopper/view/' . $checkboxticked[0]) }}"><i class="fa-solid fa-eye"></i>&nbsp;View</a></button>
            @if ($this->list_is_completed())
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</span></button>
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-check"></i>&nbsp;Mark as completed</span></button>
            @else
            <button type="button" class="sc-btn-ghost"><a href="{{ url('shopper/edit/' . $checkboxticked[0]) }}"><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</a></button>
            <button type="button" class="sc-btn-ghost" wire:click="confirm(2)"><span><i class="fa-solid fa-check"></i>&nbsp;Mark as completed</span></button>
            @endif
            <button type="button" class="sc-btn-red-ghost"><a href="{{ url('shopper/download/'. $checkboxticked[0]) }}"><i class="fa-solid fa-file-pdf"></i>&nbsp;Save PDF</a></button>
            @if ($this->list_is_completed())
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            @else
            <button type="button" class="sc-btn-danger" wire:click="confirm_delete"><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            @endif
        </div>
    </div>
    @elseif (count($checkboxticked) >= 2)
    <div class="fixed rounded-md bottom-0 bg-white p-3 bg-shadow w-full">
        <div class="flex justify-center space-x-3 lg:space-x-8">
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-eye-slash"></i>&nbsp;View</span></button>
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-pen-to-square"></i>&nbsp;Edit</span></button>
            @if ($this->list_is_completed())
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-check"></i>&nbsp;Mark as completed</span></button>
            @else
            <button type="button" class="sc-btn-ghost" wire:click="confirm(2)"><span><i class="fa-solid fa-check"></i>&nbsp;Mark as completed</span></button>
            @endif
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-file-pdf"></i>&nbsp;Save PDF</span></button>
            @if ($this->list_is_completed())
            <button type="button" class="sc-btn-disabled" disabled><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            @else
            <button type="button" class="sc-btn-danger" wire:click="confirm_delete"><span><i class="fa-solid fa-trash"></i>&nbsp;Delete</span></button>
            @endif
        </div>
    </div>
    @endif
</div>