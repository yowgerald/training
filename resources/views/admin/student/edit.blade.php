@extends('layouts.app')
@section('content')
    <section class="main-content columns is-fullheight">
        @include('admin._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                <div class="card is-hidden1">
                    <div class="card-header"><p class="card-header-title">Student &bull; Edit</p></div>
                    <div class="card-content">
                        <div class="content">
                            <form action="{{ route('student.update', $student->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="field">
                                    <div class="columns">
                                        <div class="column is-half">
                                            @if($errors->any())
                                                <div class="notification is-danger">
                                                    @foreach($errors->all() as $error)
                                                        {{ $error }}<br/>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <label class="label">Student ID</label>
                                            <div class="control">
                                                <input class="input" type="text" name="physical_id" value="{{ $student->padded_physical_id }}">
                                            </div>
                                            <label class="label">First Name</label>
                                            <div class="control">
                                                <input class="input" type="text" name="first_name" value="{{ $student->first_name }}">
                                            </div>
                                            <label class="label">last Name</label>
                                            <div class="control">
                                                <input class="input" type="text" name="last_name" value="{{ $student->last_name }}">
                                            </div>
                                            <br/>
                                            <button class="button is-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>

    </section>
@endsection
