@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Create User</h5>
                        <form action="/user" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="name"
                                    placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" name="role" id="role" required>
                                    @foreach ($roles as $role)
                                        @if ($role != 'admin')
                                            <option value="{{ $role }}" class="text-capitalize">{{ $role }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
