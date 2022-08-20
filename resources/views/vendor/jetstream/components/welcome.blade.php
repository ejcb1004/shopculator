<div class="bg-[url('/public/img/shopping.jpg')]">
    <div class="hero min-h-screen">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content">
            <div class="max-w-md">
                <h1 class="text-4xl text-white font-bold">Make your shopping life easier with Shopculator.</h1>
                <p class="py-6 text-white">With Shopculator, an easier shopping budget management experience is at your fingertips. Save more time and money with Shopculator.</p>
                <!-- Buttons -->
                <div class="flex max-w-sm space-x-8 justify-center mx-auto">
                    @if (Route::has('login'))
                    @auth
                    <button class="sc-btn-wisp">
                        <a href="{{ route('shopping-lists') }}">
                            <i class="fa-regular fa-eye"></i>&nbsp;View Lists
                        </a>
                    </button>
                    <button class="sc-btn-action">
                        <a href="{{ route('shopping-lists/create') }}">
                            <i class="fa-solid fa-plus"></i>&nbsp;Create a new list
                        </a>
                    </button>
                    @else
                    <button class="sc-btn-wisp">
                        <a href="{{ route('login') }}">Sign in</a>
                    </button>
                    <button class="sc-btn-action">
                        <a href="{{ route('register') }}">Create a free account</a>
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
                            <path d="M352 256C352 278.2 350.8 299.6 348.7 320H163.3C161.2 299.6 159.1 278.2 159.1 256C159.1 233.8 161.2 212.4 163.3 192H348.7C350.8 212.4 352 233.8 352 256zM503.9 192C509.2 212.5 512 233.9 512 256C512 278.1 509.2 299.5 503.9 320H380.8C382.9 299.4 384 277.1 384 256C384 234 382.9 212.6 380.8 192H503.9zM493.4 160H376.7C366.7 96.14 346.9 42.62 321.4 8.442C399.8 29.09 463.4 85.94 493.4 160zM344.3 160H167.7C173.8 123.6 183.2 91.38 194.7 65.35C205.2 41.74 216.9 24.61 228.2 13.81C239.4 3.178 248.7 0 256 0C263.3 0 272.6 3.178 283.8 13.81C295.1 24.61 306.8 41.74 317.3 65.35C328.8 91.38 338.2 123.6 344.3 160H344.3zM18.61 160C48.59 85.94 112.2 29.09 190.6 8.442C165.1 42.62 145.3 96.14 135.3 160H18.61zM131.2 192C129.1 212.6 127.1 234 127.1 256C127.1 277.1 129.1 299.4 131.2 320H8.065C2.8 299.5 0 278.1 0 256C0 233.9 2.8 212.5 8.065 192H131.2zM194.7 446.6C183.2 420.6 173.8 388.4 167.7 352H344.3C338.2 388.4 328.8 420.6 317.3 446.6C306.8 470.3 295.1 487.4 283.8 498.2C272.6 508.8 263.3 512 255.1 512C248.7 512 239.4 508.8 228.2 498.2C216.9 487.4 205.2 470.3 194.7 446.6H194.7zM190.6 503.6C112.2 482.9 48.59 426.1 18.61 352H135.3C145.3 415.9 165.1 469.4 190.6 503.6V503.6zM321.4 503.6C346.9 469.4 366.7 415.9 376.7 352H493.4C463.4 426.1 399.8 482.9 321.4 503.6V503.6z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-xl text-black mb-3">
                        Progressive Web App
                    </h4>
                    <p class="text-body-color">
                        Thanks to Google's PWA framework, you can access your shopping lists on both PC and mobile. It only takes a click to download.
                    </p>
                </div>
            </div>
            <div class="w-full">
                <div class="flex flex-col items-center p-10 md:px-7 xl:px-10 rounded-[20px] bg-white shadow-md hover:shadow-lg">
                    <div class="w-[80px] h-[80px] flex items-center justify-center bg-gradient-to-r from-emerald-400 to-teal-600 rounded-full mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="40" height="40" fill="#FFFFFF">
                            <path d="M160 0C177.7 0 192 14.33 192 32V67.68C193.6 67.89 195.1 68.12 196.7 68.35C207.3 69.93 238.9 75.02 251.9 78.31C268.1 82.65 279.4 100.1 275 117.2C270.7 134.3 253.3 144.7 236.1 140.4C226.8 137.1 198.5 133.3 187.3 131.7C155.2 126.9 127.7 129.3 108.8 136.5C90.52 143.5 82.93 153.4 80.92 164.5C78.98 175.2 80.45 181.3 82.21 185.1C84.1 189.1 87.79 193.6 95.14 198.5C111.4 209.2 136.2 216.4 168.4 225.1L171.2 225.9C199.6 233.6 234.4 243.1 260.2 260.2C274.3 269.6 287.6 282.3 295.8 299.9C304.1 317.7 305.9 337.7 302.1 358.1C295.1 397 268.1 422.4 236.4 435.6C222.8 441.2 207.8 444.8 192 446.6V480C192 497.7 177.7 512 160 512C142.3 512 128 497.7 128 480V445.1C127.6 445.1 127.1 444.1 126.7 444.9L126.5 444.9C102.2 441.1 62.07 430.6 35 418.6C18.85 411.4 11.58 392.5 18.76 376.3C25.94 360.2 44.85 352.9 60.1 360.1C81.9 369.4 116.3 378.5 136.2 381.6C168.2 386.4 194.5 383.6 212.3 376.4C229.2 369.5 236.9 359.5 239.1 347.5C241 336.8 239.6 330.7 237.8 326.9C235.9 322.9 232.2 318.4 224.9 313.5C208.6 302.8 183.8 295.6 151.6 286.9L148.8 286.1C120.4 278.4 85.58 268.9 59.76 251.8C45.65 242.4 32.43 229.7 24.22 212.1C15.89 194.3 14.08 174.3 17.95 153C25.03 114.1 53.05 89.29 85.96 76.73C98.98 71.76 113.1 68.49 128 66.73V32C128 14.33 142.3 0 160 0V0z" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="40" height="40" fill="#FFFFFF">
                            <path d="M0 155.2C0 147.9 2.153 140.8 6.188 134.7L81.75 21.37C90.65 8.021 105.6 0 121.7 0H518.3C534.4 0 549.3 8.021 558.2 21.37L633.8 134.7C637.8 140.8 640 147.9 640 155.2C640 175.5 623.5 192 603.2 192H36.84C16.5 192 .0003 175.5 .0003 155.2H0zM64 224H128V384H320V224H384V464C384 490.5 362.5 512 336 512H112C85.49 512 64 490.5 64 464V224zM512 224H576V480C576 497.7 561.7 512 544 512C526.3 512 512 497.7 512 480V224z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-xl text-black mb-3">
                        Content Aggregation
                    </h4>
                    <p class="text-body-color">
                        With our connections to different supermarkets online, you can choose from a vast array of items, complete with sorting and filtering.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ====== Services Section End -->