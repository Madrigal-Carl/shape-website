<x-default>
    <section class="bg-card w-dvw h-dvh overflow-hidden px-8 pt-8 flex flex-col gap-10 items-center relative">
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
                class="flex items-center gap-2 text-white font-medium px-4 py-2 rounded-full bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-lg/30 hover:scale-105 cursor-pointer">
                <span class="material-symbols-rounded">
                    login
                </span>
                <p>Login</p>
            </button>
        </nav>


        {{-- Heading --}}
        <div class="w-[60%] text-center flex flex-col items-center gap-6 z-30 mt-10">
            <h1 class="text-7xl font-semibold">Every child learns differently - <span
                    class="font-black text-blue-button italic">SHAPE</span>
                makes learning
                personal.</h1>
            <p class="text-paragraph text-2xl w-[90%]">Design for children with unique learning journeys, our app makes
                education more inclusive, engaging, and accessible</p>

            {{-- Buttons --}}
            <div class="flex items-center gap-2">
                <button
                    class="text-white font-medium px-6 py-3 rounded-full bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-lg/30 hover:scale-105 cursor-pointer">Download
                    APK</button>
                <button
                    class="text-paragraph font-medium px-6 py-3 rounded-full border-2 border-paragraph hover:border-blue-button hover:bg-blue-button hover:text-white cursor-pointer">Read
                    Research</button>
            </div>
        </div>
        <img src="{{ asset('images/Landing-page/hero.png') }}" alt="" class="w-[60%] z-20">

        <div class="absolute bottom-[0%] w-[2800px] flex items-center justify-between z-20">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[800px] blur-sm animate-float1">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt=""
                class="h-[800px] blur-sm animate-float2">
        </div>
        <div class="absolute -bottom-[40%] w-[1900px] flex items-center opacity-60 justify-between blur-3xl">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt="" class="h-[900px] blur-3xl">
            <img src="{{ asset('images/Landing-page/object.png') }}" alt="" class="h-[900px] blur-3xl">
        </div>
    </section>



</x-default>
