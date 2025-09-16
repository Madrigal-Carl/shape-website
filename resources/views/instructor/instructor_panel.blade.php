@php
    $sidebar = [
        ['name' => 'Dashboard', 'icon' => 'space_dashboard', 'content' => 'instructor.dashboard'],
        ['name' => 'Curriculums', 'icon' => 'book_4', 'content' => 'instructor.curriculums'],
        ['name' => 'Students', 'icon' => 'group', 'content' => 'instructor.students'],
        [
            'name' => 'Lessons',
            'icon' => 'library_books',
            'content' => 'instructor.lessons',
            'subcontent' => [['name' => 'Activity', 'icon' => 'assignment', 'content' => 'instructor.lesson_activity']],
        ],
        ['name' => 'Awards', 'icon' => 'award_star', 'content' => 'instructor.awards'],
        ['name' => 'Profile', 'icon' => 'account_circle', 'content' => 'layouts.profile'],
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
