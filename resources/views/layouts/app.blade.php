<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-buttons">
                <a href="{{ route('sections.index') }}" class="nav-button @if(request()->routeIs('sections.*')) active @endif">
                    Sections
                </a>
                <a href="{{ route('students.index') }}" class="nav-button @if(request()->routeIs('students.*')) active @endif">
                    Students
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    {{ session('success') }}
                    <button type="button" class="alert-close">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    {{ session('error') }}
                    <button type="button" class="alert-close">&times;</button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible">
                    {{ session('warning') }}
                    <button type="button" class="alert-close">&times;</button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script type="module" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
