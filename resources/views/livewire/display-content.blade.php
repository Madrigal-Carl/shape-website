<div class="relative w-full h-full">
    <div wire:loading class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <!-- Spinner -->
        <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin fill-[#247bff]" viewBox="0 0 100 101"
            fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 ..." fill="currentColor" />
            <path d="M93.9676 39.0409C96.393 ..." fill="currentFill" />
        </svg>
    </div>

    <div wire:loading.remove class="col-span-7 grid grid-cols-7">
        @foreach ($sideBarItems as $item)
            @if ($activeSideBar === $item['name'] && $activeSubContent)
                @foreach ($item['subcontent'] ?? [] as $sub)
                    @if ($activeSubContent === $sub['name'])
                        @include($sub['content'])
                    @endif
                @endforeach
            @elseif ($activeSideBar === $item['name'] && !$activeSubContent)
                @include($item['content'])
            @endif
        @endforeach
    </div>
</div>
