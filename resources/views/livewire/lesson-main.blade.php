<main class="col-span-7 px-8 py-4 flex flex-col h-dvh gap-16 overflow-y-none">
    <!-- Greetings -->
    @php
        $user = App\Models\Account::with('accountable')->find(auth()->id());
    @endphp
    <div class="flex gap-2 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-1 h-full bg-blue-button rounded-full"></span>
            <div>
                <h1 class="text-2xl font-medium">
                    Welcome back,
                    <span class="font-bold text-blue-button">{{ $user->accountable->first_name }}</span>
                </h1>
                <p class="text-sm text-paragraph">Here is your summary today</p>
            </div>
        </div>

        <!-- Buttons -->
        <button wire:click="openAddLessonModal"
            class="relative flex items-center justify-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105"
            wire:loading.attr="disabled" wire:target="openAddLessonModal">

            <!-- Normal state -->
            <div class="flex items-center gap-2" wire:loading.class="invisible" wire:target="openAddLessonModal">
                <span class="material-symbols-rounded">add</span>
                <p class="text-sm">Add New Lesson</p>
            </div>

            <!-- Loading spinner -->
            <div wire:loading wire:target="openAddLessonModal" role="status"
                class="absolute top-[25%] left-[45%] flex items-center justify-center">
                <svg aria-hidden="true" class="w-6 h-6 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </button>
    </div>

    <!-- curriculumn Table -->
    <div class="flex flex-col gap-4 min-h-[20%]">
        <div class="side flex items-center justify-between gap-2">
            <h1 class="text-4xl font-medium">Lesson List</h1>
            <div class="flex gap-4">
                <div
                    class="flex gap-2 items-center bg-white py-3 px-5 rounded-full shadow-2xl text-paragraph border-2 border-white hover:border-blue-button cursor-pointer">
                    <span class="material-symbols-rounded">search</span>
                    <input type="text" class="outline-none w-20 focus:w-60 placeholder-paragraph"
                        wire:model.live="search" placeholder="Search">
                </div>
            </div>
        </div>

        <div class="flex flex-col min-h-[20%] p-6 bg-white rounded-3xl">
            <div class="flex flex-col overflow-y-scroll">
                <div class="flex flex-col bg-whitel rounded-3xl bg-white">
                    <table class="table-auto border-separate relative">
                        <thead class="sticky top-0 left-0 z-40 bg-white">
                            <tr>
                                <th class="px-4 pb-3 text-center font-semibold">ID</th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Lesson Name
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Curriculum
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Subjects
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">
                                    Assigned
                                </th>
                                <th class="px-4 pb-3 text-center font-semibold">Videos</th>
                                <th class="px-4 pb-3 text-center font-semibold">Games</th>
                                <th class="px-4 pb-3 text-center font-semibold">Quizzes</th>
                                <th class="px-4 pb-3 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($lessons as $lesson)
                                <tr>
                                    <td class="px-4 py-3 text-center text-paragraph">{{ $lesson->id }}</td>
                                    <td class="px-4 py-3 text-center text-paragraph">{{ ucwords($lesson->title) }}</td>
                                    <td class="px-4 py-3 text-center text-paragraph">
                                        {{ ucwords($lesson->lessonSubjectStudents->first()->curriculumSubject->curriculum->name) }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{ ucwords($lesson->lessonSubjectStudents->first()->curriculumSubject->subject->name) }}
                                    </td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->lesson_subject_students_count }}</td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->videos_count }}</td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->activity_lessons_count }}</td>
                                    <td class="px-4 py-3 text-center">{{ $lesson->quiz_count }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center gap-1 text-white">
                                            <button wire:click='openEditLessonModal({{ $lesson->id }})'
                                                class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110 min-w-[50px] justify-center relative">

                                                <!-- Text (hidden when loading) -->
                                                <small class="transition-opacity duration-150"
                                                    wire:loading.class="opacity-0"
                                                    wire:target='openEditLessonModal({{ $lesson->id }})'>
                                                    Edit
                                                </small>

                                                <!-- Spinner (overlay) -->
                                                <svg wire:loading
                                                    wire:target='openEditLessonModal({{ $lesson->id }})'
                                                    aria-hidden="true" class="w-4 h-4 text-white animate-spin absolute"
                                                    viewBox="0 0 100 101" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                        fill="currentFill" />
                                                </svg>
                                            </button>
                                            <button
                                                class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                                <small>View</small>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-6 text-center text-gray-500">
                                        No lessons found.
                                    </td>
                                </tr>
                            @endforelse
                    </table>
                </div>
            </div>
        </div>

        @if ($lessons->lastPage() > 1)
            <div class="rounded-full bg-white gap-1 p-2 w-fit self-center-safe flex items-center text-sm shadow-2xl">
                <button
                    class="cursor-pointer py-1 flex items-center px-3 {{ $lessons->onFirstPage() ? 'hidden' : '' }}"
                    @if (!$lessons->onFirstPage()) wire:click="gotoPage({{ $lessons->currentPage() - 1 }})" @endif>
                    <span class="material-symbols-outlined">
                        chevron_left
                    </span>
                </button>

                @foreach ($lessons->getUrlRange(1, $lessons->lastPage()) as $page => $url)
                    @if ($page == $lessons->currentPage())
                        <button
                            class=" bg-blue-button text-white py-1 px-4 rounded-full cursor-pointer">{{ $page }}</button>
                    @else
                        <button wire:click="gotoPage({{ $page }})"
                            class="py-1 px-4 hover:bg-blue-button rounded-full hover:text-white cursor-pointer">{{ $page }}</button>
                    @endif
                @endforeach

                <button
                    class="cursor-pointer py-1 flex items-center px-3 {{ $lessons->hasMorePages() ? '' : 'hidden' }}"
                    @if ($lessons->hasMorePages()) wire:click="gotoPage({{ $lessons->currentPage() + 1 }})" @endif>
                    <span class="material-symbols-outlined">
                        chevron_right
                    </span>
                </button>
            </div>
        @endif
    </div>

    <livewire:lesson-add-modal />
    <livewire:lesson-edit-modal />

    <section class="bg-black/30 absolute w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
        <!-- Lessson View Info-->
        <div class="w-150 h-full Addlesson bg-white py-8 rounded-4xl relative flex">
            <div class="Addlesson w-full h-full flex flex-col pr-8 pl-8 pb-18 gap-8 self-center-safe overflow-y-auto">
                <div class="flex items-center gap-4">
                    <img src="src/images/cube.png" alt="">
                    <h1 class=" text-2xl font-semibold text-heading-dark">Lesson name</h1>
                </div>
                

                <div class="flex w-full gap-4">
                    <div class="bg-gradient-to-tr from-blue-button to-[#00EEFF] shadow-blue-button shadow-2xl/45 p-6 text-white rounded-3xl flex flex-col justify-between gap-6">
                        <div class="flex justify-between w-45">
                            <div>
                                <p class="text-xs leading-snug font-normal">No. of Students</p>
                                <h1 class="text-lg font-semibold leading-6">Assigned</h1>
                            </div>
                            <span class="material-symbols-rounded icon">people</span>
                        </div>
                        <h1 class="text-4xl font-semibold">24</h1>
                    </div>

                    <div class="border-1 border-gray-300 p-6 rounded-3xl w-full flex flex-col gap-2">
                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-30">Status:</h3>
                            <div class="px-2 py-1 rounded-lg bg-[#D2FBD0] w-fit">
                                <select name="" id="" class="w-fit outline-none text-[#0D5F07] text-sm" >
                                    <option value="pending" class="text-sm text-black" selected>Active</option>
                                    <option value="pending" class="text-sm text-black">inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-30">Subject:</h3>
                            <p class="text-sm">28143129</p>
                        </div>
                        
                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-30">Curriculum:</h3>
                            <p class="text-sm">Hearing, Speech</p>
                        </div>

                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-30">No. of Videos:</h3>
                            <p class="text-sm">99</p>
                        </div>

                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-30">No. of Games:</h3>
                            <p class="text-sm">99</p>
                        </div>

                        <div class="flex items-center w-auto">
                            <h3 class="text-sm font-semibold w-30">No. of Quizzes:</h3>
                            <p class="text-sm">99</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h1 class="text-lg font-medium">Description</h1>
                    <p class="text-sm text-paragraph text-justify">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laboriosam in sed sunt. Consectetur ducimus inventore voluptatum, laudantium qui, nihil autem rem excepturi minima reiciendis non alias tempora voluptatem deleniti provident cupiditate magnam. Reiciendis veritatis eum libero perferendis beatae fugiat quod tempore est, aperiam ab placeat debitis accusantium dolore nihil cum.</p>
                </div>

                <div class="flex flex-col gap-3">
                    <h2 class="font-medium text-lg">Interactive Video Lessons</h2>
                    <div class="flex flex-col gap-2">

                        <!-- Default when no video is added -->
                        <div class="bg-card w-full h-30 hidden items-center justify-center rounded-lg">
                            <h1 class="text-paragraph">No Video added</h1>
                        </div>

                        <!-- Video Container -->
                        <div class="flex grid-cols-2 gap-2">
                            <div class="flex flex-col gap-2 relative"><!-- Video Holder -->
                                <div class="flex flex-col items-center justify-center">
                                    <img src="src/images/video_posters/bighero6.jpeg" alt="" class="aspect-video w-full h-fit rounded-lg object-cover">
                                    <button class="absolute rounded-full cursor-pointer hover:scale-120 shadow-xl/40 z-10">
                                        <span class="material-symbols-rounded p-2 rounded-full  playBtn text-white bg-white/20 backdrop-blur-[3px] shadow-white shadow-inner">play_arrow</span>
                                    </button>
                                </div>
                                
                                <div class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                    <div class="h-full w-full flex items-end justify-between p-3">
                                        <h1 class="text-white font-medium text-sm ml-1">Big Hero 6</h1>
                                    </div>
                                </div>
                            </div><!-- End of Video Holder -->

                            <div class="flex flex-col gap-2 relative"><!-- Video Holder -->
                                <div class="flex flex-col items-center justify-center">
                                    <img src="src/images/video_posters/httyd3.jpeg" alt="" class="aspect-video w-full h-fit rounded-lg object-cover">
                                    <button class="absolute rounded-full cursor-pointer hover:scale-120 shadow-xl/40 z-10">
                                        <span class="material-symbols-rounded p-2 rounded-full  playBtn text-white bg-white/20 backdrop-blur-[3px] shadow-white shadow-inner">play_arrow</span>
                                    </button>
                                </div>
                                
                                <div class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                    <div class="h-full w-full flex items-end justify-between p-3">
                                        <h1 class="text-white font-medium text-sm ml-1">How to train your Dragon 3</h1>>
                                        
                                    </div>
                                </div>
                            </div><!-- End of Video Holder -->
                        </div><!-- End of Video Container -->
                    </div>
                    
                    
                </div>


                <!-- Games -->
                <div class="flex flex-col gap-3">
                    <h2 class="font-medium text-lg">Games & Activities</h2>

                    <!-- Default when no game is added -->
                    <div class="bg-card w-full h-30 hidden items-center justify-center rounded-lg">
                        <h1 class="text-paragraph">No Game added</h1>
                    </div>
                    
                    <!-- Game container -->
                    <div class="w-full grid grid-cols-2 gap-2 items-center justify-center rounded-lg">
                        <!-- Game Holder -->
                        <div class="flex w-full justify-between bg-card p-2 rounded-lg">
                            <div class="flex gap-2">
                                <img src="src/images/game-icons/hayday.jpeg" alt="" class="h-12 rounded-md aspect-square object-cover">
                                <div>
                                    <h1 class="font-medium">HayDay</h1>
                                    <p class="text-sm text-paragraph">Science</p>
                                </div>
                            </div>
                        </div><!-- End of Game Holder -->

                        <!-- Game Holder -->
                        <div class="flex w-full justify-between bg-card p-2 rounded-lg">
                            <div class="flex gap-2">
                                <img src="src/images/game-icons/worldMole.jpeg" alt="" class="h-12 rounded-md aspect-square object-cover">
                                <div>
                                    <h1 class="font-medium">World Mole</h1>
                                    <p class="text-sm text-paragraph">Math</p>
                                </div>
                            </div>
                        </div><!-- End of Game Holder -->
                        
                        
                    </div><!--End of Game container -->
                </div>

                <!-- Games -->
                <div class="flex flex-col gap-3">
                    <h2 class="font-medium text-lg">Quizzes</h2>

                    <!-- Default when no Quiz is added -->
                    <div class="bg-card w-full h-30 hidden items-center justify-center rounded-lg">
                        <h1 class="text-paragraph">No Quiz added</h1>
                    </div>
                    
                    <!-- Quiz container -->
                    <div class="w-full grid grid-cols-2 gap-2 items-center justify-center rounded-lg">
                        <!-- Quiz Holder -->
                        <div class="flex w-full justify-between bg-card p-2 rounded-lg">
                            <div class="flex gap-2">
                                <img src="src/images/game-icons/hayday.jpeg" alt="" class="h-12 rounded-md aspect-square object-cover">
                                <div>
                                    <h1 class="font-medium">HayDay</h1>
                                    <p class="text-sm text-paragraph">Science</p>
                                </div>
                            </div>
                        </div><!-- End of Quiz Holder -->
                    </div><!--End of Quiz container -->
                </div>

                <div class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-5 pb-5 pt-10  rounded-b-4xl bg-gradient-to-t from-white via-white to-white/50">
                    <button class=" bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">Cancel</button>
                    <button type="submit" class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">Save</button>
                </div>
            </div>
        </div><!-- End of Lesson View Info-->
    </section>
    
</main>
