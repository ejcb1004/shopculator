<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="pt-12">
            <div class="mb-4 flex justify-end">
                <button type="button" class="sc-btn-red-ghost"><a href="{{ url('shopper/download/'. $list_id) }}"><i class="fa-solid fa-file-pdf"></i>&nbsp;Save PDF</a></button>
            </div>
            <div class="rounded-lg max-h-[200px] text-center py-4 mb-4 bg-white">
                <p class="text-2xl text-black">{{ $list->list_name }}</p>
                <i class="text-sm text-gray-600">Created at:&nbsp;
                    @php
                    $dt = new DateTime($list['created_at']);
                    $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                    echo $dt->format('h:i:s a, M d, Y');
                    @endphp
                </i>
                <br>
                <i class="text-sm text-gray-600">Updated at:&nbsp;
                    @php
                    $dt = new DateTime($list['updated_at']);
                    $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                    echo $dt->format('h:i:s a, M d, Y');
                    @endphp
                </i>
                <br>
                @switch($list->list_status)
                @case(1)
                <span class="py-0.5 px-4 rounded-full bg-emerald-200 text-emerald-700">Active</span>
                @break
                @default
                <span class="py-0.5 px-4 rounded-full bg-blue-200 text-blue-700">Completed</span>
                @endswitch
            </div>
            <div class="rounded-lg max-h-[700px] xl:max-h-[650px] mb-4 overflow-auto">
                <div data-theme="mytheme">
                    <table class="table w-full text-md">
                        <!-- head -->
                        <thead class="text-white">
                            <tr class="text-center">
                                <th>
                                    <!-- List Index -->
                                </th>
                                <th>Product</th>
                                <th class="hidden lg:table-cell">Price</th>
                                <th class="hidden lg:table-cell">Quantity</th>
                                <th class="rounded-tr-lg lg:rounded-none">Net Price</th>
                                <th class="hidden lg:table-cell">Updated at</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($list_details as $detail)
                            <tr class="hover table-group">
                                <input value="{{ $detail['id'] }}" name="id" id="id" hidden />
                                <td class="table-item">
                                    <input disabled type="checkbox" value="{{ $detail['product_id'] }}" class="checkbox checkbox-xs checkbox-accent" wire:model="productchecked" />&nbsp;{{ $detail['list_index'] + 1 }}
                                </td>
                                <td class="table-item">
                                    <img src="{{ $detail['image_path'] }}" width="80" alt="Image" class="mb-2 mx-auto" />
                                    {{ $detail['product_name'] }}
                                    <br class="lg:hidden">
                                    <span class="lg:hidden">
                                        @php
                                        $dt = new DateTime($detail['updated_at']);
                                        $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                                        echo $dt->format('h:i:s a, M d, Y');
                                        @endphp
                                    </span>
                                </td>
                                <td class="table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($detail['current_price'], 2, '.') }}
                                    <p class="lg:hidden">x {{ $detail['quantity'] }}</p>
                                    <p class="lg:hidden">=&nbsp;<i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($detail['current_price'] * $detail['quantity'], 2, '.') }}</p>
                                </td>
                                <td class="hidden lg:table-cell table-item">x {{ $detail['quantity'] }}</td>
                                <td class="hidden lg:table-cell table-item"><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($detail['current_price'] * $detail['quantity'], 2, '.') }}</td>
                                <td class="hidden lg:table-cell table-item">
                                    @php
                                    $dt = new DateTime($detail['updated_at']);
                                    $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                                    echo $dt->format('h:i:s a, M d, Y');
                                    @endphp
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td><i>No list items</i></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="rounded-lg max-h-[200px] text-center py-4 mb-4 bg-white ">
                <div class="grid grid-cols-2 text-black text-lg">
                    <div>Budget</div>
                    <div><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($list->budget, 2, '.') }}</div>
                    <div>Total</div>
                    <div><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($list->total, 2, '.') }}</div>
                    <div>Remaining</div>
                    <div><i class="fa-solid fa-peso-sign text-black"></i>&nbsp;{{ number_format($list->budget - $list->total, 2, '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>