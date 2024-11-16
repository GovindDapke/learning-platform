@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Student</h1>
    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Student Name</label>
            <input 
                type="text" 
                class="form-control" 
                id="name" 
                name="name" 
                value="{{ old('name', $student->user->name) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                class="form-control" 
                id="email" 
                name="email" 
                value="{{ old('email', $student->user->email) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input 
                type="password" 
                class="form-control" 
                id="password" 
                name="password" 
                placeholder="Leave blank to keep unchanged">
        </div>

       

        <div class="form-group mt-2">
            <label for="teacher_id">Assign Teacher</label>
            <select name="teacher_id" class="form-control" required>
                <option value="">-- Select Teacher --</option>
                @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="admission_date" class="form-label">Admission Date</label>
            <input 
                type="date" 
                class="form-control" 
                id="admission_date" 
                name="admission_date" 
                value="{{ old('admission_date', $student->admission_date) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="yearly_fees" class="form-label">Yearly Fees</label>
            <input 
                type="number" 
                class="form-control" 
                id="yearly_fees" 
                name="yearly_fees" 
                value="{{ old('yearly_fees', $student->yearly_fees) }}" 
                required>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            @if ($student->photo)
                <div class="mb-2">
                    <img src="{{ Storage::url($student->photo) }}" alt="Student Photo" style="width: 100px; height: 100px;">
                </div>
            @endif
            <input 
                type="file" 
                class="form-control" 
                id="photo" 
                name="photo">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
