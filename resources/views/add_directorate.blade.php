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
    </title>
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
</head>

<body>
    @if ($view_data['is_error'])
        <h1>{{ $view_data['message'] }}</h1>
    @else
        <form action="" id="add-direc-form">
            @csrf
            <div class="container mx-auto p-12 ">
                <p class="text-xl text-center font-semibold">Add Directory</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div class="h-full form-group">
                        <label for="inputDepartment" class="block text-sm font-medium text-gray-700">Select
                            Department</label>
                        <select id="select-depertment" name="department_id"
                            class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" selected disabled>Select</option>
                            @foreach ($view_data['depertments'] as $depertment)
                                <option value="{{ $depertment->id ?? '' }}">{{ $depertment->name ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                        <p class="registration-error text-red-500"></p>
                    </div>
                    <div class="h-full form-group">
                        <label for="inputName" class="block text-sm font-medium text-gray-700">Enter Directorate name
                        </label>
                        <input type="text" name="directorate"
                            class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            id="inputName" placeholder="Directorate name">
                        <p class="registration-error text-red-500"></p>
                    </div>
                    <div class="h-full flex">
                        <button type="submit"
                            class="mt-auto btn btn-primary text-sm text-white bg-blue-500 hover:bg-blue-600 rounded-md px-4 py-2 mt-6 submit-registration">Register</button>
                    </div>
                </div>
                <div class="relative overflow-x-auto">

                </div>
            </div>
        </form>

        <div class="container mx-auto p-12 ">
            <table border="1" class="w-full mt-12 datatable text-xs">
                <thead>
                    <tr class="bg-gray-300">
                        <td class="text-center">Sl No</td>
                        <td>Depertment Name</td>
                        <td>Directorate Name</td>
                    </tr>
                </thead>
                <tbody class="divide-y" id="dirct-body">
                    @foreach ($view_data['directorates'] ?? [] as $map)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $map->deptartments->name ?? 'N/A' }}</td>
                            <td>{{ $map->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.umd.min.js"></script>
    <script src="{{ asset('js/root_access/add_directorate.js') }}" type="module"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
            $('.select2').select2({
                placeholder: "- Select -",
                // allowClear: true
            });
        });
    </script>
</body>

</html>
