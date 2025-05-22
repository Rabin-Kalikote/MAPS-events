<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPS Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4 custom-navbar">
        <div class="container-fluid justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light me-3 fw-bold" id="adminSignInBtn" data-bs-toggle="modal" data-bs-target="#adminSignInModal">
                    <i class="bi bi-person-lock"></i> Admin Sign In
                </button>
                <button class="btn btn-outline-warning me-3 fw-bold d-none" id="adminSignOutBtn">
                    <i class="bi bi-box-arrow-right"></i> Admin Sign Out
                </button>
                <a class="navbar-brand fw-bold" href="{{ route('events.index') }}">MAPS Events</a>
            </div>
            <form method="GET" action="{{ route('events.index') }}" class="d-flex mx-auto navbar-search-form">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search events..." class="form-control custom-search-input" style="width:300px;">
                <button type="submit" class="btn btn-primary custom-search-btn">Search</button>
            </form>
            <a href="{{ route('events.create') }}" class="btn btn-success ms-auto custom-add-btn">+ Add Event</a>
        </div>
    </nav>

    <!-- Admin Sign In Modal -->
    <div class="modal fade" id="adminSignInModal" tabindex="-1" aria-labelledby="adminSignInModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="adminSignInModalLabel">Admin Sign In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="password" id="adminPasswordInput" class="form-control" placeholder="Enter admin password">
            <div class="invalid-feedback mt-2" id="adminPasswordError" style="display:none;">Incorrect password.</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="adminSignInSubmit">Sign In</button>
          </div>
        </div>
      </div>
    </div>

    <main>
        @yield('content')
    </main>
    <footer class="text-center py-4 mt-5" style="background: #533860; color: #fff; border-top: 3px solid #ffe42a;">
        <div>
            <a href="https://www.collegeofidaho.edu" target="_blank" style="color: #ffe42a; font-weight: bold; text-decoration: underline;">College of Idaho</a>
        </div>
        <div class="mt-2" style="font-size: 1rem;">
            MAPS Events app built by Rabin Kalikote and Shubham Shrestha
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Admin sign in logic
        const adminSignInBtn = document.getElementById('adminSignInBtn');
        const adminSignInSubmit = document.getElementById('adminSignInSubmit');
        const adminPasswordInput = document.getElementById('adminPasswordInput');
        const adminPasswordError = document.getElementById('adminPasswordError');
        const adminSignOutBtn = document.getElementById('adminSignOutBtn');
        const ADMIN_PASSWORD = 'mapsadmin123';

        function setAdminMode(enabled) {
            if (enabled) {
                localStorage.setItem('maps_admin', '1');
                adminSignInBtn.classList.add('d-none');
                adminSignOutBtn.classList.remove('d-none');
            } else {
                localStorage.removeItem('maps_admin');
                adminSignInBtn.classList.remove('d-none');
                adminSignOutBtn.classList.add('d-none');
            }
            window.dispatchEvent(new Event('maps_admin_change'));
        }

        adminSignInSubmit.addEventListener('click', function() {
            if (adminPasswordInput.value === ADMIN_PASSWORD) {
                setAdminMode(true);
                adminPasswordError.style.display = 'none';
                adminPasswordInput.value = '';
                var modal = bootstrap.Modal.getInstance(document.getElementById('adminSignInModal'));
                modal.hide();
            } else {
                adminPasswordError.style.display = 'block';
            }
        });

        // Optional: sign out on double click
        adminSignInBtn.addEventListener('dblclick', function() {
            setAdminMode(false);
            alert('Admin signed out.');
        });

        // Show/hide sign in/out buttons on load
        if (localStorage.getItem('maps_admin') === '1') {
            adminSignInBtn.classList.add('d-none');
            adminSignOutBtn.classList.remove('d-none');
        } else {
            adminSignInBtn.classList.remove('d-none');
            adminSignOutBtn.classList.add('d-none');
        }

        adminSignOutBtn.addEventListener('click', function() {
            setAdminMode(false);
        });
    });
    </script>
</body>
</html>
