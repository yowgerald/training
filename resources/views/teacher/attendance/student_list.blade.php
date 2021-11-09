@extends('layouts.app')
@section('content')
    <section class="main-content columns is-fullheight">
        @include('teacher._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                @include('_parts.notif')
                <div class="card is-hidden1">
                    <div class="card-header"><p class="card-header-title">Attendance - {{ $classPeriod->class->name }}</p></div>
                    <div class="card-content">
                        <p class="subtitle is-6"><strong><i>Period: {{ date("H:i A", $classPeriod->period_start) . ' - ' . date("H:i A", $classPeriod->period_end) }}</i></strong></p>
                        <div class="content">
                            <form method="POST">
                                @csrf
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><abbr title="StudentID">Student ID</abbr></th>
                                    <th><abbr title="Class">Name</abbr></th>
                                    <th><abbr title="Actions">Present</abbr></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <th>{{ $student->padded_physical_id }}</th>
                                        <td>{{ $student->full_name }}</td>
                                        <td class="has-text-centered">
                                            <input
                                                type="checkbox"
                                                name="is_present_{{ $student->class_user_id }}"
                                                value="{{ $student->is_present == 1 ? 1 : 0 }}"
                                                {{ $student->is_present == 1 ? 'checked' : '' }}
                                                onchange="changeHiddenValue(this)">
                                            <input
                                                type="hidden"
                                                id="is_present_{{ $student->class_user_id }}"
                                                name="is_present_{{ $student->class_user_id }}"
                                                value="{{ $student->is_present == 1 ? 1 : 0 }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No students found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $students->links('custom.pagination') }}
                        </div>
                        <input type="hidden" name="class_period_id" value="{{ $classPeriod->id  }}">
                        <button class="button is-primary" type="submit">Save</button>
                        </form>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </section>
    <script>
        let changeHiddenValue = (event) => {
            const TO_CHANGE = document.querySelector('#'+event.name);
            TO_CHANGE.value = event.checked ? 1 : 0;
        }
    </script>
@endsection
