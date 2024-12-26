@if ($view_data['status'] == 200)
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 office-district-row">
        <div class="form-group">
            <label for="inputDepartment" class="block text-sm font-medium text-gray-700">Department</label>
            <select id="inputDepartment_{{ $view_data['total_assign_form'] }}" name="department[]"
                class="form-control registration-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2">
                <option value="" selected>Choose...</option>
                @foreach ($view_data['departments'] as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <p class="registration-error text-red-500"></p>
        </div>
        {{-- {{ dd($view_data['related_directorate']) }} --}}
        <div class="">
            <div class="form-group">
                <label for="inputDirectorate" class="block text-sm font-medium text-gray-700">Directorate</label>
                <select name="directorate[]" id="inputDirectorate_{{ $view_data['total_assign_form'] }}"
                    class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 form_offices1 select2">
                    {{-- <option value="" selected>All</option> --}}
                </select>
            </div>
            <div style="" class="display-district"></div>
        </div>
        <div class="form-group">
            <label for="inputDistrict" class="block text-sm font-medium text-gray-700">District</label>
            <select name="district[]" id="districtSelect_{{ $view_data['total_assign_form'] }}"
                class="form-control mt-1 w-full block w-36 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 select2 form_district">
                <option value="All">All</option>
                @foreach ($view_data['districts'] as $district)
                    <option value="{{ $district->id ?? '' }}">{{ $district->name ?? 'N/A' }}</option>
                @endforeach
            </select>
        </div>
        <div class="">
            <div class="form-group">
                <label for="inputOffice" class="block text-sm font-medium text-gray-700">Office</label>
                <select name="office[{{ $view_data['count_assign_form'] }}][]"
                    id="officeSelect_{{ $view_data['total_assign_form'] }}"
                    class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 form_offices select2"
                    multiple>
                    {{-- <option value="" selected>All</option> --}}
                </select>
            </div>
            <div style="" class="display-district"></div>
        </div>
        <div class="form-group">
            <label for="inputRole" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role[]"
                class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 assign_role">
                <option value="" selected disabled>Select Role</option>
                @foreach ($view_data['roles'] as $role)
                    <option value="{{ $role->id ?? '' }}">{{ $role->display_name ?? 'N/A' }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-1/3 px-2 mb-4 flex justify-end">
            <button type="button"
                class="btn btn-danger remove-row bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 remove-assign-form">Remove</button>
        </div>
    </div>
@else
    <h1>Server error please try later </h1>
@endif


<script>
    $(document).ready(function() {
        $(document).on('change', '.registration-input', function() {
            var curr_dept = $(this).val();
            var row = $(this).closest(
                '.office-district-row'); // Get the closest row to the selected department

            // Find the corresponding directorate dropdown in the same row
            var directorateSelect = row.find('select.form_offices1');

            // If a department is selected, make the AJAX request
            if (curr_dept) {
                $.ajax({
                    type: "POST",
                    url: "/get-directorate-by-department", // Update with your server endpoint
                    data: {
                        department_id: curr_dept,
                        _token: '{{ csrf_token() }}' // CSRF token for security (if using Laravel)
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response && response.res_data && response.res_data
                            .related_directorate) {
                            // Clear existing options in the directorate select dropdown
                            directorateSelect.empty();

                            // Add default option
                            directorateSelect.append(
                                '<option value="">Choose Directorate...</option>');

                            // Loop through the directorates and add them as options
                            $.each(response.res_data.related_directorate, function(id,
                                name) {
                                directorateSelect.append('<option value="' + id +
                                    '">' + name + '</option>');
                            });

                            // Reinitialize Select2 (if used)
                            directorateSelect.trigger('change');
                        } else {
                            alert('No directorates found for the selected department.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while fetching the directorates.');
                    }
                });
            } else {
                // If no department is selected, clear the Directorate dropdown
                directorateSelect.empty();
            }
        });
    });
</script>
