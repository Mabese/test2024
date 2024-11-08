<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="{{ route('admin.institutions.create') }}">Add Institution</a></li>
                <li><a href="{{ route('admin.faculties.create') }}">Add Faculty</a></li>
                <li><a href="{{ route('admin.courses.create') }}">Add Course</a></li>
                <li><a href="{{ route('student.apply') }}">Apply Now</a></li>
                <li><a href="{{ route('student.admissions.index') }}">My Admissions</a></li>
                <!-- Add logout link or other links as needed -->
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Career Guidance Platform. All rights reserved.</p>
    </footer>
</body>
</html>
