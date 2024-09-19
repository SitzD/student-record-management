@extends('adminlte::page')

@section('title', 'Students List')

@section('content_header')
    <h1>Students List</h1>
@stop

@section('content')
    <div class="mb-3">
        <form action="{{ route('students.index') }}" method="GET">
            <input type="text" name="search" placeholder="Search..." value="{{ $search }}" class="form-control mb-2">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone_number }}</td>
                    <td>{{ $student->date_of_birth->format('Y-m-d') }}</td>
                    <td>{{ $student->address }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        {{ $students->links('pagination::bootstrap-4') }}
    </div>
@stop
