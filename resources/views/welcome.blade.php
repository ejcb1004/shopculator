<x-app-layout>
    <div class="bg-[url('/public/img/shopping.jpg')]">
        <div class="hero min-h-screen">
            <div class="hero-overlay bg-opacity-60"></div>
            <div class="hero-content text-center text-neutral-content">

                <div class="max-w-xl">
                    <h1 class="text-5xl text-white font-bold">Make your shopping life easier with Shopculator.</h1>
                    <p class="py-6 text-white text-lg">With Shopculator, an easier shopping budget management experience is at your fingertips. Save more time and money with Shopculator.</p>
                    <!-- Buttons -->
                    <div class="flex max-w-sm space-x-4 justify-center mx-auto">
                        @if (Route::has('login'))
                        @auth
                        @if (Auth::user()->role_id == 'R3')
                        <button class="sc-btn-wisp">
                            <a href="{{ route('shopper') }}" class="text-lg">
                                <i class="fa-regular fa-eye"></i>&nbsp;View Lists
                            </a>
                        </button>
                        <button class="sc-btn-action">
                            <a href="{{ route('shopper/create') }}" class="text-lg">
                                <i class="fa-solid fa-plus"></i>&nbsp;Create a new list
                            </a>
                        </button>
                        @endif
                        @else
                        <button class="sc-btn-wisp">
                            <a href="{{ route('login') }}" class="text-lg">Sign in</a>
                        </button>
                        <button class="sc-btn-action">
                            <a href="{{ route('register') }}" class="text-lg">Create a free account</a>
                        </button>
                        @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== Services Section Start -->
    <section class="flex min-h-screen justify-center items-center pt-20 lg:pt-[120px] pb-12 lg:pb-[90px]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full px-4">
                    <div class="text-center mx-auto mb-12 lg:mb-20 max-w-[380px] sm:max-w-[510px] lg:max-w-[720px]">
                        <span class="font-semibold text-xl text-teal-500 mb-2 block">
                            App Features
                        </span>
                        <h2 class="font-bold text-3xl sm:text-4xl md:text-[40px] text-black mb-4">
                            How We Stand Out
                        </h2>
                        <span class="text-body-color text-lg">
                            Shopping has never been easier with Shopculator. Now you don't have to waste time
                            calculating your expenses and manage your budget by hand.
                        </span>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-2">
                <div class="w-full">
                    <div class="flex flex-col items-center p-10 md:px-7 xl:px-10 rounded-[20px] bg-white shadow-md hover:shadow-lg">
                        <div class="w-[80px] h-[80px] flex items-center justify-center bg-gradient-to-r from-emerald-400 to-teal-600 rounded-full mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="40" height="40" fill="#FFFFFF">
                                <path d="M512 80C512 98.01 497.7 114.6 473.6 128C444.5 144.1 401.2 155.5 351.3 158.9C347.7 157.2 343.9 155.5 340.1 153.9C300.6 137.4 248.2 128 192 128C183.7 128 175.6 128.2 167.5 128.6L166.4 128C142.3 114.6 128 98.01 128 80C128 35.82 213.1 0 320 0C426 0 512 35.82 512 80V80zM160.7 161.1C170.9 160.4 181.3 160 192 160C254.2 160 309.4 172.3 344.5 191.4C369.3 204.9 384 221.7 384 240C384 243.1 383.3 247.9 381.9 251.7C377.3 264.9 364.1 277 346.9 287.3C346.9 287.3 346.9 287.3 346.9 287.3C346.8 287.3 346.6 287.4 346.5 287.5L346.5 287.5C346.2 287.7 345.9 287.8 345.6 288C310.6 307.4 254.8 320 192 320C132.4 320 79.06 308.7 43.84 290.9C41.97 289.9 40.15 288.1 38.39 288C14.28 274.6 0 258 0 240C0 205.2 53.43 175.5 128 164.6C138.5 163 149.4 161.8 160.7 161.1L160.7 161.1zM391.9 186.6C420.2 182.2 446.1 175.2 468.1 166.1C484.4 159.3 499.5 150.9 512 140.6V176C512 195.3 495.5 213.1 468.2 226.9C453.5 234.3 435.8 240.5 415.8 245.3C415.9 243.6 416 241.8 416 240C416 218.1 405.4 200.1 391.9 186.6V186.6zM384 336C384 354 369.7 370.6 345.6 384C343.8 384.1 342 385.9 340.2 386.9C304.9 404.7 251.6 416 192 416C129.2 416 73.42 403.4 38.39 384C14.28 370.6 .0003 354 .0003 336V300.6C12.45 310.9 27.62 319.3 43.93 326.1C83.44 342.6 135.8 352 192 352C248.2 352 300.6 342.6 340.1 326.1C347.9 322.9 355.4 319.2 362.5 315.2C368.6 311.8 374.3 308 379.7 304C381.2 302.9 382.6 301.7 384 300.6L384 336zM416 278.1C434.1 273.1 452.5 268.6 468.1 262.1C484.4 255.3 499.5 246.9 512 236.6V272C512 282.5 507 293 497.1 302.9C480.8 319.2 452.1 332.6 415.8 341.3C415.9 339.6 416 337.8 416 336V278.1zM192 448C248.2 448 300.6 438.6 340.1 422.1C356.4 415.3 371.5 406.9 384 396.6V432C384 476.2 298 512 192 512C85.96 512 .0003 476.2 .0003 432V396.6C12.45 406.9 27.62 415.3 43.93 422.1C83.44 438.6 135.8 448 192 448z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-xl text-black mb-3">
                            Budget Limiter
                        </h4>
                        <p class="text-body-color">
                            We believe that shopping lists should define what needs to be bought. Now it's much easier to avoid unnecessary purchases.
                        </p>
                    </div>
                </div>
                <div class="w-full">
                    <div class="flex flex-col items-center p-10 md:px-7 xl:px-10 rounded-[20px] bg-white shadow-md hover:shadow-lg">
                        <div class="w-[80px] h-[80px] flex items-center justify-center bg-gradient-to-r from-emerald-400 to-teal-600 rounded-full mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="40" height="40" fill="#FFFFFF">
                                <path d="M88 304H80V256H88C101.3 256 112 266.7 112 280C112 293.3 101.3 304 88 304zM192 256H200C208.8 256 216 263.2 216 272V336C216 344.8 208.8 352 200 352H192V256zM224 0V128C224 145.7 238.3 160 256 160H384V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64C0 28.65 28.65 0 64 0H224zM64 224C55.16 224 48 231.2 48 240V368C48 376.8 55.16 384 64 384C72.84 384 80 376.8 80 368V336H88C118.9 336 144 310.9 144 280C144 249.1 118.9 224 88 224H64zM160 368C160 376.8 167.2 384 176 384H200C226.5 384 248 362.5 248 336V272C248 245.5 226.5 224 200 224H176C167.2 224 160 231.2 160 240V368zM288 224C279.2 224 272 231.2 272 240V368C272 376.8 279.2 384 288 384C296.8 384 304 376.8 304 368V320H336C344.8 320 352 312.8 352 304C352 295.2 344.8 288 336 288H304V256H336C344.8 256 352 248.8 352 240C352 231.2 344.8 224 336 224H288zM256 0L384 128H256V0z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-xl text-black mb-3">
                            Save as PDF
                        </h4>
                        <p class="text-body-color">
                            You can download your shopping lists as a PDF document to ensure you have an offline copy when you're managing your expenses.
                        </p>
                    </div>
                </div>
                <div class="w-full">
                    <div class="flex flex-col items-center p-10 md:px-7 xl:px-10 rounded-[20px] bg-white shadow-md hover:shadow-lg">
                        <div class="w-[80px] h-[80px] flex items-center justify-center bg-gradient-to-r from-emerald-400 to-teal-600 rounded-full mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="45" height="45" fill="#FFFFFF">
                                <path d="M547.6 103.8L490.3 13.1C485.2 5 476.1 0 466.4 0H109.6C99.9 0 90.8 5 85.7 13.1L28.3 103.8c-29.6 46.8-3.4 111.9 51.9 119.4c4 .5 8.1 .8 12.1 .8c26.1 0 49.3-11.4 65.2-29c15.9 17.6 39.1 29 65.2 29c26.1 0 49.3-11.4 65.2-29c15.9 17.6 39.1 29 65.2 29c26.2 0 49.3-11.4 65.2-29c16 17.6 39.1 29 65.2 29c4.1 0 8.1-.3 12.1-.8c55.5-7.4 81.8-72.5 52.1-119.4zM499.7 254.9l-.1 0c-5.3 .7-10.7 1.1-16.2 1.1c-12.4 0-24.3-1.9-35.4-5.3V384H128V250.6c-11.2 3.5-23.2 5.4-35.6 5.4c-5.5 0-11-.4-16.3-1.1l-.1 0c-4.1-.6-8.1-1.3-12-2.3V384v64c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V384 252.6c-4 1-8 1.8-12.3 2.3z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-xl text-black mb-3">
                            Grocer Partnership
                        </h4>
                        <p class="text-body-color">
                            Partner up with us and we will provide you with an online platform for shoppers to make shopping lists with your products.
                        </p>
                    </div>
                </div>
                <div class="w-full">
                    <div class="flex flex-col items-center p-10 md:px-7 xl:px-10 rounded-[20px] bg-white shadow-md hover:shadow-lg">
                        <div class="w-[80px] h-[80px] flex items-center justify-center bg-gradient-to-r from-emerald-400 to-teal-600 rounded-full mb-8">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="50" height="50" fill="#FFFFFF">
                                <path d="M384 32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H398.4c-5.2 25.8-22.9 47.1-46.4 57.3V448H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H320 128c-17.7 0-32-14.3-32-32s14.3-32 32-32H288V153.3c-23.5-10.3-41.2-31.6-46.4-57.3H128c-17.7 0-32-14.3-32-32s14.3-32 32-32H256c14.6-19.4 37.8-32 64-32s49.4 12.6 64 32zM125.8 177.3L51.1 320H204.9L130.2 177.3c-.4-.8-1.3-1.3-2.2-1.3s-1.7 .5-2.2 1.3zM128 128c18.8 0 36 10.4 44.7 27l77.8 148.5c3.1 5.8 6.1 14 5.5 23.8c-.7 12.1-4.8 35.2-24.8 55.1C210.9 402.6 178.2 416 128 416s-82.9-13.4-103.2-33.5c-20-20-24.2-43-24.8-55.1c-.6-9.8 2.5-18 5.5-23.8L83.3 155c8.7-16.6 25.9-27 44.7-27zm384 48c-.9 0-1.7 .5-2.2 1.3L435.1 320H588.9L514.2 177.3c-.4-.8-1.3-1.3-2.2-1.3zm-44.7-21c8.7-16.6 25.9-27 44.7-27s36 10.4 44.7 27l77.8 148.5c3.1 5.8 6.1 14 5.5 23.8c-.7 12.1-4.8 35.2-24.8 55.1C594.9 402.6 562.2 416 512 416s-82.9-13.4-103.2-33.5c-20-20-24.2-43-24.8-55.1c-.6-9.8 2.5-18 5.5-23.8L467.3 155z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-xl text-black mb-3">
                            Product Comparison
                        </h4>
                        <p class="text-body-color">
                            You can freely select available products, compare them with each other, and add the cheapest item among them to your list. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Services Section End -->
</x-app-layout>