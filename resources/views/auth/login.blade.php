@extends('layouts.app')
@section('content')
    <section class="section">
        <div class="container">
            <div class="columns is-centered">
                <div class="column is-one-third">
                    <div class="columns is-centered">
                        <div class="column is-one-third">
                            <div class="title is-3">Login</div>
                        </div>
                    </div>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        @if($errors->has('username'))
                            <div class="notification is-danger">
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                        <div class="field">
                            <label class="label">Username</label>
                            <div class="control">
                                <input class="input" type="text" name="username">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input class="input" type="password" name="password">
                            </div>
                        </div>
                        <button class="button is-primary" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
