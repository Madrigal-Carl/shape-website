<div class="font-poppins text-heading-dark w-dvw h-dvh bg-cover bg-center bg-no-repeat flex items-center justify-center"
    style="background-image: url('{{ asset('images/login-backdrop.png') }}')">
    <!-- Login -->
    <form wire:submit='login'
        class="w-96 flex flex-col gap-6 bg-[#e7e7e7a1] p-8 rounded-4xl backdrop-blur-xl shadow-2xl/60 shadow-gray-800 border-2 border-white/40">
        <!-- logo -->

        <div class="flex items-center justify-between gap-2 mb-8">
            <h1 class="font-semibold italic">Welcome</h1>
            <p class=" font-light">to shape</p>
            {{-- <img class="w-30" src="{{ asset('images/Shape-logo-w-text.png') }}" alt="" /> --}}
        </div>

        <div class="flex items-center justify-between">
            <h1 class="font-normal text-[32px]">Log in</h1>
            <span class="material-symbols-rounded scale-180 animate-pulse">
                arrow_forward
            </span>
        </div>

        <!-- Inputs -->
        <div class="flex flex-col gap-4">
            <div
                class="flex items-center gap-1 text-sm bg-white/30 p-1.5 rounded-full outline-none border-2 border-white/0 hover:border-white/60 hover:shadow-xl focus:border-blue-button ">
                <span class="material-symbols-rounded bg-white/80 p-2 rounded-full">
                    alternate_email
                </span>
                <input wire:model="username"
                    class="text-base w-full h-full p-2 pl-4 rounded-full outline-none placeholder:text-heading-dark"
                    type="text" placeholder="username" />
            </div>
            <div
                class="flex items-center gap-1 text-sm bg-white/30 p-1.5 rounded-full outline-none border-2 border-white/0 hover:border-white/60 hover:shadow-xl focus:border-blue-button">
                <span class="material-symbols-rounded bg-white/80 p-2 rounded-full stroke">
                    key
                </span>
                <input wire:model="password"
                    class="text-base w-full h-full p-2 pl-4 rounded-full outline-none placeholder:text-heading-dark"
                    type="password" placeholder="password" />
            </div>
        </div>

        <!-- Login Button -->
        <button type="submit"
            class=" p-3 rounded-full font-semibold bg-white/80 hover:text-white hover:bg-blue-button cursor-pointer hover:bg-gradient-to-tr  from-blue-button to-[#00EEFF] shadow-blue-button  hover:shadow-xl/25 ">
            Login
        </button>
    </form>

    <div wire:loading wire:target="login"
        class="bg-black/30 fixed w-dvw h-dvh z-50 backdrop-blur-xs flex justify-center items-center" role="status">
        <svg aria-hidden="true" class="absolute top-1/2 left-[48.5%] w-12 h-12 text-gray-200 animate-spin fill-blue-600"
            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="currentColor" />
            <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentFill" />
        </svg>
        <span class="sr-only">Loading...</span>
    </div>

</div>
