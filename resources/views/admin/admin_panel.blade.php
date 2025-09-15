@php
    $sidebar = [
        ['name' => 'Dashboard', 'icon' => 'space_dashboard', 'content' => 'admin.dashboard'],
        ['name' => 'Teacher', 'icon' => 'person', 'content' => 'admin.instructor'],
        ['name' => 'Settings', 'icon' => 'settings', 'content' => 'layouts.settings'],
    ];
@endphp

<x-default :title="'SHAPE: Admin'">
    <div class="w-dvw h-dvh font-poppins relative text-heading-dark flex bg-card overflow-hidden gap-4">
        <aside class="w-64 flex-shrink-0">
            <livewire:side-bar :sideBarItems="$sidebar" />
        </aside>

        <main class="flex-1 overflow-y-auto">
            <livewire:display-content :sideBarItems="$sidebar" />
        </main>
    </div>
</x-default>
