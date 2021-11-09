@extends('layouts.app')
@section('content')
    <section class="main-content columns is-fullheight">
        @include('admin._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                @include('_parts.notif')
                <div class="card is-hidden1">
                    <div class="card-header">
                        <div class="columns">
                            <div class="column is-half">
                                <p class="card-header-title">Students</p>
                            </div>
                            <div class="column is-one-third">
                                <p class="card-header-title">
                                    <a href="{{ route('student.create') }}" class="button is-success">Create</a>
                                </p>
                            </div>
                            <div class="column">
                                <p class="card-header-title">
                                <form id="frm_import" action="{{ url('/admin/student/import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="file is-info" style="top: -10px">
                                        <label class="file-label">
                                            <input id="input_import" class="file-input" type="file" name="file">
                                            <span class="file-cta">
                                                <span class="file-label">
                                                    CSV Upload
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </form>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <form action="" method="GET">
                                @csrf
                                <div class="columns">
                                    <div class="column is-one-third">
                                        <div class="label">Name</div>
                                        <input class="input" type="text" name="name" value="{{old('name', request()->name)}}">
                                    </div>
                                    <div class="column is-one-third">
                                        <div class="label">Class</div>
                                        <div class="select">
                                            <select name="class_id">
                                                <option value="">-- none --</option>
                                                @forelse($classes as $class)
                                                    <option value="{{ $class->id }}" {{ $class->id == request()->class_id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                @empty
                                                    <p></p>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column is-one-third">
                                        <div class="label">Teacher</div>
                                        <div class="select">
                                            <select name="teacher_id">
                                                <option value="">-- none --</option>
                                                @forelse($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}" {{ $teacher->id == request()->teacher_id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                                                @empty
                                                    <p></p>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns is-centered">
                                    <div class="column has-text-centered">
                                        <button type="submit" class="button is-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><abbr title="StudentID">Student ID</abbr></th>
                                    <th><abbr title="FullName">Full Name</abbr></th>
                                    <th><abbr title="Class">Class</abbr></th>
                                    <th><abbr title="Teacher">Teacher</abbr></th>
                                    <th><abbr title="Actions">Actions</abbr></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <th>{{ $student->padded_physical_id }}</th>
                                        <td>{{ $student->full_name }}</td>
                                        <td>{{ $student->classes }}</td>
                                        <td>{{ $student->teachers }}</td>
                                        <td class="has-text-centered"><a href="{{ route('student.edit', $student->id) }}">Edit</a> |
                                            <form id="frm_delete" action="{{ route('student.destroy', $student->id) }}" method="POST" hidden>
                                                @method('DELETE ')
                                                @csrf
                                            </form>
                                            <a href="javascript:void(0);" onclick="triggerDelete();">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No students found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $students->appends(request()->except('page'))->links('custom.pagination') }}
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </section>
    <script src="{{ asset('js/list.js')}}"></script>
@endsection
