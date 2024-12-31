@extends('verification.layouts.header')

{{-- Dynamic Title --}}
@section('title', 'Switch Role')

{{-- Dynamic Body Content --}}
@section('content')
<div style="display: flex; align-items: center; justify-content: center; height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Approver Card -->
            @foreach($roles as $r)
            @if($r->role == 'Approver')
            <a href="/switch-role/{{Crypt::encryptString($r->id)}}">
            <div class="col-md-3 mb-4">
                <div class="card text-center shadow-sm border-0" style="border-radius: 10px; transition: transform 0.3s;">
                    <div class="card-body" style="background: linear-gradient(135deg, #4e73df, #224abe); color: white; border-radius: 10px;">
                        <i class="fas fa-user-check fa-3x mb-3"></i>
                        <h5 class="card-title font-weight-bold">{{$r->display_name}} Dashboard</h5>
                        {{-- <p class="card-text">Review and approve applications with efficiency and precision.</p> --}}
                        {{-- <a href="" class="btn btn-light font-weight-bold mt-3">Switch to Approver</a> --}}
                    </div>
                </div>
            </div>
            </a>
            @endif
            <!-- Verifier Card -->
            @if($r->role == 'Verifier')
            <a href="/switch-role/{{Crypt::encryptString($r->id)}}">
            <div class="col-md-3 mb-4">
                <div class="card text-center shadow-sm border-0" style="border-radius: 10px; transition: transform 0.3s;">
                    <div class="card-body" style="background: linear-gradient(135deg, #1cc88a, #13855c); color: white; border-radius: 10px;">
                        <i class="fas fa-user-shield fa-3x mb-3"></i>
                        <h5 class="card-title font-weight-bold">{{$r->display_name}} Dashboard</h5>
                        {{-- <p class="card-text">Verify documents and applications with accuracy and speed.</p> --}}
                        {{-- <a href="" class="btn btn-light font-weight-bold mt-3">Switch to Verifier</a> --}}
                    </div>
                </div>
            </div>
            </a>
            @endif
            <!-- Appointing Authority Card -->
            @if($r->role == 'Appointing Authority')
            <a href="/switch-role/{{Crypt::encryptString($r->id)}}">
            <div class="col-md-3 mb-4">
                <div class="card text-center shadow-sm border-0" style="border-radius: 10px; transition: transform 0.3s;">
                    <div class="card-body" style="background: linear-gradient(135deg, #f6c23e, #d29b1b); color: white; border-radius: 10px;">
                        <i class="fas fa-user-tie fa-3x mb-3"></i>
                        <h5 class="card-title font-weight-bold">{{$r->display_name}} Dashboard</h5>
                        {{-- <p class="card-text">Manage appointments and authority responsibilities efficiently.</p> --}}
                        {{-- <a href="" class="btn btn-light font-weight-bold mt-3">Switch to Authority</a> --}}
                    </div>
                </div>
            </div>
            </a>
            @endif
            <!-- Appointing User Card -->
            @if($r->role == 'Appointing User')
            <a href="/switch-role/{{Crypt::encryptString($r->id)}}">
            <div class="col-md-3 mb-4">
                <div class="card text-center shadow-sm border-0" style="border-radius: 10px; transition: transform 0.3s;">
                    <div class="card-body" style="background: linear-gradient(135deg, #f6c23e, #d29b1b); color: white; border-radius: 10px;">
                        <i class="fas fa-user-tie fa-3x mb-3"></i>
                        <h5 class="card-title font-weight-bold">{{$r->display_name}} Dashboard</h5>
                        {{-- <p class="card-text">Manage appointments and authority responsibilities efficiently.</p> --}}
                        {{-- <a href="" class="btn btn-light font-weight-bold mt-3">Switch to Authority</a> --}}
                    </div>
                </div>
            </div>
            </a>
            @endif
            @endforeach
        </div>
    </div>
</div>

{{-- Include Font Awesome for icons (only include this if not already included in your project) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
