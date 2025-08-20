<div>
    @if ($isOpen)
        <section class="bg-black/30 fixed w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs flex justify-center gap-6">
            <!-- Add lesson container -->
            <form wire:submit='addLesson' class="flex justify-center gap-6">
                <div class="w-150 h-full Addlesson bg-white p-8 rounded-4xl">
                    <!-- first form -->
                    <div class="Addlesson w-full h-[100%] flex flex-col gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/cube.png') }}" alt="" />
                            <h1 class="text-2xl font-semibold text-heading-dark">
                                Add Lesson
                            </h1>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-medium text-lg">Lesson Information</h2>
                            <div class="flex flex-col gap-2">
                                <input type="text" placeholder="Lesson Name" wire:model.live="lesson_name"
                                    class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />

                                <div class="flex items-center gap-2 w-full">
                                    <div class="px-2 py-1 rounded-lg bg-card w-full">
                                        <select name="" id=""
                                            wire:change="$set('subject', $event.target.value)"
                                            class="w-full outline-none text-paragraph">
                                            <option value="pending" class="text-sm text-black" selected disabled>
                                                Subject
                                            </option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->name }}" class="text-sm text-paragraph">
                                                    {{ ucwords($subject->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- <div class="px-2 py-1 rounded-lg bg-card w-full">                                                                       </div> -->
                                </div>

                                <div class="px-2 py-1 rounded-lg bg-card">
                                    <select wire:change="$set('grade_level', $event.target.value)" name=""
                                        id="" class="w-full outline-none text-paragraph">
                                        <option value="pending" class="text-sm text-black" selected disabled>
                                            Grade & Section
                                        </option>
                                        @foreach ($grade_levels as $grade_level)
                                            <option value="{{ $grade_level }}" class="text-sm text-paragraph">
                                                {{ ucwords($grade_level) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="px-2 py-1 rounded-lg bg-card">
                                    <select name="" id=""
                                        wire:change="$set('selected_student', $event.target.value)"
                                        class="w-full outline-none text-paragraph">
                                        <option class="text-sm text-black" selected disabled>
                                            Select Student (Optional)
                                        </option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}" class="text-sm text-paragraph">
                                                {{ ucwords($student->last_name) }}, {{ ucwords($student->first_name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                    wire:model.live="description"
                                    class="px-3 py-2 rounded-lg bg-card placeholder-paragraph resize-none h-24 outline-none"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-medium text-lg">Interactive Video Lessons</h2>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center justify-center gap-2 px-6 py-3 border-1 border-dashed rounded-lg w-full hover:text-blue-button"
                                        id="dropzone">
                                        <!-- Image dropzone -->
                                        <h1 class="">Upload Video</h1>
                                        <span class="material-symbols-rounded">add_photo_alternate</span>
                                        <input type="file" name="" id="" class="hidden" />
                                    </div>
                                    <div class="flex items-center justify-center gap-2 px-6 py-3 border-1 border-dashed rounded-lg w-full hover:text-blue-button"
                                        id="dropzone">
                                        <!-- Image dropzone -->
                                        <h1 class="">Attach Link</h1>
                                        <span class="material-symbols-rounded">link</span>
                                        <input type="file" name="" id="" class="hidden" />
                                    </div>
                                </div>

                                <!-- Default when no video is added -->
                                <div class="bg-card w-full h-30 hidden items-center justify-center rounded-lg">
                                    <h1 class="text-paragraph">No Video added</h1>
                                </div>

                                <!-- Video Container -->
                                <div class="flex grid-cols-2 gap-2">
                                    <div class="flex flex-col gap-2 relative">
                                        <!-- Video Holder -->
                                        <div class="flex flex-col items-center justify-center">
                                            <img src="{{ asset('images/video_posters/bighero6.jpeg') }}" alt=""
                                                class="aspect-video w-full h-fit rounded-lg object-cover" />
                                            <button
                                                class="absolute rounded-full cursor-pointer hover:scale-120 shadow-xl/40 z-10">
                                                <span
                                                    class="material-symbols-rounded p-2 rounded-full playBtn text-white bg-white/20 backdrop-blur-[3px] shadow-white shadow-inner">play_arrow</span>
                                            </button>
                                        </div>

                                        <div
                                            class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                            <div class="h-full w-full flex items-end justify-between p-3">
                                                <h1 class="text-white font-medium text-sm ml-1">
                                                    Big Hero 6
                                                </h1>
                                                <button
                                                    class="cursor-pointer p-0 flex items-center justify-center text-white hover:text-danger hover:scale-120">
                                                    <span class="material-symbols-rounded">delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Video Holder -->

                                    <div class="flex flex-col gap-2 relative">
                                        <!-- Video Holder -->
                                        <div class="flex flex-col items-center justify-center">
                                            <img src="{{ asset('images/video_posters/httyd3.jpeg') }}" alt=""
                                                class="aspect-video w-full h-fit rounded-lg object-cover" />
                                            <button
                                                class="absolute rounded-full cursor-pointer hover:scale-120 shadow-xl/40 z-10">
                                                <span
                                                    class="material-symbols-rounded p-2 rounded-full playBtn text-white bg-white/20 backdrop-blur-[3px] shadow-white shadow-inner">play_arrow</span>
                                            </button>
                                        </div>

                                        <div
                                            class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/0 to-black/0 w-full h-full rounded-lg">
                                            <div class="h-full w-full flex items-end justify-between p-3">
                                                <h1 class="text-white font-medium text-sm ml-1">
                                                    How to train your Dragon 3
                                                </h1>
                                                <button
                                                    class="cursor-pointer p-0 flex items-center justify-center text-white hover:text-danger hover:scale-120">
                                                    <span class="material-symbols-rounded">delete</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Video Holder -->
                                </div>
                                <!-- End of Video Container -->
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h2 class="font-medium text-lg">Games & Activities</h2>

                            <div class="flex flex-col gap-2">
                                <div class="px-2 py-1 rounded-lg bg-card">
                                    <select name="" id=""
                                        wire:change="$set('activity', $event.target.value)"
                                        class="w-full outline-none text-paragraph">
                                        <option value="pending" class="text-sm text-black" selected disabled>
                                            Choose Games
                                        </option>
                                        @foreach ($activities as $activity)
                                            <option value="{{ $activity->id }}" class="text-sm text-paragraph">
                                                {{ ucwords($activity->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="w-full grid grid-cols-2 gap-2 items-center justify-center rounded-lg">
                                @forelse ($selected_activities as $i => $act)
                                    <div wire:key="activity-{{ $i }}"
                                        class="flex w-full justify-between bg-card p-2 rounded-lg">
                                        <div class="flex gap-2">
                                            <img src="{{ asset('images/game-icons/hayday.jpeg') }}" alt=""
                                                class="h-12 rounded-md aspect-square object-cover" />
                                            <div>
                                                <h1 class="font-medium">{{ $act->name }}</h1>
                                            </div>
                                        </div>

                                        <button type="button" wire:click="removeActivity({{ $i }})"
                                            class="flex items-center w-fit h-fit justify-center cursor-pointer hover:scale-120">
                                            <span class="material-symbols-rounded remove-icon">close</span>
                                        </button>
                                    </div>
                                @empty
                                    <div class="bg-card col-span-2 h-30 flex items-center justify-center rounded-lg">
                                        <h1 class="text-paragraph">No Game added</h1>
                                    </div>
                                @endforelse
                            </div>
                            <!--End of Game container -->
                        </div>
                    </div>
                    <!-- End of first form -->
                </div>
                <!-- End Add lesson container -->

                <!-- Create Quiz Container -->
                <div class="w-150 h-full Addlesson bg-white p-8 rounded-4xl relative">
                    <div class="Addlesson w-full h-[100%] flex flex-col pb-18 gap-8 self-center-safe overflow-y-auto">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/quizzes.png') }}" alt="" />
                            <h1 class="text-2xl font-semibold text-heading-dark">
                                Create Quiz
                            </h1>
                        </div>

                        <!-- Question Container-->
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col border-1 border-gray-300 py-4 px-5 rounded-2xl">
                                <input type="text" name="" id="" placeholder="Quiz Name"
                                    wire:model.live="quiz_name"
                                    class="text-2xl outline-none placeholder-heading-dark" />
                                <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                                    wire:model.live="quiz_description" class="placeholder-paragraph text-paragraph resize-none h-15 outline-none"></textarea>
                            </div>

                            <!-- Question Holder -->
                            <div class="flex flex-col border-1 border-gray-300 p-5 rounded-2xl gap-4">
                                <input type="text" placeholder="Question" wire:model.live="quiz_questions"
                                    class="border-b-2 border-gray-400 px-3 py-1 bg-card placeholder-paragraph outline-none w-full" />

                                <!-- Option Container -->
                                <div class="flex flex-col">
                                    <!-- Option Holder -->
                                    <div class="flex items-center justify-between w-full p-2 rounded-lg">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-5 h-5 border-1 border-gray-400 rounded-full p-0.5 flex items-center justify-center">
                                                <span class="w-full h-full rounded-full bg-none"></span>
                                            </div>
                                            <input type="text" placeholder="Option 1"
                                                class="placeholder-paragraph text-sm outline-none" />
                                        </div>
                                        <span class="material-symbols-rounded text-paragraph">close</span>
                                    </div>
                                    <!--End of Option Holder -->

                                    <!-- Add option -->
                                    <div class="flex items-center justify-between w-full p-2 rounded-lg">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-5 h-5 border-1 border-gray-400 rounded-full p-0.5 flex items-center justify-center">
                                                <span class="w-full h-full rounded-full bg-none"></span>
                                            </div>
                                            <button type="text" class="text-blue-button outline-none text-sm">
                                                Add Option
                                            </button>
                                        </div>
                                    </div>
                                    <!--End of Add option -->

                                    <div class="flex items-center justify-between pt-6">
                                        <button
                                            class="w-fit h-fit flex items-center justify-center gap-2 cursor-pointer">
                                            <span
                                                class="material-symbols-rounded text-blue-button">assignment_turned_in</span>
                                            <h1 class="text-blue-button">Answere Key</h1>
                                            <p class="pl-3 text-paragraph text-sm">
                                                (<span>0</span> points)
                                            </p>
                                        </button>
                                        <button
                                            class="w-fit h-fit cursor-pointer p-0 flex items-center justify-center text-paragraph hover:text-danger hover:scale-120">
                                            <span class="material-symbols-rounded">delete</span>
                                        </button>
                                    </div>
                                </div>
                                <!--End 0f Option Container -->
                            </div>
                            <!--End Question Holder -->

                            <!-- Answer Holder -->
                            <div class="flex flex-col border-1 border-gray-300 p-5 rounded-2xl gap-4">
                                <div
                                    class="flex items-center justify-between gap-2 pb-3 mb-3 border-b-2 border-gray-400">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="material-symbols-rounded text-blue-button">assignment_turned_in</span>
                                        <h1>Choose Correct Answer:</h1>
                                    </div>
                                    <div class="w-fit flex items-center gap-2">
                                        <input type="number" class="w-9 outline-none pl-1 border-b-1 border-gray-400"
                                            placeholder="0" name="" id="" />
                                        <p>points</p>
                                    </div>
                                </div>

                                <!-- Answer Container -->
                                <div class="flex flex-col">
                                    <div class="w-full flex items-center justify-between mb-6">
                                        <p>Question Here</p>
                                    </div>
                                    <!-- Selected Anwer-->
                                    <div class="flex items-center justify-between w-full bg-[#CFF2D9] p-2 rounded-lg">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-5 h-5 border-1 border-[#11BC3F] rounded-full p-0.5 flex items-center justify-center">
                                                <span class="w-full h-full rounded-full bg-[#11BC3F]"></span>
                                            </div>
                                            <p class="text-paragraph text-sm">Option 1</p>
                                        </div>
                                        <span class="material-symbols-rounded text-[#11BC3F]">check</span>
                                    </div>
                                    <!--End of Option Holder -->

                                    <!-- Default unselected answer -->
                                    <div class="flex items-center justify-between w-full p-2 rounded-lg">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-5 h-5 border-1 border-gray-400 rounded-full p-0.5 flex items-center justify-center">
                                                <span class="w-full h-full rounded-full bg-none"></span>
                                            </div>
                                            <p class="text-paragraph text-sm">Option 1</p>
                                        </div>

                                        <!-- Uncomment if this selected -->
                                        <!-- <span class="material-symbols-rounded text-[#11BC3F]">check</span> -->
                                    </div>
                                    <!--End of Option Holder -->

                                    <div
                                        class="flex items-center justify-end mt-4 pt-5 w-full border-t-1 border-gray-300">
                                        <button
                                            class="flex w-fit items-center justify-center border-1 border-gray-300 py-2 px-3 rounded-2xl gap-2 self-center text-paragraph text-sm hover:border-blue-button hover:text-white hover:bg-blue-button hover:scale-110 cursor-pointer">
                                            <p>Done</p>
                                        </button>
                                    </div>
                                </div>
                                <!--End 0f Option Container -->
                            </div>
                            <!--End Question Holder -->
                            <button
                                class="flex w-fit items-center justify-center border-1 border-gray-300 py-2 px-3 rounded-2xl gap-2 self-center text-paragraph text-sm hover:border-blue-button hover:text-white hover:bg-blue-button hover:scale-110 cursor-pointer">
                                <span class="material-symbols-rounded">add_circle</span>
                                <p>Add Question</p>
                            </button>
                        </div>
                        <!-- End of Option Container -->

                        <div
                            class="flex items-center gap-2 absolute w-full left-0 bottom-0 px-5 pb-5 pt-10 rounded-b-4xl bg-gradient-to-t from-white via-white to-white/50">
                            <button wire:click='closeModal'
                                class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                                Cancel
                            </button>
                            <button type="submit"
                                class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div wire:loading wire:target="addCurriculum"
                class="bg-black/10 fixed top-0 left-0 w-dvw h-dvh z-50 flex justify-center items-center backdrop-blur-sm">
                <svg aria-hidden="true"
                    class="w-12 h-12 text-gray-200 animate-spin fill-blue-600 absolute top-1/2 left-[49%]"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </section>
    @endif
</div>
