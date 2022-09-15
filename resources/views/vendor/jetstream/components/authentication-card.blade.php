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

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
        {{ $logo }}
    </div>
    <div class="w-1/2 lg:w-1/5 mt-8">
        <div x-data="tabs">
            <div class="grid grid-cols-2 cursor-pointer font-bold">
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(1)">Shopper</div>
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(2) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(2)">Market</div>
            </div>
            <div class="min-w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-b-lg">
                <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                    {{ $shopper }}
                </div>
                <div x-show="isActive(2)" x-transition:enter.duration.500ms>
                    {{ $market }}
                </div>
            </div>
        </div>
    </div>

</div>