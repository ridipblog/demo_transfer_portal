<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../../assets/css/custom.css" rel="stylesheet">
</head>

<body class="px-4 min-h-screen flex flex-col bg-white">
    <!-- navbar -->
    <nav class="bg-white sticky top-0 z-50">
        <div class="max-w-full mx-auto flex justify-between items-center py-3">
            <div class="font-black flex gap-2 items-center">
                <img src="../../assets/img/logo.svg" alt="" class="h-8 md:h-12">
                <p class="leading-4 text-2xl text-sky-600 mt-1">SWAGATA SATIRTHA <br><small
                        class="text-xs font-medium text-black">GOVT. OF ASSAM</small></p>
            </div>
            <!-- <div class="flex items-center gap-4 text-gray-900">
                <a href="./dashboard.html" class="border-b-2 border-sky-600 text-sky-600 pb-2">Dashboard</a>
                <a href="./search-profiles.html" class="border-transparent border-b-2 transition-all duration-150 hover:text-sky-600 hover:border-sky-600 pb-2">Requests</a>
                <a href="#" class="border-transparent border-b-2 transition-all duration-150 hover:text-sky-600 hover:border-sky-600 pb-2">My Requests</a>
            </div> -->

            <div class="flex items-center gap-4 text-gray-900">
                <div class="flex items-center justify-end gap-2">
                    <div class="text-sm text-right">
                        <p class="font-bold">Ronny Das</p>
                        <p class="text-gray-600">Department | Approver</p>
                    </div>
                    <div class=""><i class="bi bi-caret-down-fill"></i></div>
                </div>
            </div>
        </div>
    </nav>
    <!-- content -->
    <div class="py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mt-8 space-y-12">
                <div class="mb-6 space-y-2">
                    <p class="text-3xl font-semibold">All Users</p>
                </div>
                <div class="">
                    <button type="button"
                        class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit"
                        id="createRequest"><i class="bi bi-plus"> </i>New user</a></button>
                    <!-- modal -->
                    <div class="hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black/30 p-4 z-[99]"
                        id="requestModal">
                        <div class="max-w-xl w-full bg-white rounded-2xl p-6 py-10">
                            <div class="space-y-2 mb-6">
                                <p class="text-3xl font-semibold">Create user</p>
                            </div>
                            <form action="" method="">
                                <div class="grid grid-cols-2 gap-8">
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">Name</label>
                                        <input type="text" name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            required>
                                    </div>
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold reqd text-gray-900">Department</label>
                                        <select name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            required>
                                            <option value="" selected>All</option>
                                            <option value="1">Irrigation</option>
                                            <option value="2">Health</option>
                                            <option value="3">Finance</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label
                                            class="block mb-1 text-xs font-semibold reqd text-gray-900">Office</label>
                                        <select name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            required>
                                            <option value="" selected>All</option>
                                            <option value="1">ABC</option>
                                            <option value="2">DEF</option>
                                            <option value="3">XYZ</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-1 text-xs md:text-sm font-semibold reqd text-gray-800">Phone</label>
                                        <input type="tel" name=""
                                            class="disabled:bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-md focus:ring-sky-600 bg-gray-50 focus:border-sky-600 block p-2.5 w-full"
                                            required>
                                    </div>
                                    <div class="col-span-2 flex gap-1 justify-end">
                                        <button type="button"
                                            class="bg-white hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"
                                            id="closeModalButton">Close</button>
                                        <button type="submit"
                                            class="bg-sky-500 hover:bg-sky-600 border border-transparent text-white rounded-md block px-2 py-1.5 w-fit">submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="border rounded-2xl overflow-hidden bg-white mt-4">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Name</th>
                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Office & Department
                                </th>
                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900">Phone</th>
                                <th class="text-left p-4 px-6 font-medium text-sm text-gray-900"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    <p class="font-semibold">Jiten Sarmah</p>
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    Office of the Chief Engineer, Irrigation Department, Kamrup Metro
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91 882 676 2317</td>
                                <td class="py-4 px-6 text-xs">
                                    <div class="flex gap-1 justify-center">
                                        <button type="button"
                                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                                class="bi bi-pencil"></i></button>
                                        <button type="button"
                                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    <p class="font-semibold">Anita Roy</p>
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    Office of the Superintending Engineer, Public Works Department, Guwahati
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91 882 676 2317</td>
                                <td class="py-4 px-6 text-xs">
                                    <div class="flex gap-1 justify-center">
                                        <button type="button"
                                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                                class="bi bi-pencil"></i></button>
                                        <button type="button"
                                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    <p class="font-semibold">Rahul Verma</p>
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900">
                                    Office of the Deputy Director, Health Department, Dibrugarh
                                </td>
                                <td class="py-4 px-6 text-xs text-gray-900 whitespace-nowrap">+91 882 676 2317</td>
                                <td class="py-4 px-6 text-xs font-medium text-gray-900 text-center">
                                    <div class="flex gap-1 justify-center">
                                        <button type="button"
                                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                                class="bi bi-pencil"></i></button>
                                        <button type="button"
                                            class="hover:bg-gray-200 border border-transparent text-gray-900 hover:text-black rounded-md block px-2 py-1.5 duration-300"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer class="mt-auto">
        <div class="max-w-7xl mx-auto flex justify-center items-center py-4 text-gray-900 text-xs">
            2024 &copy; SWAGATA SATIRTHA | All Rights Reserved
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#createRequest').on('click', function() {
                if ($('#requestModal').hasClass('hidden')) {
                    $('#requestModal').removeClass('hidden');
                }
            });
            $('#closeModalButton').on('click', function() {
                $('#requestModal').addClass('hidden');
            });
        });
    </script>
</body>

</html>
