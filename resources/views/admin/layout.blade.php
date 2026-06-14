@extends('layout')
@section('content')
<!-- Sidebar -->
@include('backend.sidebar')

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <!-- Topbar -->
        @include('backend.navbar')

        <div class="container-fluid py-2">

            {{-- Page header --}}
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">@yield('page_title', 'Admin')</h1>
                    @hasSection('page_subtitle')
                        <p class="text-muted mb-0 small">@yield('page_subtitle')</p>
                    @endif
                </div>
                <div>@yield('page_actions')</div>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    <i class="fas fa-circle-check mr-1"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm">
                    <i class="fas fa-circle-exclamation mr-1"></i> {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('admin_content')
        </div>
    </div>

    @include('backend.footer')
</div>
@endsection
