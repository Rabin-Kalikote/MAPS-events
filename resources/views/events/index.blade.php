{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
    <ul class="nav nav-tabs" id="eventTabs" role="tablist">
        @foreach(['upcoming' => 'Upcoming', 'happened' => 'Happened', 'cancelled' => 'Cancelled'] as $key => $label)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if($loop->first) active @endif" id="{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab">{{ $label }}</button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-3">
        @foreach(['upcoming', 'happened', 'cancelled'] as $key)
            <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $key }}" role="tabpanel">
                <div class="row">
                @forelse(($events[$key] ?? []) as $event)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            @if($event->thumbnail)
                                <img src="{{ $event->thumbnail }}" class="card-img-top" alt="Event Thumbnail">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ $event->description }}</p>
                                <p class="card-text"><small>{{ $event->date }}</small></p>
                                <div class="admin-actions" style="display:none;">
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger ms-1" onclick="showDeleteModal({{ $event->id }})">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No events found.</p>
                @endforelse
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
    <h3 class="mt-5">College Map</h3>
    <div style="position:relative;width:600px;height:400px;background:#eee;">
        <img src="/images/college_map.png" alt="College Map" style="width:100%;height:100%;margin-left:auto;margin-right:auto;">
        @foreach($events->flatten() as $event)
            <div style="position:absolute;left:{{ $event->location_x }}px;top:{{ $event->location_y }}px;transform:translate(-50%,-100%);">
                <span title="{{ $event->title }}" style="color:red;font-size:2em;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $event->title }}">📍</span>
            </div>
        @endforeach
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
        el.style.display = isAdmin ? '' : 'none';
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
