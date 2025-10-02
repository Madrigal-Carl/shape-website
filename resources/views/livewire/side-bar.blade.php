<nav class="bg-white flex flex-col items-center p-6 gap-14 h-full">
    <!-- Logo -->
    <img src="{{ asset('images/Shape-logo-w-text.png') }}" class="w-38" alt="" />

    <!-- Account Info -->
    <div class="flex flex-col gap-2 items-center">
        <img src="{{ asset('storage/' . auth()->user()->accountable->path) }}"
            class="w-24 h-24 aspect-square object-cover rounded-full" alt="" />
        <div class="flex flex-col items-center">
            <p class="text-lg">
                <span class="font-semibold leading-none">{{ auth()->user()->accountable->last_name }},
                </span>{{ auth()->user()->accountable->first_name }}
            </p>
            <small class="leading-none text-paragraph">
                {{ auth()->user()->accountable_type === 'App\Models\Instructor' ? 'Sned Teacher' : 'Sned Admin' }}
            </small>
        </div>
    </div>

    <!-- Nav Controls -->
    <div class="w-full text-paragraph flex flex-col gap-2">
        @foreach ($sideBarItems as $item)
            <div class="flex flex-col">
                <a wire:click="setActiveSideBar('{{ $item['name'] }}')"
                    class="cursor-pointer hover:bg-card hover:text-blue-button flex items-center gap-2 px-8 py-4 rounded-xl
                        {{ $activeSideBar === $item['name'] && !$activeSubContent ? 'active:bg-blue-button active:text-white active-nav' : '' }}">
                    <span class="material-symbols-rounded">{{ $item['icon'] }}</span>
                    <p>{{ $item['name'] }}</p>
                </a>

                {{-- Check if item has subcontent --}}
                @if (isset($item['subcontent']))
                    <div
                        class="ml-11 mt-2 flex flex-col gap-1 transition-all duration-200 ease-in-out
                        {{ $expanded === $item['name'] ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0 overflow-hidden' }}">
                        @foreach ($item['subcontent'] as $sub)
                            <div class="h-full flex items-center w-full gap-2">
                                <div class="border-l-2 border-black hover:border-blue-button h-full"></div>
                                <a wire:click="setActiveSubContent('{{ $item['name'] }}', '{{ $sub['name'] }}')"
                                    class="cursor-pointer hover:bg-card hover:text-blue-button flex items-center gap-2 px-4 py-2 hover:rounded-lg text-sm w-full
                                    {{ $activeSubContent === $sub['name'] ? 'active:bg-blue-button active:text-white active-nav rounded-lg' : '' }}">
                                    <span class="material-symbols-rounded text-sm">{{ $sub['icon'] }}</span>
                                    <p>{{ $sub['name'] }}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach

        {{-- Logout --}}
        <a wire:click="logoutConfirm"
            class="cursor-pointer hover:bg-card hover:text-blue-button flex gap-2 active:bg-blue-button px-8 py-4 active:text-white rounded-xl">
            <span class="material-symbols-rounded">door_back</span>
            <p>Logout</p>
        </a>
    </div>
</nav>


<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('show-logout-confirm', () => {
            Swal.fire({
                title: 'Are you sure you want to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                customClass: {
                    title: 'swal-title',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('logout');
                }
            });
        });
    });
</script>
