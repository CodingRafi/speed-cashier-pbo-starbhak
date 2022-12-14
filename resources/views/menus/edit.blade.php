@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Update Menu</h5>
                        <form action="/menu/{{ $menu->id }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Menu</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Nama Menu" required value="{{ $menu->nama }}">
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga"
                                    required value="{{ $menu->harga }}">
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori_id" id="kategori">
                                    @foreach ($categories as $kategori)
                                        @if ($kategori->id == $menu->kategori_id)
                                            <option value="{{ $kategori->id }}" class="text-capitalize" selected>
                                                {{ $kategori->nama }}</option>
                                        @else
                                            <option value="{{ $kategori->id }}" class="text-capitalize">
                                                {{ $kategori->nama }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Menu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
