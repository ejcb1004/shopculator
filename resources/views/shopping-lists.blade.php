<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search and Add Button -->
        <div class="flex flex-row-reverse pt-5">
            <div class="flex space-x-2 min-w-full justify-end">
                <div class="flex rounded-full bg-white w-full max-w-xs h-10 items-center">
                    <i class="fa-solid fa-magnifying-glass z-99 pl-4 absolute"></i>
                    <input type="text" placeholder="Search" class="input input-bordered bg-white pl-10 w-full rounded-full h-10" />
                </div>
                <button class="bg-emerald-700 px-6 py-1.5 text-white border-none rounded-full hover:bg-emerald-800 transition:1s"><i class="fa-solid fa-plus"></i>
                    <a href="{{ route('create') }}">
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
                            <!-- row 1 -->
                            <tr class="hover">
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" />
                                    </label>
                                </th>
                                <td>Cy Ganderton</td>
                                <td>Quality Control Specialist</td>
                                <td>Blue</td>
                                <td>00-00-00</td>
                            </tr>
                            <!-- row 2 -->
                            <tr class="hover">
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" />
                                    </label>
                                </th>
                                <td>Hart Hagerty</td>
                                <td>Desktop Support Technician</td>
                                <td>Purple</td>
                                <td>00-00-00</td>
                            </tr>
                            <!-- row 3 -->
                            <tr class="hover">
                                <th>
                                    <label>
                                        <input type="checkbox" class="checkbox checkbox-sm checkbox-accent" />
                                    </label>
                                </th>
                                <td>Brice Swyre</td>
                                <td>Tax Accountant</td>
                                <td>Red</td>
                                <td>00-00-00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>