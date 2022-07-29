@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">User</h5>
                        @can('create_user')
                            <a href="/user/create" class="btn btn-primary position-absolute" style="top: 1rem;right: 1rem;">Create
                                User</a>
                        @endcan
                        <div class="table-responsive text-nowrap mt-3">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        @can('update_user', 'delete_user')
                                            <th>Actions</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->getRoleNames() as $role)
                                                    {{ $role }}
                                                @endforeach
                                            </td>
                                            @can('update_user', 'delete_user')
                                                <td class="d-flex justify-content-center">
                                                    @can('update_user')
                                                        <a href="/user/{{ $user->id }}/edit" class="btn btn-warning"
                                                            style="margin-right: 1rem;{{ $user->getRoleNames()[0] == 'admin' ? 'pointer-events: none;opacity: .7;' : '' }}">Update</a>
                                                    @endcan
                                                    @can('delete_user')
                                                        <form action="/user/{{ $user->id }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                onclick="return confirm('Apakah anda yakin akan menghapus user ini?')"
                                                                class="btn btn-danger "
                                                                {{ $user->getRoleNames()[0] == 'admin' ? 'disabled' : '' }}>Delete</button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
