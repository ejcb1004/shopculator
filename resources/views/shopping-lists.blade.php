<x-app-layout>
    <!-- Search and Add Button -->
    <div>
        <div class="flex flex-row-reverse py-5 px-20">
            <div class="flex space-x-5">
                <input type="text" placeholder="Search" class="input input-bordered bg-white w-full max-w-xs" />
                <button class="btn bg-emerald-700 text-white border-0 hover:bg-emerald-800 transition:1s"><i class="fa-solid fa-plus"> Add List</i></button>
            </div>
        </div>
    </div>
    <!-- List Management Table -->
    <div class="py-5 px-20">
        <div class="overflow-auto rounded-lg">
            <div data-theme="mytheme">
                <table class="table w-full">
                    <!-- head -->
                    <thead class="text-white">
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" class="checkbox" />
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
                                    <input type="checkbox" class="checkbox" />
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
                                    <input type="checkbox" class="checkbox" />
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
                                    <input type="checkbox" class="checkbox" />
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
</x-app-layout>