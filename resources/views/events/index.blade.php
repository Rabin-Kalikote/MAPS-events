{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center fw-bold" style="color:#533860;letter-spacing:1px;">MAPS Events</h1>
    <ul class="nav nav-tabs justify-content-center mb-4" id="eventTabs" role="tablist" style="border-bottom:1px solid rgb(222, 226, 230);">
        @foreach(['upcoming' => 'Upcoming', 'happened' => 'Happened', 'cancelled' => 'Cancelled'] as $key => $label)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if($loop->first) active @endif fw-semibold" id="{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab" style="color:#533860;">{{ $label }}</button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-3">
        @foreach(['upcoming', 'happened', 'cancelled'] as $key)
            <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $key }}" role="tabpanel">
                <div class="p-4 mb-4 bg-white shadow-sm rounded-4 border border-2 border-warning-subtle">
                    <div class="row g-4">
                    @forelse(($events[$key] ?? []) as $event)
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-sm h-100 border-0" style="border-radius:1.5rem;overflow:hidden;position:relative;">
                                @if($event->thumbnail)
                                    <img src="{{ $event->thumbnail }}" class="card-img-top" alt="Event Thumbnail" style="height:180px;object-fit:cover;">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold" style="color:#533860;">{{ $event->title }}</h5>
                                    <p class="card-text flex-grow-1">{{ $event->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="badge rounded-pill" style="background:#ffe42a;color:#533860;font-weight:600;">{{ ucfirst($event->status) }}</span>
                                        <small class="text-muted">{{ $event->date }}</small>
                                    </div>
                                </div>
                                <div class="admin-actions w-100 d-flex border-top d-none" style="display:none;">
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning flex-fill rounded-0 border-0">Edit</a>
                                    <button type="button" class="btn btn-danger flex-fill rounded-0 border-0" onclick="showDeleteModal({{ $event->id }})">Delete</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No events found.</p>
                    @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <p>Enter admin password to confirm deletion:</p>
                <input type="password" name="admin_password" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <h3 class="mt-5 mb-3 text-center fw-bold" style="color:#533860;">College Map</h3>
    <div class="d-flex justify-content-center">
        <div style="position:relative;width:600px;height:400px;background:#eee;border-radius:1.5rem;box-shadow:0 4px 24px #53386022;overflow:hidden;">
            <img src="/images/college_map.png" alt="College Map" style="width:100%;height:100%;object-fit:cover;">
            @foreach($events->flatten() as $event)
                <div style="position:absolute;left:{{ $event->location_x }}px;top:{{ $event->location_y }}px;transform:translate(-50%,-100%);">
                    <span title="{{ $event->title }}" style="color:#ffe42a;font-size:2em;text-shadow:1px 1px 4px #533860;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $event->title }}">📍</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function updateAdminActions() {
    const isAdmin = localStorage.getItem('maps_admin') === '1';
    document.querySelectorAll('.admin-actions').forEach(el => {
        if (isAdmin) {
            el.classList.remove('d-none');
            el.style.display = 'flex';
        } else {
            el.classList.add('d-none');
            el.style.display = 'none';
        }
    });
}
window.addEventListener('maps_admin_change', updateAdminActions);
document.addEventListener('DOMContentLoaded', function() {
    updateAdminActions();
});

window.showDeleteModal = function(eventId) {
    const form = document.getElementById('deleteForm');
    form.action = `/events/${eventId}`;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    form.reset();
    modal.show();
};
</script>
@endsection
