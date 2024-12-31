@if ($view_data['status'] == 200)

    @foreach ($view_data['related_districts'] as $district)
        <p>office -> {{ $district->office_fin_assam->name ?? 'N/A' }}</p>
        <p>district-> {{ $district->districts->name ?? 'N/A' }}</p>
    @endforeach
@else
    <h1>Server error please try later </h1>
@endif
