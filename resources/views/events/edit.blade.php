{{-- resources/views/events/edit.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Event</h2>
    <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title', $event->title) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required>{{ old('description', $event->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Thumbnail URL</label>
            <input type="text" name="thumbnail" class="form-control" value="{{ old('thumbnail', $event->thumbnail) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Or Upload Image</label>
            <input type="file" name="thumbnail_upload" class="form-control" accept="image/*">
            @if($event->thumbnail)
                <div class="mt-2">
                    <img src="{{ $event->thumbnail }}" alt="Current Thumbnail" style="max-width:120px;max-height:80px;">
                    <span class="text-muted ms-2">Current</span>
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required value="{{ old('date', $event->date) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Event Location (click or drag marker on map)</label>
            <div id="map-container" style="position:relative;width:100vw;height:60vw;max-width:600px;max-height:400px;background:#eee;">
                <img src="/images/college_map.png" alt="College Map" style="width:100%;height:100%;">
                <div id="marker" style="position:absolute;left:{{ old('location_x', $event->location_x) }}%;top:{{ old('location_y', $event->location_y) }}%;cursor:pointer;transform:translate(-50%,-100%);font-size:2em;user-select:none;" data-bs-toggle="tooltip" data-bs-placement="top" title="Drag or click to set event location">
                    📍
                </div>
            </div>
            <input type="hidden" name="location_x" id="location_x" value="{{ old('location_x', $event->location_x) }}">
            <input type="hidden" name="location_y" id="location_y" value="{{ old('location_y', $event->location_y) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="upcoming" @if(old('status', $event->status)=='upcoming') selected @endif>Upcoming</option>
                <option value="happened" @if(old('status', $event->status)=='happened') selected @endif>Happened</option>
                <option value="cancelled" @if(old('status', $event->status)=='cancelled') selected @endif>Cancelled</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Admin Password</label>
            <input type="password" name="admin_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script>
const marker = document.getElementById('marker');
const mapContainer = document.getElementById('map-container');
let isDragging = false;

function setMarkerPosition(xPercent, yPercent) {
    marker.style.left = xPercent + '%';
    marker.style.top = yPercent + '%';
    document.getElementById('location_x').value = xPercent;
    document.getElementById('location_y').value = yPercent;
}

marker.addEventListener('mousedown', function(e) {
    isDragging = true;
});
document.addEventListener('mouseup', function(e) {
    isDragging = false;
});
document.addEventListener('mousemove', function(e) {
    if (!isDragging) return;
    const rect = mapContainer.getBoundingClientRect();
    let x = ((e.clientX - rect.left) / rect.width) * 100;
    let y = ((e.clientY - rect.top) / rect.height) * 100;
    x = Math.max(0, Math.min(100, x));
    y = Math.max(0, Math.min(100, y));
    setMarkerPosition(Math.round(x * 100) / 100, Math.round(y * 100) / 100);
});
mapContainer.addEventListener('click', function(e) {
    const rect = mapContainer.getBoundingClientRect();
    let x = ((e.clientX - rect.left) / rect.width) * 100;
    let y = ((e.clientY - rect.top) / rect.height) * 100;
    x = Math.max(0, Math.min(100, x));
    y = Math.max(0, Math.min(100, y));
    setMarkerPosition(Math.round(x * 100) / 100, Math.round(y * 100) / 100);
});
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
