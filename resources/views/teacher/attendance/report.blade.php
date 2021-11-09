@extends('layouts.app')
@section('content')
    <section class="main-content columns is-fullheight">
        @include('teacher._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                <div class="card is-hidden1">
                    <div class="card-header">
                        <div class="columns">
                            <div class="column is-three-fifths">
                                <p class="card-header-title">Attendance Reports</p>
                            </div>
                            <div class="column is-one-third">
                                <p class="card-header-title">
                                    <a href="{{ route('attendance_report.download') }}" class="button is-success">Download CSV</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            @include('teacher._parts.report_table')
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>

    </section>
@endsection
