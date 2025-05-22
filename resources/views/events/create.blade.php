{{-- resources/views/events/create.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Add New Event</h2>
    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Thumbnail URL</label>
            <input type="text" name="thumbnail" class="form-control" value="{{ old('thumbnail') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Or Upload Image</label>
            <input type="file" name="thumbnail_upload" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required value="{{ old('date') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Event Location (click or drag marker on map)</label>
            <div id="map-container" style="position:relative;width:600px;height:400px;background:#eee;">
                <img src="/images/college_map.png" alt="College Map" style="width:100%;height:100%;">
                <div id="marker" style="position:absolute;left:300px;top:200px;cursor:pointer;transform:translate(-50%,-100%);font-size:2em;user-select:none;">
                    📍
                </div>
            </div>
            <input type="hidden" name="location_x" id="location_x" value="300">
            <input type="hidden" name="location_y" id="location_y" value="200">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="upcoming" @if(old('status')=='upcoming') selected @endif>Upcoming</option>
                <option value="happened" @if(old('status')=='happened') selected @endif>Happened</option>
                <option value="cancelled" @if(old('status')=='cancelled') selected @endif>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Event</button>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script>
const marker = document.getElementById('marker');
const mapContainer = document.getElementById('map-container');
let isDragging = false;

marker.addEventListener('mousedown', function(e) {
    isDragging = true;
});
document.addEventListener('mouseup', function(e) {
    isDragging = false;
});
document.addEventListener('mousemove', function(e) {
    if (!isDragging) return;
    const rect = mapContainer.getBoundingClientRect();
    let x = e.clientX - rect.left;
    let y = e.clientY - rect.top;
    // Clamp to map bounds
    x = Math.max(0, Math.min(rect.width, x));
    y = Math.max(0, Math.min(rect.height, y));
    marker.style.left = x + 'px';
    marker.style.top = y + 'px';
    document.getElementById('location_x').value = Math.round(x);
    document.getElementById('location_y').value = Math.round(y);
});
// Allow click to move marker
mapContainer.addEventListener('click', function(e) {
    const rect = mapContainer.getBoundingClientRect();
    let x = e.clientX - rect.left;
    let y = e.clientY - rect.top;
    x = Math.max(0, Math.min(rect.width, x));
    y = Math.max(0, Math.min(rect.height, y));
    marker.style.left = x + 'px';
    marker.style.top = y + 'px';
    document.getElementById('location_x').value = Math.round(x);
    document.getElementById('location_y').value = Math.round(y);
});
</script>
@endsection
