@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile Details') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name and Email fields (common to all roles) -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <!-- Password Update (optional) -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <!-- Profile Picture (optional) -->
                        <div class="row mb-3">
                            <label for="profile_picture" class="col-md-4 col-form-label text-md-end">{{ __('Profile Picture') }}</label>
                            <div class="col-md-6">
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Picture" class="rounded-circle" width="100" height="100">
                                <input id="profile_picture" type="file" class="form-control" name="profile_picture">
                            </div>
                        </div>

                        <!-- Teacher-specific Fields -->
                        @if(isset($teacher))
                        <div class="row mb-3">
                            <label for="subject" class="col-md-4 col-form-label text-md-end">{{ __('Subject') }}</label>
                            <div class="col-md-6">
                                <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject', $teacher->subject) }}" required>
                            </div>
                        </div>
                        @endif

                        <!-- Student-specific Fields -->
                        @if(isset($student))
                        <div class="row mb-3">
                            <label for="teacher_id" class="col-md-4 col-form-label text-md-end">{{ __('Class Teacher') }}</label>
                            <div class="col-md-6">
                                <select id="teacher_id" class="form-control" name="teacher_id" required>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $student->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="admission_date" class="col-md-4 col-form-label text-md-end">{{ __('Admission Date') }}</label>
                            <div class="col-md-6">
                                <input id="admission_date" type="date" class="form-control" name="admission_date" value="{{ old('admission_date', $student->admission_date) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="yearly_fees" class="col-md-4 col-form-label text-md-end">{{ __('Yearly Fees') }}</label>
                            <div class="col-md-6">
                                <input id="yearly_fees" type="number" class="form-control" name="yearly_fees" value="{{ old('yearly_fees', $student->yearly_fees) }}" required>
                            </div>
                        </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection