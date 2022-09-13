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