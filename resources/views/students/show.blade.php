@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Student Details</h1>

    <div class="card shadow-lg border-0 rounded-lg mt-4">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="card-title mb-0">{{ $student->user->name }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" class="rounded-circle img-fluid" style="max-width: 200px;">
                    @else
                    <img src="{{ asset('default-avatar.png') }}" alt="Default Photo" class="rounded-circle img-fluid" style="max-width: 200px;">
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row">Email:</th>
                                <td>{{ $student->user->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Class:</th>
                                <td>{{ $student->schoolClass->class_name ?? "N/A" }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Admission Date:</th>
                                <td>{{ \Carbon\Carbon::parse($student->admission_date)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Yearly Fees:</th>
                                <td>₹{{ number_format($student->yearly_fees, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Back to Students List
            </a>
        </div>
    </div>
</div>
@endsection