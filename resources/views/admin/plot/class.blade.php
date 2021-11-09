@extends('layouts.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <section class="main-content columns is-fullheight">
        @include('admin._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                @include('_parts.notif')
                <div class="card is-hidden1">
                    <div class="card-header">
                        <div class="columns">
                            <div class="column">
                                <p class="card-header-title">Plot Classes</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <form action="" method="GET">
                                @csrf
                                <div class="columns">
                                    <div class="column is-one-third">
                                        <div class="label">Select Class</div>
                                        <div class="select">
                                            <select name="class_id" id="select_class">
                                                @forelse($classes as $class)
                                                    <option value="{{ $class->id }}" {{ $class->id == request()->class_id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                @empty
                                                    <p></p>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column is-one-third">
                                        <div class="label">Select Period</div>
                                        <input type="text" class="input" name="period" id="select_period" value="{{ request()->period ?? '08:00 - 09:00' }}"/>
                                    </div>
                                    <div class="column is-one-third">
                                        <button type="submit" class="button is-primary" style="top: 32px">View</button>
                                    </div>
                                </div>
                            </form>
                            <br />
                            <div class="label">Student List</div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><abbr title="StudentID">Student ID</abbr></th>
                                    <th><abbr title="FullName">Full Name</abbr></th>
                                    <th><abbr title="Actions">Actions</abbr></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($classStudents as $classStudent)
                                    <tr>
                                        <th>{{ $classStudent->padded_physical_id }}</th>
                                        <td>{{ $classStudent->full_name }}</td>
                                        <td class="has-text-centered">
                                            <form id="frm_delete" action="{{ route('plot_class.destroy', $classStudent->attendance_id) }}" method="POST" hidden>
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
                            {{ $classStudents->links('custom.pagination') }}
                            <div class="columns">
                                <form action="{{ route('plot_class.store') }}" method="POST" style="display: contents">
                                    @csrf
                                    <div class="column is-one-third">
                                        <div class="label">Add Student</div>
                                        <div class="select">
                                            <select name="user_id">
                                                @forelse($students as $student)
                                                    <option value="{{ $student->id }}" }}>({{ $student->physical_id }}) {{ $student->full_name }}</option>
                                                @empty
                                                    <p></p>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column is-one-third">
                                        <input type="hidden" name="class_id" id="class_id" value="{{ request()->class_id  ?? $selectedClass->id }}">
                                        <input type="hidden" name="period" id="period" value="{{ request()->period ?? '08:00 - 09:00' }}">
                                        <button type="submit" class="button is-warning is-light" style="top: 32px">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('input', function (event) {
            if (event.target.id === 'select_class') {
                document.querySelector('#class_id').value = event.target.value;
            }
        }, false);
    </script>
    <script src="{{ asset('js/list.js')}}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('#select_period').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'HH:mm'
            },
            onSelect: function(d, i) {
                $(this).change();
            }
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        }).on("change", function() {
            $('#period').val($(this).val());
        });
    </script>
@endsection
