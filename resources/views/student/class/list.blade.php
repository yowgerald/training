@extends('layouts.app')
@section('content')
    <section class="main-content columns is-fullheight">
        @include('student._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                <div class="card is-hidden1">
                    <div class="card-header"><p class="card-header-title">Classes</p></div>
                    <div class="card-content">
                        <div class="content">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><abbr title="Class">Class</abbr></th>
                                    <th><abbr title="Period">Period</abbr></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($classes as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td class="has-text-centered">{{ date("H:i A", $class->period_start) . ' - ' . date("H:i A", $class->period_end) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No classes found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>

    </section>
@endsection
