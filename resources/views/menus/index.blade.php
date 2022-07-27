@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Menu</h5>
                        @can('create_menu')
                            <a href="/menu/create" class="btn btn-primary position-absolute" style="top: 1rem;right: 1rem;">Create
                                menu</a>
                        @endcan
                        <div class="table-responsive text-nowrap mt-3">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Menu</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        @can('update_menu', 'delete_menu')
                                            <th>Actions</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($menus as $menu)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-capitalize">{{ $menu->nama }}</td>
                                            <td class="text-capitalize">{{ $menu->kategori }}</td>
                                            <td>{{ $menu->harga }}</td>
                                            @can('update_menu', 'delete_menu')
                                                <td class="d-flex justify-content-center">
                                                    @can('update_menu')
                                                        <a href="/menu/{{ $menu->id }}/edit" class="btn btn-warning"
                                                            style="margin-right: 1rem;">Update</a>
                                                    @endcan
                                                    @can('delete_menu')
                                                        <form action="/menu/{{ $menu->id }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                onclick="return confirm('Apakah anda yakin akan menghapus menu ini?')"
                                                                class="btn btn-danger">Delete</button>
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
