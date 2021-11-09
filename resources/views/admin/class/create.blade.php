@extends('layouts.app')
@section('content')
    <section class="main-content columns is-fullheight">
        @include('admin._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                <div class="card is-hidden1">
                    <div class="card-header"><p class="card-header-title">Class &bull; Create</p></div>
                    <div class="card-content">
                        <div class="content">
                            <form method="POST" action="{{ route('class.store') }}">
                                @csrf
                                <div class="field">
                                    <div class="columns">
                                        <div class="columnå is-half">
                                            @if($errors->any())
                                                <div class="notification is-danger">
                                                    @foreach($errors->all() as $error)
                                                        {{ $error }}<br/>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <label class="label">Class Name</label>
                                            <div class="control">
                                                <input class="input" type="text" name="name">
                                            </div>
                                            <br/>
                                            <button class="button is-primary">Create</button>
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
