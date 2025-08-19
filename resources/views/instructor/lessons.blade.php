<main class="col-span-7 px-8 py-4 flex flex-col h-dvh gap-16 overflow-y-none">
    <!-- Greetings -->
    <div class="flex gap-2 w-auto justify-between">
        <div class="flex gap-4">
            <span class="w-1 h-full bg-blue-button rounded-full"></span>
            <div>
                <h1 class="text-2xl font-medium">
                    Welcome back, Sir
                    <span class="font-bold text-blue-button">Dave</span>
                </h1>
                <p class="text-sm text-paragraph">Here is your summary today</p>
            </div>
        </div>

        <!-- Buttons -->
        <button
            class="flex items-center bg-white py-2 px-5 rounded-full gap-2 shadow-2xl text-paragraph cursor-pointer hover:text-white hover:bg-blue-button hover:shadow-xl/35 hover:shadow-blue-button hover:scale-105">
            <span class="material-symbols-rounded">add</span>
            <p class="text-sm">Add New Lesson</p>
        </button>
    </div>

    <!-- curriculumn Table -->
    <div class="flex flex-col gap-4 min-h-[20%]">
        <div class="side flex items-center justify-between gap-2">
            <h1 class="text-4xl font-medium">Lesson List</h1>
            <div
                class="flex items-center bg-white py-3 px-5 rounded-full shadow-2xl text-paragraph hover:bg-blue-button hover:text-white cursor-pointer">
                <select name="" id="" class="w-25 outline-none">
                    <option value="pending" class="text-sm text-heading-dark" selected disabled>
                        Filter by
                    </option>
                    <option value="pending" class="text-sm text-heading-dark">
                        All
                    </option>
                    <option value="pending" class="text-sm text-lime">Active</option>
                    <option value="pending" class="text-sm text-paragraph">
                        Inactive
                    </option>
                </select>
                <!-- <span class="material-symbols-rounded">more_horiz</span>
                    <span class="material-symbols-rounded">search</span> -->
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
                                <th class="px-4 pb-3 text-center font-semibold">Status</th>
                                <th class="px-4 pb-3 text-center font-semibold">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="px-4 py-3 text-center">01</td>
                                <td class="px-4 py-3 text-center">FSL Lesson</td>
                                <td class="px-4 py-3 text-center">FSL Curriculum</td>
                                <td class="px-4 py-3 text-center">FSL</td>
                                <td class="px-4 py-3 text-center">6</td>
                                <td class="px-4 py-3 text-center">2</td>
                                <td class="px-4 py-3 text-center">3</td>
                                <td class="px-4 py-3 text-center">1</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center">
                                        <div class="gap-2 bg-[#D2FBD0] px-2 py-1 rounded-full flex items-center w-fit">
                                            <small class="text-[#0D5F07]">Active</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center items-center gap-1 text-white">
                                        <button
                                            class="bg-danger px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>Edit</small>
                                        </button>
                                        <button
                                            class="bg-blue-button px-2 py-1 flex gap-2 items-center rounded-lg cursor-pointer hover:scale-110">
                                            <small>View</small>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Lessons -->
    <section
        class="bg-black/30 absolute w-dvw h-dvh p-10 top-0 left-0 z-50 backdrop-blur-xs hidden justify-center gap-6">
        <!-- Add lesson container -->
        <div class="w-150 h-full Addlesson bg-white p-8 rounded-4xl">
            <!-- first form -->
            <div class="Addlesson w-full h-[100%] flex flex-col gap-8 self-center-safe overflow-y-auto">
                <div class="flex items-center gap-2">
                    <img src="src/images/cube.png" alt="" />
                    <h1 class="text-2xl font-semibold text-heading-dark">
                        Add Lesson
                    </h1>
                </div>

                <div class="flex flex-col gap-3">
                    <h2 class="font-medium text-lg">Lesson Information</h2>
                    <div class="flex flex-col gap-2">
                        <input type="text" placeholder="Lesson Name"
                            class="px-3 py-1 rounded-lg bg-card placeholder-paragraph outline-none w-full" />

                        <div class="flex items-center gap-2 w-full">
                            <div class="px-2 py-1 rounded-lg bg-card w-full">
                                <select name="" id="" class="w-full outline-none text-paragraph">
                                    <option value="pending" class="text-sm text-black" selected disabled>
                                        Subject
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        1
                                    </option>
                                    <option value="pending" class="text-sm text-paragraph">
                                        2
                                    </option>
                                </select>
                            </div>
                            <!-- <div class="px-2 py-1 rounded-lg bg-card w-full">
                                    <select name="" id="" class="w-full outline-none text-paragraph " >
                                        <option value="pending" class="text-sm text-black" selected disabled>Rewards</option>
                                        <option value="pending" class="text-sm text-paragraph">1</option>
                                        <option value="pending" class="text-sm text-paragraph">2</option>
                                    </select>
                                </div> -->
                        </div>

                        <div class="px-2 py-1 rounded-lg bg-card">
                            <select name="" id="" class="w-full outline-none text-paragraph">
                                <option value="pending" class="text-sm text-black" selected disabled>
                                    Grade & Section
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    1
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    2
                                </option>
                            </select>
                        </div>

                        <div class="px-2 py-1 rounded-lg bg-card">
                            <select name="" id="" class="w-full outline-none text-paragraph">
                                <option value="pending" class="text-sm text-black" selected disabled>
                                    Select Student (Optional)
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    1
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    2
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    3
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    4
                                </option>
                            </select>
                        </div>

                        <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
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
                                    <img src="src/images/video_posters/bighero6.jpeg" alt=""
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
                                    <img src="src/images/video_posters/httyd3.jpeg" alt=""
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
                            <select name="" id="" class="w-full outline-none text-paragraph">
                                <option value="pending" class="text-sm text-black" selected disabled>
                                    Choose Games
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    1
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    2
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    3
                                </option>
                                <option value="pending" class="text-sm text-paragraph">
                                    4
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Default when no game is added -->
                    <div class="bg-card w-full h-30 hidden items-center justify-center rounded-lg">
                        <h1 class="text-paragraph">No Game added</h1>
                    </div>

                    <!-- Game container -->
                    <div class="w-full grid grid-cols-2 gap-2 items-center justify-center rounded-lg">
                        <!-- Game Holder -->
                        <div class="flex w-full justify-between bg-card p-2 rounded-lg">
                            <div class="flex gap-2">
                                <img src="src/images/game-icons/hayday.jpeg" alt=""
                                    class="h-12 rounded-md aspect-square object-cover" />
                                <div>
                                    <h1 class="font-medium">HayDay</h1>
                                    <p class="text-sm text-paragraph">Science</p>
                                </div>
                            </div>

                            <button
                                class="flex items-center w-fit h-fit justify-center cursor-pointer hover:scale-120">
                                <span class="material-symbols-rounded remove-icon">close</span>
                            </button>
                        </div>
                        <!-- End of Game Holder -->

                        <!-- Game Holder -->
                        <div class="flex w-full justify-between bg-card p-2 rounded-lg">
                            <div class="flex gap-2">
                                <img src="../src/images/game-icons/worldMole.jpeg" alt=""
                                    class="h-12 rounded-md aspect-square object-cover" />
                                <div>
                                    <h1 class="font-medium">World Mole</h1>
                                    <p class="text-sm text-paragraph">Math</p>
                                </div>
                            </div>

                            <button
                                class="flex items-center w-fit h-fit justify-center cursor-pointer hover:scale-120">
                                <span class="material-symbols-rounded remove-icon">close</span>
                            </button>
                        </div>
                        <!-- End of Game Holder -->
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
                    <img src="src/images/quizzes.png" alt="" />
                    <h1 class="text-2xl font-semibold text-heading-dark">
                        Create Quiz
                    </h1>
                </div>

                <!-- Question Container-->
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col border-1 border-gray-300 py-4 px-5 rounded-2xl">
                        <input type="text" name="" id="" placeholder="Quiz Name"
                            class="text-2xl outline-none placeholder-heading-dark" />
                        <textarea name="" id="" maxlength="200" placeholder="Description (Optional)"
                            class="placeholder-paragraph text-paragraph resize-none h-15 outline-none"></textarea>
                    </div>

                    <!-- Question Holder -->
                    <div class="flex flex-col border-1 border-gray-300 p-5 rounded-2xl gap-4">
                        <input type="text" placeholder="Question"
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
                                <button class="w-fit h-fit flex items-center justify-center gap-2 cursor-pointer">
                                    <span class="material-symbols-rounded text-blue-button">assignment_turned_in</span>
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
                        <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b-2 border-gray-400">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-rounded text-blue-button">assignment_turned_in</span>
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

                            <div class="flex items-center justify-end mt-4 pt-5 w-full border-t-1 border-gray-300">
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
                    <button class="bg-gray-100 py-1.5 px-3 w-full rounded-xl text-heading-dark font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-button py-1.5 px-3 w-full rounded-xl text-white font-medium">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </section>
</main>
