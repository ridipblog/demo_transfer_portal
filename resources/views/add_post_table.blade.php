<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <title>Document</title>
</head>

<body class="p-12 w-screen overflow-x-hidden">
    @if (@session('message'))
    <p>{{ session('message') }}</p>
    @endif
    <div class="max-w-7xl mx-auto">
        <p class="text-5xl font-bold mb-4">Post Details</p>
        <div class="border mb-12 p-6">
            <form action="{{ route('add.post.names') }}" method="POST" class="grid grid-cols-3 gap-2">
                @csrf
                <div class="">
                    <p>Select depertments name</p>
                    <select name="depertment" id="" class="w-full select2" style="width: 100%!important;">
                        <option value="" selected>Select Depertment</option>
                        @foreach ($view_data['depertments'] as $depertment)
                        <option value="{{ $depertment->id }}">{{ $depertment->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid gap-2">
                    <div class="">
                        <p>Select post name</p>
                        <select name="select_post" id="" class="w-full select2" style="width: 100%!important;">
                            <option value="" selected>Select Post</option>
                            @foreach ($view_data['posts'] as $post)
                            <option value="{{ $post->id }}">{{ $post->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <p>Enter post name is not exists in select box </p>
                        <input type="text" name="input_post" placeholder="Enter Post name" class="w-full">
                    </div>
                </div>
                <div class="">
                    <p>Select Grade Type</p>
                    <select name="grade_type" id="" class="w-full">
                        <option value="" selected disabled>Select Grade</option>
                        <option value="3">Grade III</option>
                        <option value="4">Grade IV</option>
                    </select>
                </div>
                <div class="">
                    <p>Enter Grade pay </p>
                    <input type="text" name="grade_pay" class="w-full">
                </div>
                <div class="flex col-span-3 justify-end">
                    <button type="submit" class="bg-sky-500 text-white px-4 py-2">Submit</button>
                </div>
            </form>
        </div>
        <table border="1" class="w-full mt-12 datatable text-xs">
            <thead>
                <tr class="bg-gray-300">
                    <td class="text-center">Sl No</td>
                    <td>Depertment Name</td>
                    <td>Post Name</td>
                    <td>Grade</td>
                    <td>Grade Pay</td>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($view_data['map_data'] as $map)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td>{{$map->deptartments->name ?? 'N/A'}}</td>
                    <td>{{$map->post_names->name ?? 'N/A'}}</td>
                    <td>{{$map->post_names->type ?? 'N/A'}}</td>
                    <td>{{$map->grade_pay ?? 'N/A'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $('.datatable').DataTable();
        $('.select2').select2();
    </script>
</body>

</html>
