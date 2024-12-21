{{-- ------------ implement app layout------------------ --}}
@extends('layouts.app')

@section('title', 'about page')

{{-- -------------- start dynamic content ---------------- --}}
@section('content')
    <div class="max-w-7xl w-full mx-auto py-8 px-4 lg:px-8">
        <!-- Title Section -->
        <h1 class="text-3xl font-semibold text-center sm:text-left mb-8 text-gray-800">About Us</h1>
        <p class="mb-2 ">Welcome to Swagata Satirtha, a dedicated portal designed exclusively for government employees in
            Grade 3 and
            Grade 4 roles, offering a seamless solution for mutual transfers of their place of posting.</p>
        <p class="mb-8">At Swagata Satirtha, we recognize the unique needs of government employees who wish to align their
            professional
            responsibilities with personal priorities. Our platform acts as a bridge, connecting employees seeking mutual
            transfers, ensuring smooth transitions while adhering to government policies and regulations.
        </p>
        <p class="mb-2 font-bold">Our Mission</p>
        <p class="mb-8">To simplify the mutual transfer process for government employees, providing a transparent and
            efficient platform
            to help them find suitable matches effortlessly.</p>
        <p class="mb-2 font-bold">Our Vision</p>
        <p class="mb-8">To create a trusted and user-friendly solution for government employees, enabling them to achieve a
            better
            balance between work and personal life while ensuring organizational continuity.</p>
        <p class="mb-2 font-bold">What We Offer</p>
        <p class="mb-1">User-Friendly Platform: A simple and intuitive interface tailored for government employees to
            register, search,
            and connect with potential transfer matches.</p>
        <p class="mb-1">Transparency: Access to verified profiles and reliable information to make confident and informed
            decisions.</p>
        <p class="mb-8">Efficiency: A time-saving, hassle-free process that ensures quicker and smoother mutual transfer
            arrangements.
        </p>
        <p class="mb-2 font-bold">Who Can Use Swagata Satirtha?</p>
        <p>This platform is exclusively for government employees in Grade 3 and Grade 4 categories, seeking to mutually
            exchange their postings with others in similar roles across various locations.</p>
    </div>



@endsection

{{-- -------------- end dynamic content ---------------- --}}
