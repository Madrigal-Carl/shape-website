<!-- Aside -->
<aside class="col-span-2 grid grid-cols-1 grid-rows-2 pl-4 pr-4 py-4 gap-4 h-dvh">

    <!-- System Feed -->
    <div class="row-span-2 bg-white w-full h-full rounded-3xl px-3 pt-3 pb-6 flex flex-col">
        <div class="flex gap-2 items-center p-3">
            <img src="{{ asset('images/system-feed.png') }}" class="h-6" alt="">
            <h1 class="text-2xl font-bold">System Feed</h1>
        </div>

        <!-- System Notifications -->
        <div class="flex flex-col gap-2 px-3 overflow-y-auto">
            @forelse ($feeds as $feed)
                <div class="flex gap-2 w-full bg-card p-3 rounded-lg">
                    <div class="flex flex-col gap-2">
                        <h2 class="leading-tight font-semibold text-lg line-clamp-2">
                            {{ $feed->title }}
                        </h2>
                        <p class="text-base leading-tight line-clamp-3">
                            {{ $feed->message }}
                        </p>
                        <span class="text-sm text-paragraph mt-1">
                            {{ $feed->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-paragraph italic">No recent activity.</p>
            @endforelse
        </div>
    </div>
</aside>
