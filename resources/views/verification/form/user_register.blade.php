<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.min.css" rel="stylesheet" />

    <title>User Registration</title>
</head>
<style>
    .select2 {
        width: 100% !important;
    }
</style>

<body class="max-w-screen overflow-x-hidden">
    <div class="max-w-7xl w-full mx-auto my-8">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <ul class="list-disc ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-4xl font-bold mb-6">User Registration</p>

        <form action="" id="authority_registration" method="post">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="inputName" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name"
                        class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        id="inputName" placeholder="User Name">
                    <p class="registration-error text-red-500"></p>
                </div>
                <div class="form-group">
                    <label for="inputPhone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone_number" id="inputPhone"
                        class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Phone Number" maxlength="10" pattern="\d{10}" inputmode="numeric"
                        title="Please enter a 10-digit phone number.">
                    <p class="registration-error text-red-500"></p>
                </div>

            </div>

            <div class="form-group mt-6">
                <label for="inputDesignation" class="block text-sm font-medium text-gray-700">Designation</label>
                <input type="text" name="designation"
                    class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    id="inputDesignation" placeholder="Designation">
                <p class="registration-error text-red-500"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="form-group">
                    <label for="inputDepartment" class="block text-sm font-medium text-gray-700">Department</label>
                    <select id="inputDepartment" name="department"
                        class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2">
                        <option value="" selected>Choose...</option>
                        @foreach ($departments as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <p class="registration-error text-red-500"></p>
                </div>
                {{-- {{dd($all_roles)}} --}}
                <div id="roleContainer" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="inputRole" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="common_role" id="common_role"
                                class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" selected>Choose...</option>
                                @foreach ($all_roles as $role)
                                    <option value="{{ $role->id ?? '' }}">{{ $role->display_name ?? 'N/A' }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="flex items-end">
                            <button type="button"
                                class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 add-new-role">+
                                Role</button>
                        </div> --}}
                    </div>
                </div>

            </div>

            <!-- Office and District Selection Section -->
            <div id="officeDistrictContainer" class="space-y-6 mt-6">
                <div class="form-group flex items-end">
                    <button type="button"
                        class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 add-new-row add-assign-form">+
                        Office</button>
                </div>
                {{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6 office-district-row">

                    <div class="form-group">
                        <label for="inputDistrict" class="block text-sm font-medium text-gray-700">District</label>
                        <select name="district[]" id="districtSelect"
                            class="form-control mt-1 w-full block w-36 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2 form_district">
                            <option value="All" selected>All</option>
                            @foreach ($districts as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="inputOffice" class="block text-sm font-medium text-gray-700">Office</label>
                        <select name="office[]"
                            class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 form_offices select2">
                            <option value="" selected>All</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="inputRole" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role[]"
                            class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 assign_role">
                            <option value="" selected dis>Select Role</option>
                            @foreach ($all_roles as $role)
                                <option value="{{ $role->id ?? '' }}">{{ $role->role ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group flex items-end">
                        <button type="button"
                            class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 add-new-row add-assign-form">+
                            Office</button>
                    </div>
                </div> --}}
            </div>



            <button type="submit"
                class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 mt-6 submit-registration">Register</button>
        </form>

        <!-- User Registration Table -->
        <div class="mt-10">
            <h3 class="text-2xl font-bold">Registered Users</h3>
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg datatable text-xs">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="border px-4 py-2">#</th>
                        <th class="border px-4 py-2 text-left">Name</th>
                        <th class="border px-4 py-2 text-left">Phone Number</th>
                        <th class="border px-4 py-2 text-left">Designation</th>
                        <th class="border px-4 py-2 text-left">Department</th>
                        <th class="border px-4 py-2 text-left">Role</th>
                        <th class="border px-4 py-2 text-left">Assign Data</th>

                    </tr>
                </thead>
                <tbody id="registrationTableBody">
                    {{-- {{dd($registered_users[1]->all_logins[0]->roles)}} --}}
                    @php $count = 1 @endphp
                    @foreach ($registered_users as $user)
                        <tr class="bg-white border-b">
                            <td class="border px-4 py-2">{{ $count++ }}</td>
                            <td class="border px-4 py-2">{{ $user->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $user->phone ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $user->designation ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $user->departments->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">
                                @php
                                    $roles_names = [];
                                    foreach ($user->all_logins as $roles) {
                                        array_push($roles_names, $roles->roles->display_name ?? 'N/A');
                                    }
                                    $role_names = !empty($roles_names) ? implode(', ', $roles_names) : 'N/A';
                                    echo $role_names;
                                @endphp

                            </td>
                            <td><button class="view-assign-data text-blue-500 underline"
                                    value="{{ Crypt::encryptString($user->id) }}">View</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="assign-data-div">

        </div>
        <div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.umd.min.js"></script>
    <script type="module" src="{{ asset('js/root_access/add_authorities.js') }}"></script>
    {{-- <script>
        // Initialize choices.js
        document.addEventListener('DOMContentLoaded', function() {
            const districtSelect = document.getElementById('districtSelect');
            new Choices(districtSelect, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Select Districts',
                searchEnabled: true
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {


            $('.datatable').DataTable();
            $('.select2').select2({
                placeholder: "- Select -",
                // allowClear: true
            });

            // Function to add a new row for office and district
            // $('#officeDistrictContainer').on('click', '.add-new-row', function() {
            //     let newRow = `
        // <div class="flex flex-wrap space-y-4 office-district-row">
        //     <div class="w-full md:w-1/3 px-2 mb-4">
        //         <label for="inputOffice" class="block text-sm font-medium text-gray-700">Office</label>
        //         <select name="office[]" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" >
        //             <option value="All" selected>All</option>
        //             @foreach ($offices as $key => $value)
        //                 <option value="{{ $key }}">{{ $value }}</option>
        //             @endforeach
        //         </select>
        //     </div>
        //     <div class="w-full md:w-1/3 px-2 mb-4">
        //         <label for="inputDistrict" class="block text-sm font-medium text-gray-700">District</label>
        //         <select name="district[]" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 form_district" >
        //             <option value="All" selected>All</option>
        //         </select>
        //     </div>
        //     <div class="w-full md:w-1/3 px-2 mb-4 flex justify-end">
        //         <button type="button" class="btn btn-danger remove-row bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Remove</button>
        //     </div>
        // </div>
        // `;

            //     // Append the new row to the container
            //     $('#officeDistrictContainer').append(newRow);

            //     // Update options for the new row
            //     updateOptions();
            // });

            // // Function to remove a row
            // $('#officeDistrictContainer').on('click', '.remove-row', function() {
            //     $(this).closest('.office-district-row').remove();
            //     updateOptions();
            // });

            // // Event listener for changes in office selects
            // $('#officeDistrictContainer').on('change', 'select[name="office[]"]', function() {
            //     let officeId = $(this).val();
            //     let currentRow = $(this).closest('.office-district-row');

            //     // If an office is selected, fetch districts based on selected office via AJAX
            //     if (officeId !== "All") {
            //         $.ajax({
            //             url: "{{ url('fetch-district') }}",
            //             type: "POST",
            //             data: {
            //                 office_id: officeId,
            //                 _token: '{{ csrf_token() }}'
            //             },
            //             success: function(response) {
            //                 if (response.status === 200) {
            //                     let districtSelect = currentRow.find(
            //                         'select[name="district[]"]');
            //                     // Clear existing options and keep selected district intact
            //                     let selectedDistrict = districtSelect.val();
            //                     districtSelect.empty().append(
            //                         '<option value="All" selected>All</option>');
            //                     response.data.forEach(function(district) {
            //                         districtSelect.append('<option value="' + district
            //                             .id + '">' + district.name + '</option>');
            //                     });
            //                     // Set previously selected district if it's still valid
            //                     if (selectedDistrict && selectedDistrict !== "All") {
            //                         districtSelect.val(selectedDistrict);
            //                     }
            //                 } else {
            //                     alert(response.message);
            //                 }
            //             },
            //             error: function(error) {
            //                 alert("Error fetching districts. Please try again.");
            //             }
            //         });
            //     }

            //     updateOptions();
            // });

            // // Event listener for changes in district selects
            // // $('#officeDistrictContainer').on('change', 'select[name="district[]"]', function() {
            // //     let district_id = $(this).val();
            // //     let currentRow = $(this).closest('.office-district-row');

            // //     // If a district is selected, fetch offices based on selected district via AJAX
            // //     if (district_id !== "All") {
            // //         $.ajax({
            // //             url: "{{ url('fetch-office') }}",
            // //             type: "POST",
            // //             data: {
            // //                 district_id: district_id,
            // //                 _token: '{{ csrf_token() }}'
            // //             },
            // //             success: function(response) {
            // //                 if (response.status === 200) {
            // //                     let officeSelect = currentRow.find('select[name="office[]"]');
            // //                     // Clear existing options and keep selected office intact
            // //                     let selectedOffice = officeSelect.val();
            // //                     officeSelect.empty().append(
            // //                         '<option value="All" selected>All</option>');
            // //                     response.data.forEach(function(office) {
            // //                         officeSelect.append('<option value="' + office.id +
            // //                             '">' + office.name + '</option>');
            // //                     });
            // //                     // Set previously selected office if it's still valid
            // //                     if (selectedOffice && selectedOffice !== "All") {
            // //                         officeSelect.val(selectedOffice);
            // //                     }
            // //                 } else {
            // //                     alert(response.message);
            // //                 }
            // //             },
            // //             error: function(error) {
            // //                 alert("Error fetching offices. Please try again.");
            // //             }
            // //         });
            // //     }
            // //     updateOptions();
            // // });

            // // Function to update the options in the dropdowns based on selected values
            // function updateOptions() {
            //     let selectedOffices = [];
            //     let selectedDistricts = [];
            //     let selectNew = [];

            //     $('select[name="office[]"]').each(function() {
            //         if ($(this).val() !== "All") {
            //             selectedOffices.push($(this).val());
            //         }
            //     });

            //     // Get selected values from each district select
            //     $('select[name="district[]"]').each(function() {
            //         if ($(this).val() !== "All") {
            //             selectedDistricts.push($(this).val());
            //         }
            //     });
            //     // console.log('selected_office: '+selectedOffices+ ', selected_district: '+selectedDistricts)
            //     // Disable already selected options in office selects
            //     $('select[name="office[]"]').each(function() {
            //         let currentSelect = $(this);
            //         let options = currentSelect.find('option');
            //         // console.log(currentSelect.val())
            //         options.each(function() {
            //             if (selectedOffices.includes($(this).val()) && $(this).val() !==
            //                 currentSelect.val()) {
            //                 $(this).prop('disabled', true);
            //             } else {
            //                 $(this).prop('disabled', false);
            //             }
            //         });
            //     });

            //     $('select[name="district[]"]').each(function() {
            //         let currentSelect = $(this);
            //         let options = currentSelect.find('option');

            //         options.each(function() {
            //             if (selectedDistricts.includes($(this).val()) && $(this).val() !==
            //                 currentSelect.val()) {
            //                 $(this).prop('disabled', true);
            //             } else {
            //                 $(this).prop('disabled', false);
            //             }
            //         });
            //     });
            // }


            // $('#roleContainer').on('click', '.add-new-role', function() {
            //     let newRoleRow = `
        // <div class="flex flex-wrap space-y-4 role-row">
        //     <div class="w-full md:w-1/2 px-2">
        //         <label class="block text-sm font-medium text-gray-700">Role</label>
        //         <select name="role[]" class="block w-full mt-1 p-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" >
        //             <option value="" selected>Choose...</option>
        //             @foreach ($roles as $key => $value)
        //                 <option value="{{ $key }}">{{ $value }}</option>
        //             @endforeach
        //         </select>
        //     </div>
        //     <div class="w-full md:w-1/2 px-2 mb-4 flex justify-end">
        //         <button type="button" class="btn btn-danger remove-role bg-red-500 text-white px-4 py-1.5 rounded-md hover:bg-red-600">Remove</button>
        //     </div>
        // </div>
        // `;
            //     $('#roleContainer').append(newRoleRow);
            //     updateRoleOptions();
            // });

            // // Remove role row
            // $('#roleContainer').on('click', '.remove-role', function() {
            //     $(this).closest('.role-row').remove();
            //     updateRoleOptions();
            // });

            // // Update role options to disable selected roles
            // function updateRoleOptions() {
            //     let selectedRoles = [];
            //     $('select[name="role[]"]').each(function() {
            //         if ($(this).val() !== "") {
            //             selectedRoles.push($(this).val());
            //         }
            //     });

            //     $('select[name="role[]"]').each(function() {
            //         let currentSelect = $(this);
            //         currentSelect.find('option').each(function() {
            //             if (selectedRoles.includes($(this).val()) && $(this).val() !== currentSelect
            //                 .val()) {
            //                 $(this).prop('disabled', true);
            //             } else {
            //                 $(this).prop('disabled', false);
            //             }
            //         });
            //     });
            // }
        });
    </script>

</body>

</html>
