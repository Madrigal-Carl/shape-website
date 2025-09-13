<x-default class="bg-card" :title="'SHAPE: Landing Page'">
    <section
        class="bg-card w-dvw h-dvh overflow-hidden px-8 pt-8 flex flex-col gap-14 items-center justify-between relative hero-section">
        {{-- Navbar --}}
        <nav class="bg-white w-[60%] p-2 rounded-full shadow-2xl/10 flex items-center justify-between z-40">
            <img src="{{ asset('images/Logo-with-text.svg') }}" alt="" class="h-6 pl-4">

            <div class="flex gap-2">
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
                class="flex items-center gap-2 text-white font-medium px-4 py-2 rounded-full bg-gradient-to-tr from-blue-button to-[#ea00ff] shadow-blue-button shadow-lg/30 hover:scale-105 cursor-pointer">
                <span class="material-symbols-rounded">
                    login
                </span>
                <p>Login</p>
            </button>
        </nav>


        {{-- Heading --}}
        <div class="w-[60%] text-center flex flex-col items-center gap-4 z-30">
            <h1
                class="text-6xl h-fit leading-tight font-semibold bg-gradient-to-l from-blue-button via-[#d400ff] to-blue-button bg-clip-text text-transparent">
                Every
                child learns
                differently - SHAPE
                makes learning
                personal.</h1>
            <p class="text-paragraph text-2xl w-[80%] ">Design for children with unique learning journeys, our app makes
                education more inclusive, engaging, and accessible</p>

            {{-- Buttons --}}
            <div class="flex items-center gap-2 mt-6">
                <button
                    class="flex items-center gap-2 text-white font-medium px-6 py-3 rounded-full bg-gradient-to-tr from-blue-button to-[#ea00ff] shadow-blue-button shadow-xl/30 hover:scale-105 cursor-pointer">
                    <span class="material-symbols-rounded">
                        android
                    </span>
                    <p>Download APK</p>
                </button>
                <button
                    class="flex items-center gap-2 bg-white text-paragraph font-medium px-6 py-3 rounded-full border-paragraph hover:bg-gradient-to-tr from-blue-button to-[#ea00ff] hover:scale-105 hover:text-white cursor-pointer">
                    <span class="material-symbols-rounded">
                        auto_stories
                    </span>
                    <p>Read Study</p>
                </button>
            </div>
        </div>
        <img src="{{ asset('images/Landing-page/hero.png') }}" alt="" class="w-[60%] z-20">

        <div class="absolute bottom-[0%] w-[2800px] flex items-center justify-between z-20">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[800px] blur-sm animate-float1">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[800px] blur-sm animate-float2">
        </div>
        <div class="absolute -bottom-[40%] w-[1900px] flex items-center opacity-90 justify-between blur-3xl">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt="" class="h-[900px] blur-3xl">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt="" class="h-[900px] blur-3xl">
        </div>
    </section>

    {{-- About Us --}}
    <section class=" w-dvw h-fit overflow-hidden px-8 py-8 flex flex-col gap-10 items-center relative">
        <div class=" w-[60%] text-center flex flex-col items-center gap-6 z-30 mt-10">
            <h2 class="text-4xl font-semibold text-heading-dark">About Us</h2>
            <p class="text-paragraph text-2xl w-[70%]">SHAPE is dedicated to transforming education for children with
                special needs. Our mission is to provide personalized learning experiences that empower every child to
                reach
                their full potential.</p>
        </div>

    </section>

    {{-- Features --}}
    <section class="bg-card w-dvw h-fit overflow-hidden px-8 py-8 flex flex-col gap-10 items-center relative">
        <div class=" w-[60%] text-center flex flex-col items-center gap-6 z-30 mt-10">
            <h2 class="text-4xl font-semibold text-heading-dark">App Features</h2>
            <p class="text-paragraph text-2xl w-[70%]">Explore the innovative features that make SHAPE a game-changer in
                personalized learning for children with diverse needs.</p>
        </div>

        <div class="w-[80%] grid grid-cols-3 gap-10 mb-20">
            <div class="bg-white shadow-2xl/10 p-8 rounded-2xl flex flex-col items-center gap-4">
                <img src="{{ asset('images/Landing-page/feature1.png') }}" alt="" class="h-32">
                <h3 class="text-xl font-semibold text-heading-dark">Personalized Learning Paths</h3>
                <p class="text-paragraph text-center">Tailor educational content to each child's unique learning style
                    and
                    pace.</p>
            </div>
            <div class="bg-white shadow-2xl/10 p-8 rounded-2xl flex flex-col items-center gap-4">
                <img src="{{ asset('images/Landing-page/feature2.png') }}" alt="" class="h-32">
                <h3 class="text-xl font-semibold text-heading-dark">Interactive Content</h3>
                <p class="text-paragraph text-center">Engage children with multimedia resources, including videos,
                    games,
                    and quizzes.</p>
            </div>
            <div class="bg-white shadow-2xl/10 p-8 rounded-2xl flex flex-col items-center gap-4">
                <img src="{{ asset('images/Landing-page/feature3.png') }}" alt="" class="h-32">
                <h3 class="text-xl font-semibold text-heading-dark">Progress Tracking</h3>
                <p class="text-paragraph text-center">Monitor each child's development and adjust learning plans
                    accordingly.</p>
            </div>

    </section>

</x-default>
