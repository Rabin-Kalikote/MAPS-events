{{-- resources/views/events/edit.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Edit Event</h2>
    <form method="POST" action="{{ route('events.update', $event->id) }}">
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
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required value="{{ old('date', $event->date) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Location X</label>
            <input type="number" name="location_x" class="form-control" required value="{{ old('location_x', $event->location_x) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Location Y</label>
            <input type="number" name="location_y" class="form-control" required value="{{ old('location_y', $event->location_y) }}">
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
@endsection
