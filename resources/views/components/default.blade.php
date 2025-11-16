<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=DynaPuff:wght@400..700&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'SHAPE' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    @livewireStyles
</head>

<body class="overflow-x-hidden ">
    @if (!request()->routeIs('landing.page'))
        <div id="desktop-only" class="hidden fixed inset-0 bg-white z-[9999]">
            <div class="flex flex-col items-center justify-center p-6 text-center h-screen">
                <img src="{{ asset('images/favicon.png') }}" class="w-20 mb-4 opacity-70">
                <h1 class="text-2xl font-bold">Please use this website on a desktop device</h1>
                <p class="text-gray-600 mt-2">This system is not available on small screens.</p>
            </div>
        </div>
    @endif

    {{ $slot }}
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="{{ asset('js/main.js') }}"></script>
    @if (session('toast'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toastData = @json(session('toast'));
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: toastData.icon,
                    title: toastData.title
                });
            });
        </script>
    @endif
    <script>
        function checkScreenSize() {
            const overlay = document.getElementById('desktop-only');
            if (overlay) {
                if (window.innerWidth < 1024) {
                    overlay.classList.remove('hidden');
                } else {
                    overlay.classList.add('hidden');
                }
            }
        }

        window.addEventListener('load', checkScreenSize);
        window.addEventListener('resize', checkScreenSize);
    </script>
</body>

</html>
