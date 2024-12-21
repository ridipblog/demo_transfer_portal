<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Office Details</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
</head>

<body class="p-12">
    @if (@session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <div class="max-w-7xl mx-auto">
        <p class="text-5xl font-bold mb-4">Office Details</p>
        <div class="border mb-12 p-6">
            <form action="{{ route('add.office.details.post') }}" method="post" class="grid grid-cols-3 gap-2">
                @csrf
                <div>
                    <p>Enter Office name</p>
                    <input type="text" name="office" placeholder="office name" class="w-full">
                </div>
                <div>
                    <p>Select district name</p>
                    <select name="district[]" id="" multiple class="w-full select2">
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div>
                    <p>Select depertment name</p>
                    <select name="depertment" id="" class="w-full select2">
                        <option value="" selected disabled>Select Depertment</option>
                        @foreach ($depertments as $depertment)
                            <option value="{{ $depertment->id }}">{{ $depertment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex col-span-3 justify-end">
                    <button type="submit" class="py-2 px-4 bg-blue-600 text-white">Save</button>
                </div>
            </form>
        </div>
        <table border="1" class="w-full mt-12 datatable text-xs">
            <thead>
                <tr class="bg-gray-300">
                    <td class="text-center">Sl No</td>
                    <td>Office</td>
                    <td>District</td>
                    <td>Depertment</td>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($office_details as $office_detail)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $office_detail->office_fin_assam->name ?? 'N/A' }}</td>
                        <td>{{ $office_detail->districts->name ?? 'N/A' }}</td>
                        <td>{{ $office_detail->deptartments->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
            $('.select2').select2({
                placeholder: '- Select -'
            });
        });
    </script>
</body>

</html>
