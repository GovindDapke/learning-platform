@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Student</h1>
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Student Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
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

        <div class="form-group mt-2">
            <label for="admission_date">Admission Date</label>
            <input type="date" name="admission_date" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label for="yearly_fees">Yearly Fees</label>
            <input type="number" name="yearly_fees" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label for="photo">Student Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
