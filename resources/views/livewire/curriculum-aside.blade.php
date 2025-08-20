<aside class="col-span-2 grid grid-cols-1 pr-4 py-4 gap-4 h-dvh">
    <!-- System Feed -->
    <div class="bg-white w-full h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col gap-3">
        <div class="flex gap-2 items-center p-3">
            <span class="material-symbols-rounded text-danger">settings_alert</span>
            <h1 class="text-xl font-semibold">System Feed</h1>
        </div>

        <!-- System Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto">
            @forelse ($feeds as $feed)
                <div class="flex flex-col gap-2 w-full bg-card p-3 rounded-lg">
                    <!-- System Details -->
                    <h2 class="leading-tight font-medium text-md">
                        {{ $feed->message }}
                    </h2>
                    <p class="text-xs leading-tight text-paragraph">
                        {{ \Carbon\Carbon::parse($feed->created_at)->diffForHumans() }}</p>
                </div>
            @empty
                <div class="h-full w-full text-center">
                    <p>Empty</p>
                </div>
            @endforelse
        </div>
    </div>
</aside>
