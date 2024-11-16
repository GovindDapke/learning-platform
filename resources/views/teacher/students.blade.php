@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Students Assigned to {{ $teacher->subject }} Teacher</h1>

    @if($students->isEmpty())
        <p>No students are assigned to you yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Admission Date</th>
                    <th>Yearly Fees</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->class }}</td>
                        <td>{{ $student->admission_date }}</td>
                        <td>{{ $student->yearly_fees }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
