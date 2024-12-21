<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>State Registration</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <form action="" id="state_user_registration" method="post">
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
                <label for="inputPhone" class="block text-sm font-medium text-gray-700">User Name</label>
                <input type="text" name="user_name" id="inputPhone"
                    class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="User name" title="Please enter a user name ">
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
                <select id="inputDepartment" name="department[]"
                    class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2" multiple>
                    @foreach ($view_data['departments'] as $department)
                        <option value="{{ $department->id ?? '' }}">{{ $department->name ?? 'N/A' }}</option>
                    @endforeach
                </select>
                <p class="registration-error text-red-500"></p>
            </div>
            <p>State Level Approving Authority</p>

        </div>
        <button type="submit"
            class="btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 mt-6 submit-registration">Register</button>
    </form>

    <div class="mt-10">
        <h3 class="text-2xl font-bold">Registered Users</h3>
        <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg datatable text-xs">
            <thead>
                <tr class="bg-gray-50">
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2 text-left">Name</th>
                    <th class="border px-4 py-2 text-left">Phone Number</th>
                    <th class="border px-4 py-2 text-left">Designation</th>
                    <th class="border px-4 py-2 text-left">Role</th>
                    <th class="border px-4 py-2 text-left">Department</th>

                </tr>
            </thead>
            <tbody id="registrationTableBody">
                {{-- {{dd($registered_users[1]->all_logins[0]->roles)}} --}}
                @php $count = 1 @endphp
                @foreach ($view_data['registered_users'] as $user)
                    <tr class="bg-white border-b">
                        <td class="border px-4 py-2">{{ $count++ }}</td>
                        <td class="border px-4 py-2">{{ $user->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $user->phone ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $user->designation ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $user->all_logins[0]->roles->display_name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            @php
                                $departments = [];
                                foreach ($user->authority_office_dist_map ?? [] as $depertment) {
                                    array_push($departments, $depertment->new_deptartments->name ?? 'N/A');
                                }
                                $department_names = !empty($departments) ? implode(', ', $departments) : 'N/A';
                                echo $department_names;
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.umd.min.js"></script>
    <script type="module" src="{{ asset('js/root_access/add_state_user.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
            $('.select2').select2({
                placeholder: "- Select -",
                // allowClear: true
            });
        })
    </script>
</body>

</html>
