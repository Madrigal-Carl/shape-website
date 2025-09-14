<x-default class="bg-card" :title="'SHAPE: Landing Page'">
    <section
        class="bg-card w-dvw lg:h-dvh overflow-hidden p-4 lg:px-8 lg:pt-8 flex flex-col gap-14 items-center lg:justify-between relative hero-section mask-b-from-90% to-transparent
                ">
        {{-- Navbar --}}
        <nav
            class="bg-white w-full lg:w-[60%] p-2 rounded-full shadow-2xl/10 flex items-center justify-between z-40 shrink-0">
            <img src="{{ asset('images/Logo-with-text.svg') }}" alt="" class="h-6 pl-4">

            <div class="hidden lg:flex gap-2">
                <a href=""
                    class="text-paragraph font-medium px-4 py-2 rounded-full hover:bg-blue-button hover:text-white cursor-pointer ">Home</a>
                <a href=""
                    class="text-paragraph font-medium px-4 py-2 rounded-full hover:bg-blue-button hover:text-white cursor-pointer ">About</a>
                <a href=""
                    class="text-paragraph font-medium px-4 py-2 rounded-full hover:bg-blue-button hover:text-white cursor-pointer ">Features</a>
                <a href=""
                    class="text-paragraph font-medium px-4 py-2 rounded-full hover:bg-blue-button hover:text-white cursor-pointer ">Team</a>
                <a href=""
                    class="text-paragraph font-medium px-4 py-2 rounded-full hover:bg-blue-button hover:text-white cursor-pointer ">Contacts</a>
            </div>

            <button
                class="hidden lg:flex items-center gap-2 text-white font-medium px-4 py-2 rounded-full bg-gradient-to-tr from-blue-button to-[#ea00ff] shadow-blue-button shadow-lg/30 hover:scale-105 cursor-pointer">
                <span class="material-symbols-rounded">
                    login
                </span>
                <p>Login</p>
            </button>

            <button
                class="flex lg:hidden items-center gap-2 text-white font-medium p-2 rounded-full bg-gradient-to-tr from-blue-button to-[#ea00ff] shadow-blue-button shadow-lg/30 hover:scale-105 cursor-pointer">
                <span class="material-symbols-rounded">
                    menu
                </span>
            </button>
        </nav>

        {{-- Phone Nav --}}
        <nav
            class="absolute right-2 top-18 hidden lg:hidden w-fit lg:w-[60%] p-2 bg-white/45 backdrop-blur-md rounded-lg shadow-2xl flex-col items-center justify-between z-40 shrink-0">
            <!-- Mobile menu content goes here -->
            <a href=""
                class="text-paragraph w-full text-center font-medium px-4 py-2 hover:bg-blue-button hover:text-white cursor-pointer ">Home</a>
            <a href=""
                class="text-paragraph w-full text-center font-medium px-4 py-2 hover:bg-blue-button hover:text-white cursor-pointer ">About</a>
            <a href=""
                class="text-paragraph w-full text-center font-medium px-4 py-2 hover:bg-blue-button hover:text-white cursor-pointer ">Features</a>
            <a href=""
                class="text-paragraph w-full text-center font-medium px-4 py-2 hover:bg-blue-button hover:text-white cursor-pointer ">Team</a>
            <a href=""
                class="text-paragraph w-full text-center font-medium px-4 py-2 hover:bg-blue-button hover:text-white cursor-pointer ">Contacts</a>

            <button
                class="flex lg:flex items-center w-full text-center mt-10 gap-2 text-white font-medium px-4 py-2 rounded-md bg-gradient-to-tr from-blue-button to-[#ea00ff] shadow-blue-button shadow-lg/30 hover:scale-105 cursor-pointer">
                <p class="w-full">Login</p>
            </button>
        </nav>


        {{-- Heading --}}
        <div class="w-full lg:w-[60%] text-center flex flex-col items-center gap-4 z-30">
            <h1
                class="text-4xl lg:text-6xl h-fit leading-tight font-semibold bg-gradient-to-l from-blue-button via-[#d400ff] to-blue-button bg-clip-text text-transparent">
                Every
                child learns
                differently - SHAPE
                makes learning
                personal.</h1>
            <p class="text-base w-[90%] text-paragraph lg:text-2xl lg:w-[80%] ">Design for children with unique learning
                journeys,
                our
                app
                makes
                education more inclusive, engaging, and accessible</p>

            {{-- Buttons --}}
            <div class="flex items-center gap-2 lg:mt-6">
                <button
                    class="flex items-center gap-2 text-white font-medium px-6 py-3 rounded-full bg-gradient-to-tr from-blue-button to-[#ea00ff] shadow-blue-button shadow-xl/30 hover:scale-105 cursor-pointer">
                    <span class="material-symbols-rounded">
                        android
                    </span>
                    <p class="text-xs lg:text-base">Download APK</p>
                </button>
                <button
                    class="flex items-center gap-2 bg-white text-paragraph font-medium px-6 py-3 rounded-full border-paragraph hover:bg-gradient-to-tr from-blue-button to-[#ea00ff] hover:scale-105 hover:text-white cursor-pointer">
                    <span class="material-symbols-rounded">
                        auto_stories
                    </span>
                    <p class="text-xs lg:text-base">Read Study</p>
                </button>
            </div>
        </div>
        <img src="{{ asset('images/Landing-page/hero.png') }}" alt="" class="lg:w-[60%] z-30">

        <div
            class="absolute -bottom-[5%] lg:-bottom-[10%] w-[1800px] md:w-[2800px] flex items-center justify-between z-20">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[800px] blur-sm animate-float1">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[800px] blur-sm animate-float2">
        </div>
        <div
            class="absolute -bottom-[40%] w[1000px] md:w-[1900px] flex items-center opacity-90 justify-between blur-3xl">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[400px] lg:h-[900px] blur-3xl">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[400px] lg:h-[900px] blur-3xl">
        </div>
    </section>

    {{-- About Us --}}
    <section
        class="w-dvw lg:h-dvh overflow-hidden px-4 py-16 lg:px-8 lg:py-8 flex flex-col gap-10 lg:gap-16 items-center justify-center relative">
        <div class=" w-full text-center flex flex-col items-center gap-6 z-30">
            <h2 class="text-4xl font-bold text-heading-dark">About Shape</h2>
            <p class="text-paragraph lg:text-2xl w-[90%] lg:w-[50%]">SHAPE is dedicated to transforming education for
                children
                with
                special needs. Our mission is to provide personalized learning experiences that empower every child to
                reach
                their full potential.</p>
        </div>

        <img src="{{ asset('images/Landing-page/about-us.png') }}" class="lg:h-150" alt="">

    </section>



    {{-- Features --}}
    <section
        class="w-dvw bg-card lg:h-fit overflow-hidden px-4 py-16 lg:px-8 lg:py-8 flex flex-col gap-10 lg:gap-16 items-center justify-center relative">
        <div class="w-full text-center flex flex-col items-center gap-6 z-30">
            <h2 class="text-4xl font-bold text-heading-dark lg:mt-20">App Features</h2>
            <p class="text-paragraph lg:text-2xl w-[90%] lg:w-[50%]">Explore the innovative features that make SHAPE a
                game-changer
                in
                personalized learning for children with diverse needs.</p>
        </div>

        <div class="grid lg:w-[60%] grid-cols-1 grid-rows-3 md:grid-rows-1 md:grid-cols-3 gap-4 lg:mb-20">

            <div
                class="bg-white shadow-2xl/10 p-8 rounded-2xl flex flex-col items-center gap-4 row-span-1 md:col-span-1">
                <span class="material-symbols-rounded bg-[#d400ff13] text-[#d400ff] mt-5 p-6 rounded-full feature">
                    playground_2
                </span>
                <h3 class="text-xl font-bold text-heading-dark mt-5">Interactive Content</h3>
                <p class="text-paragraph text-center">Engage children with multimedia resources, including videos,
                    and games.</p>
            </div>
            <div
                class="bg-white shadow-2xl/10 p-8 rounded-2xl flex flex-col items-center gap-4 row-span-1 md:col-span-1">
                <span class="material-symbols-rounded bg-[#d400ff13] text-[#d400ff] mt-5 p-6 rounded-full feature">
                    finance_mode
                </span>
                <h3 class="text-xl font-bold text-heading-dark mt-5">Progress Tracking</h3>
                <p class="text-paragraph text-center">Monitor each child's development and adjust learning plans
                    accordingly.</p>
            </div>

            <div
                class="bg-white shadow-2xl/10 p-8 rounded-2xl flex flex-col items-center gap-4 row-span-1 md:col-span-1">
                <span class="material-symbols-rounded bg-[#d400ff13] text-[#d400ff] mt-5 p-6 rounded-full feature">
                    android_wifi_4_bar_off
                </span>
                <h3 class="text-xl font-bold text-heading-dark mt-5">Offline accessibility</h3>
                <p class="text-paragraph text-center">Children can play mini-games, access lessons, and videos offline.
                </p>
            </div>

    </section>

</x-default>
