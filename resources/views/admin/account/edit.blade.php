@extends('layouts.app')
@section('content')
    <section class="main-content columns is-fullheight">
        @include('admin._parts.sidebar')
        <div class="container column is-10">
            <div class="section">
                <div class="card is-hidden1">
                    <div class="card-header"><p class="card-header-title">Account &bull; Edit</p></div>
                    <div class="card-content">
                        <div class="content">
                            <form method="POST" action="{{ route('account.update', $user->id) }}">
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
                                            <label class="label">Role</label>
                                            <div class="control">
                                                <input class="input" type="text" readonly value="{{ $user->role->name }}">
                                                <sup>NOTE: Changing role is not available as of now.</sup>
                                            </div>
                                            <br>
                                            <label class="label">Username</label>
                                            <div class="control">
                                                <input class="input" type="text" name="username" value="{{ $user->username }}">
                                            </div>
                                            <label class="label">New Password</label>
                                            <div class="control">
                                                <div class="columns">
                                                    <div class="column is-three-quarters">
                                                        <input class="input" type="password" name="password" id="password">
                                                    </div>
                                                    <div class="column is-one-quarter">
                                                        <input type="checkbox" name="show_password" id="show_password">
                                                        show
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="button is-primary">
                                                Update
                                            </button>
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
    <script>
        document.addEventListener('click', function (event) {
            if (event.target.id !== 'show_password') return;

            const INPUT_PASSWORD = document.querySelector('#password');
            if (!INPUT_PASSWORD) return;

            if (event.target.checked) {
                INPUT_PASSWORD.type = 'text';
            } else {
                INPUT_PASSWORD.type = 'password';
            }
        }, false);
    </script>
@endsection
