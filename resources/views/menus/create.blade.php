@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Create Menu</h5>
                        <form action="/menu" method="post">
                            @csrf
                            @if (count($categories) > 0)
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Menu</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Nama Menu" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori_id" id="kategori">
                                    @foreach ($categories as $kategori)
                                        <option value="{{ $kategori->id }}" class="text-capitalize">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Menu</button>
                            @else
                            <div class="container d-flex mt-5 justify-content-center align-items-center">
                                <div class="alert alert-primary" role="alert">
                                    Maaf, Tidak ada Kategori tersedia
                                  </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
