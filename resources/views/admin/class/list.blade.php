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
                            <div class="column is-half">
                                <p class="card-header-title">Classes</p>
                            </div>
                            <div class="column is-one-third">
                                <p class="card-header-title">
                                    <a href="{{ route('class.create') }}" class="button is-success">Create</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="content">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><abbr title="Class">Class</abbr></th>
                                    <th><abbr title="Actions">Actions</abbr></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($classes as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td class="has-text-centered"><a href="{{ route('class.edit', $class->id) }}">Edit</a> |
                                            <form id="frm_delete" action="{{ route('class.destroy', $class->id) }}" method="POST" hidden>
                                                @method('DELETE ')
                                                @csrf
                                            </form>
                                            <a href="javascript:void(0);" onclick="triggerDelete();">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <td>
                                        <p>No Classes</p>
                                    </td>
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
    <script src="{{ asset('js/list.js')}}"></script>
@endsection
