{{-- ---------------- extending employee app layout --------------- --}}
@extends('layouts.employees_layouts.employee_app')
@section('title', 'Transfer History')
@section('extra_css_links')

@endsection
@section('content')
<div class="py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <h3 class="text-2xl font-bold">Transfer History</h3>
        <div class="relative overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg datatable text-xs">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="border px-4 py-2 text-center">SI NO</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">District</th>
                        <th class="border px-4 py-2">Office</th>
                        <th class="border px-4 py-2">JTO Generate Date</th>
                        <th class="border px-4 py-2 text-center">View</th>
                    </tr>
                </thead>
                <tbody id="registrationTableBody">
                    <tr class="bg-white border-b">
                        <td class="border px-4 py-2 text-center">1</td>
                        <td class="border px-4 py-2">User 1</td>
                        <td class="border px-4 py-2">Kamrup</td>
                        <td class="border px-4 py-2">PNRD</td>
                        <td class="border px-4 py-2">21-01-2024</td>
                        <td class="border px-4 py-2 text-center">
                            <button class="view-assign-data text-blue-500 underline" value="">
                                View
                                <i class="bi bi-arrow-up-right"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('extra_js_links')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.umd.min.js"></script>
@endsection
