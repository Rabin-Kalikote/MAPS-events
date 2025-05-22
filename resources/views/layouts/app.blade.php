<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPS Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 custom-navbar">
        <div class="container-fluid justify-content-between align-items-center">
            <a class="navbar-brand fw-bold" href="{{ route('events.index') }}">MAPS Events</a>
            <form method="GET" action="{{ route('events.index') }}" class="d-flex mx-auto navbar-search-form">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search events..." class="form-control me-2 custom-search-input" style="width:300px;">
                <button type="submit" class="btn btn-primary custom-search-btn">Search</button>
            </form>
            <a href="{{ route('events.create') }}" class="btn btn-success ms-auto custom-add-btn">+ Add Event</a>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .custom-navbar {
            background: var(--theme-color) !important;
            border-bottom: 3px solid var(--secondary-color);
            box-shadow: 0 2px 8px #53386022;
        }
        .navbar-brand {
            color: #fff !important;
            font-size: 1.7rem;
            letter-spacing: 1px;
        }
        .navbar-search-form {
            flex: 1 1 auto;
            justify-content: center;
            align-items: center;
        }
        .custom-search-input {
            border-radius: 2rem 0 0 2rem;
            border: 2px solid var(--secondary-color);
            background: #fffbe6;
            color: var(--theme-color);
            font-weight: 500;
        }
        .custom-search-btn {
            border-radius: 0 2rem 2rem 0;
            background: var(--secondary-color) !important;
            color: var(--theme-color) !important;
            border: 2px solid var(--secondary-color);
            font-weight: 600;
        }
        .custom-add-btn {
            background: var(--theme-color) !important;
            color: #fff !important;
            border-radius: 2rem;
            font-weight: 600;
            box-shadow: 0 2px 8px #53386022;
            border: 2px solid var(--theme-color);
            transition: background 0.2s, color 0.2s;
        }
        .custom-add-btn:hover {
            background: var(--secondary-color) !important;
            color: var(--theme-color) !important;
            border: 2px solid var(--secondary-color);
        }
    </style>
</body>
</html>
