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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>User Registration</title>
</head>
<style>
    .select2 {
        width: 100% !important;
    }
</style>

<body class="max-w-screen overflow-x-hidden">
    <div class="max-w-7xl w-full mx-auto my-8">
        <!-- Display any validation errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <ul class="list-disc ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success or error message from session -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif


        <p class="text-4xl font-bold mb-6">User Registration</p>

        <form action="{{ url('re-assign-user') }}" method="post">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="user" class="block text-sm font-medium text-gray-700">User</label>
                    <select id="user" name="user_ids"
                        class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2">
                        <option value="" selected>Choose...</option>
                        @foreach ($users as $u)
                            <option value="{{ $u['id'] }}">{{ $u['name'] }}</option>
                        @endforeach
                    </select>
                    <p class="registration-error text-red-500"></p>
                </div>

                <div class="form-group">
                    <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                    <select id="department" name="department_ids"
                        class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2">
                        <option value="" selected>Choose...</option>
                    </select>
                    <p class="registration-error text-red-500"></p>
                </div>

                <!-- New Directorate Select Box -->
                <div class="form-group">
                    <label for="directorate" class="block text-sm font-medium text-gray-700">Directorate</label>
                    <select id="directorate" name="directorate_ids"
                        class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2">
                        <option value="" selected>Choose...</option>
                    </select>
                    <p class="registration-error text-red-500"></p>
                </div>
            </div>

            <button type="submit"
                class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 mt-6 submit-registration">Register</button>
        </form>



        <!-- DataTable will appear here -->
        <table id="userDetailsTable" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Departments</th>
                    <th>Phone Number</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be inserted here dynamically -->
            </tbody>
        </table>


        <table id="dynamicTable" class="table-auto w-full mt-4 border border-gray-200 rounded-lg datatable text-xs">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2 text-left">Name</th>
                    <th class="border px-4 py-2 text-left">Role</th>
                    <th class="border px-4 py-2 text-left">Office</th>
                    <th class="border px-4 py-2 text-left">District</th>
                    <th class="border px-4 py-2 text-left">New</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be appended here dynamically -->
            </tbody>
        </table>
        



        {{-- modal assign --}}
        <div class="modal" id="assign_modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Assign new office, district</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form action="" id="authority_registration" method="post">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="inputName" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name"
                                    class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    id="inputName" placeholder="User Name" value="" disabled>
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
            
                        <!-- Office and District Selection Section -->
                        <div id="officeDistrictContainer" class="space-y-6 mt-6">
                            <div class="form-group flex items-end">
                                <button type="button"
                                    class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 add-new-row add-assign-form">+
                                    Office</button>
                            </div>
                        </div>
            
            
            
                        <button type="submit"
                            class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 mt-6 submit-registration">Register</button>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">Save changes</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.umd.min.js"></script>
    
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            var table = $('#userDetailsTable').DataTable({
                searching: false,
                paging: true,
                info: false,
                autoWidth: false
            });

            // Initialize Select2 dropdown
            $('.select2').select2({
                placeholder: "- Select -",
            });

            // Event listener for user selection change
            $('#user').change(function() {
                var userId = $(this).val();
                if (userId) {
                    console.log(userId)
                    // Make the AJAX call to fetch user details
                    $.ajax({
                        url: '{{ route('fetch-prev-user') }}', // Make sure you update this URL in your routes file
                        type: 'POST',
                        data: {
                            user_id: userId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Check if we have data from the server
                            if (response.status === 200) {
                                // Empty the existing table content
                                var table = $('#userDetailsTable').DataTable();
                                table.clear();

                                // Get the user and departments data from the response
                                var user = response.data; // user data from the response
                                var departments = response
                                    .departments; // departments from the response

                                console.log(
                                    response.departments[0]['name']
                                ); // Logging to check the structure of the response

                                var departmentNames = '';
                                $('#department').empty();
                                $('#department').append(
                                    '<option value="" selected>Choose...</option>');
                                if (Array.isArray(departments)) {
                                    for (var i = 0; i < departments.length; i++) {
                                        var department = departments[i];
                                        $('#department').append('<option value="' + department
                                            .id + '">' + department.name + '</option>');
                                        if (i > 0) {
                                            departmentNames +=
                                                ', ';
                                        }
                                        departmentNames += department.name;
                                    }
                                }
                                let btn = `<button class="btn btn-primary btn-sm" value="${user.id}">View</button>`;
                                // Add the row to the DataTable
                                table.row.add([
                                    user.name, // User name (column 0)
                                    departmentNames, // Comma-separated list of departments (column 1)
                                    user.phone,
                                    btn 
                                ]).draw();

                                // Show the DataTable container
                                $('#userDetailsTableContainer').removeClass('hidden');
                                $('#userDetailsTable').removeClass('hidden');
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                        }
                    });
                } else {
                    // Hide the table if no user is selected
                    $('#userDetailsTableContainer').addClass('hidden');
                    $('#userDetailsTable').addClass('hidden');
                    // Clear the department select box if no user is selected
                    $('#department').empty();
                    $('#department').append('<option value="" selected>Choose...</option>');
                }
            });

            $(document).on('click', '.btn-primary', function(){
                var id = $(this).val();
                $.ajax({
                    type: "post",
                    url: "/fetch_off_dist",
                    data: {id: id},
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status === 200) {
                    // Clear the table body before appending new rows
                    $('#dynamicTable tbody').empty();

                    // Iterate over authority_office_dist_map
                    response.data.assign_data.authority_office_dist_map.forEach((assign_data, index) => {
                        // Determine district name
                        let districtName = '';
                        if (assign_data.district_id) {
                            districtName = assign_data.districts?.name ?? 'N/A';
                        } else if (assign_data.office_id) {
                            districtName = (assign_data.office_fin_assam?.office_dist_dept_map ?? [])
                                .map(district => district.districts?.name ?? 'N/A')
                                .join(', ') || 'N/A';
                        } else {
                            districtName = 'ALL';
                        }

                        // Append a row to the table
                        $('#dynamicTable tbody').append(`
                            <tr>
                                <td class="border px-4 py-2">${index + 1}</td>
                                <td class="border px-4 py-2">${response.data.assign_data.name}</td>
                                <td class="border px-4 py-2">${assign_data.roles?.display_name ?? 'N/A'}</td>
                                <td class="border px-4 py-2">${assign_data.office_id == null ? 'All' : assign_data.office_fin_assam?.name ?? 'N/A'}</td>
                                <td class="border px-4 py-2">${districtName}</td>

                                <td><button class="btn btn-sm btn_primary assign_btn" value="${response.data.assign_data.id}">Edit</button></td>
                            </tr>
                        `);
                    });
                } else {
                    alert('Server error, please try again later!');
                }
                    }
                });
            });

            $(document).on('click', '.assign_btn', function () {
                $$(this).val());
                // $('#assign_modal').modal('show');
            });

            // Event listener for department selection change
            $('#department').change(function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    console.log(departmentId);
                    $.ajax({
                        url: '{{ route('fetch-directorates') }}',
                        type: 'POST',
                        data: {
                            department_id: departmentId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Clear the directorate select box first
                            $('#directorate').empty();
                            $('#directorate').append(
                                '<option value="" selected>Choose...</option>');

                            // Add "N/A" option as the first option
                            $('#directorate').append('<option value="na">N/A</option>');

                            if (response.status === 200 && Array.isArray(response
                                    .directorates)) {
                                // Populate the directorate select box with actual directorates
                                response.directorates.forEach(function(directorate) {
                                    $('#directorate').append('<option value="' +
                                        directorate.id + '">' + directorate.name +
                                        '</option>');
                                });
                            } else {
                                // If no directorates found, show an error
                                Swal.fire('Error',
                                    'No directorates found for the selected department.',
                                    'error');
                            }
                        },
                        error: function(error) {
                            // Handle AJAX error
                            Swal.fire('Error',
                                'An error occurred while fetching directorates. Please try again.',
                                'error');
                        }
                    });
                } else {
                    // If no department is selected, clear the directorate select box
                    $('#directorate').empty();
                    $('#directorate').append('<option value="" selected>Choose...</option>');
                }
            });



            // Destroy DataTable before reinitializing
            if ($.fn.DataTable.isDataTable('#userDetailsTable')) {
                $('#userDetailsTable').DataTable().clear().destroy();
            }
        });
    </script>

</body>

</html>
