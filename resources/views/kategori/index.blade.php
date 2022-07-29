@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Category Menu</h5>
                        @can('create_kategori')
                            <button type="button" class="btn btn-primary position-absolute" data-bs-toggle="modal"
                                data-bs-target="#create" style="top: 1rem;right: 1rem;">
                                Create Category
                            </button>
                        @endcan
                        <div class="table-responsive text-nowrap mt-3">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Menu</th>
                                        @can('update_kategori', 'delete_kategori')
                                            <th>Actions</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($categories as $kategori)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-capitalize kategori-{{ $kategori->id }}">{{ $kategori->nama }}</td>
                                            @can('update_kategori', 'delete_kategori')
                                                <td class="d-flex justify-content-center">
                                                    @can('update_kategori')
                                                        <button type="button" class="btn btn-warning tombol-edit"
                                                            data-bs-toggle="modal" data-bs-target="#update" style="margin-right: 1rem;" data-id="{{ $kategori->id }}">
                                                            Update
                                                        </button>
                                                    @endcan
                                                    @can('delete_kategori')
                                                        <form action="/kategori/{{ $kategori->id }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                onclick="return confirm('Apakah anda yakin akan menghapus Kategori ini?')"
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

    <div class="modal fade" id="create" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/kategori" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Create Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama" class="form-label">Nama Category</label>
                                <input type="text" id="nama" class="form-control" placeholder="Nama Category"
                                    name="nama" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/kategori" method="POST" class="form-edit">
                    @csrf
                    @method('patch')
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Update Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama" class="form-label">Nama Category</label>
                                <input type="text" id="nama" class="form-control edit-nama"
                                    placeholder="Nama Category" name="nama" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('addjs')
    <script>
        const editNama = document.querySelector('.edit-nama');
        const formEdit = document.querySelector('.form-edit');
        const tombolEdit = document.querySelectorAll('.tombol-edit');

        tombolEdit.forEach((e,i) => {
            e.addEventListener('click', function(e){
                editNama.value = '';
                editNama.value = document.querySelector('.kategori-'+ e.target.getAttribute('data-id')).innerHTML;
                formEdit.removeAttribute('action');
                formEdit.setAttribute('action', '/kategori/' + e.target.getAttribute('data-id'))
            })
        });
    </script>
@endsection
