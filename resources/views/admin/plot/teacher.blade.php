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
                                <p class="card-header-title">Plot Teachers</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <form action="" method="GET">
                                @csrf
                                <div class="columns">
                                    <div class="column is-one-third">
                                        <div class="label">Select Teacher</div>
                                        <div class="select">
                                            <select name="user_id" id="select_teacher">
                                                @forelse($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}" {{ $teacher->id == request()->user_id ? 'selected' : '' }}>({{ $teacher->physical_id }}) {{ $teacher->full_name }}</option>
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
                            <div class="label">
                                Class List
                                ({{ mb_strimwidth($selectedTeacher->teacherDetail->title, 0, 5, '.') . ' ' . $selectedTeacher->full_name }})
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><abbr title="Class">Class</abbr></th>
                                    <th><abbr title="Actions">Actions</abbr></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($teacherClasses as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td class="has-text-centered">
                                            <form id="frm_delete" action="{{ route('plot_teacher.destroy', $class->class_period_id) }}" method="POST" hidden>
                                                @method('DELETE ')
                                                @csrf
                                            </form>
                                            <a href="javascript:void(0);" onclick="triggerDelete();">Remove</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No classes found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $teacherClasses->links('custom.pagination') }}
                            <div class="columns">
                                <form action="{{ route('plot_teacher.store') }}" method="POST" style="display: contents">
                                    @csrf
                                    <div class="column is-one-third">
                                        <div class="label">Add Class</div>
                                        <div class="select">
                                            <select name="class_id">
                                                @forelse($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @empty
                                                    <option value="">-- no classes --</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column is-one-third">
                                        <input type="hidden" name="user_id" id="user_id" value="{{ request()->user_id ?? $selectedTeacher->id }}">
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
            if (event.target.id === 'select_teacher') {
                document.querySelector('#user_id').value = event.target.value;
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
