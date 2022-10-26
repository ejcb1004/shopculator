<div>
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8">
        <div x-data="tabs" class="pt-8">
            <div class="grid grid-cols-3 cursor-pointer font-bold">
                @for ($i = 0; $i < count($titles); $i++)
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive({{ $i + 1 }}) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive({{ $i + 1 }})">
                    {{ $titles[$i] }}
                </div>
                @endfor
            </div>
            <div class="min-w-full sm:max-w-md px-6 py-4 bg-white shadow-md h-[700px] sm:rounded-b-lg overflow-scroll">
                @for ($i = 0; $i < count($titles); $i++)
                <div x-show="isActive({{ $i + 1 }})" x-transition:enter.duration.500ms>
                    <div class="overflow-scroll rounded-lg">
                        <div data-theme="mytheme">
                            <table class="table w-full">
                                <!-- head -->
                                <thead class="text-white">
                                    <tr>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="hover table-group">
                                        <td class="table-item">Product</td>
                                        <td class="table-item">Count</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
    <script>
        function tabs() {
            return {
                active: 1,
                isActive(tab) {
                    return tab == this.active;
                },
                setActive(value) {
                    this.active = value;
                }
            }
        }
    </script>
</div>