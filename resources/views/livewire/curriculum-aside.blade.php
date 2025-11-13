<aside class="col-span-2 grid grid-cols-1 grid-rows-1 px-4 py-4 gap-4 h-dvh">
    <!-- System Feed -->
    <div class="bg-white w-full min-h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col">
        <div class="flex gap-2 items-center p-3">
            <img src="{{ asset('images/system-feed.png') }}" class="h-6" alt="">
            <h1 class="text-2xl font-bold">System Feed</h1>
        </div>

        <!-- System Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto">
            @forelse ($feeds as $feed)
                <div class="flex flex-col gap-2 w-full bg-card p-3 rounded-lg">
                    <!-- System Details -->
                    <h2 class="leading-tight font-medium text-md line-clamp-3">
                        {{ $feed->message }}
                    </h2>
                    <p class="text-sm leading-tight text-paragraph">
                        {{ \Carbon\Carbon::parse($feed->created_at)->diffForHumans() }}</p>
                </div>
            @empty
                <div class="h-full w-full text-center py-[100%]">
                    <p class="text-paragraph">No System Feed yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</aside>
