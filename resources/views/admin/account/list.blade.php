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
                            <div class="column is-full">
                                <p class="card-header-title">Manage Accounts</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><abbr title="Username">Username</abbr></th>
                                    <th><abbr title="Role">Role</abbr></th>
                                    <th><abbr title="Actions">Action</abbr></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td class="has-text-centered">{{ $user->role->name }}</td>
                                        <td class="has-text-centered">
                                            <a href="{{ route('account.edit', $user->id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <td>
                                        <p>No Users</p>
                                    </td>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $users->links('custom.pagination') }}
                        </div>
                    </div>
                </div>
                <br />
            </div>
        </div>
    </section>
@endsection
