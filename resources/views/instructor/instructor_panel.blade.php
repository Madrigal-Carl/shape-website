@php
    $sidebar = [
        ['name' => 'Dashboard', 'icon' => 'space_dashboard', 'content' => 'instructor.dashboard'],
        ['name' => 'Curriculums', 'icon' => 'book_4', 'content' => 'instructor.curriculums'],
        ['name' => 'Students', 'icon' => 'group', 'content' => 'instructor.students'],
        ['name' => 'Lessons', 'icon' => 'library_books', 'content' => 'instructor.lessons'],
        ['name' => 'Awards', 'icon' => 'award_star', 'content' => 'instructor.awards'],
        ['name' => 'Settings', 'icon' => 'settings', 'content' => 'layouts.settings'],
    ];
@endphp

<x-default :title="'SHAPE: Intructor'">
    <div class="w-dvw h-dvh font-poppins relative text-heading-dark flex bg-card overflow-hidden gap-4">
        <!-- Navigations -->
        <aside class="w-64 flex-shrink-0">
            <livewire:side-bar :sideBarItems="$sidebar" />
        </aside>

        <main class="flex-1 overflow-y-auto">
            <livewire:display-content :sideBarItems="$sidebar" />
        </main>

    </div>
</x-default>
