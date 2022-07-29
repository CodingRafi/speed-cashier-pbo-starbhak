@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Transaction</h5>
                        @can('create_transaksi')
                            <a href="/transaksi/create" class="btn btn-primary position-absolute"
                                style="top: 1rem;right: 1rem;">Create
                                Transaction</a>
                        @endcan
                        <div class="table-responsive text-nowrap mt-3">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pesanan</th>
                                        <th>Total Harga</th>
                                        @can('update_transaksi', 'delete_transaksi')
                                            <th>Actions</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($transaksis as $transaksi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <table class="table table-bordered">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th scope="col" style="color: #fff">#</th>
                                                            <th scope="col" style="color: #fff">Nama</th>
                                                            <th scope="col" style="color: #fff">QTY</th>
                                                            <th scope="col" style="color: #fff">Sub Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($transaksi->pesanan as $pesanan)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $pesanan->menu->nama }}</td>
                                                                <td>{{ $pesanan->jml }}</td>
                                                                <td>Rp. {{ $pesanan->total_harga }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>Rp. {{ $transaksi->total_harga }}</td>
                                            @can('update_transaksi', 'delete_transaksi')
                                                <td class="d-flex justify-content-center">
                                                    @can('update_transaksi')
                                                        <a href="/transaksi/{{ $transaksi->id }}/edit" class="btn btn-warning" style="margin-right: 1rem;">Update</a>
                                                    @endcan
                                                    @can('delete_transaksi')
                                                        <form action="/transaksi/{{ $transaksi->id }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                onclick="return confirm('Apakah anda yakin akan menghapus transaksi ini?')"
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
