@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Transaction</h5>
                        <div class="container-fluidp-0 position-absolute d-flex" style="top: 1rem;right: 1rem;gap: 1rem;">
                            @can('create_transaksi')
                                <a href="/transaksi/create" class="btn btn-primary"
                                    >Create
                                    Transaction</a>
                            @endcan
                            @can('filter_transaksi')   
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  Filter By Cashier
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="max-height: 10rem;overflow: auto">
                                    <form action="/transaksi">
                                        @if (request('start'))
                                            <input type="hidden" name="start" value="{{ request('start') }}">
                                        @endif
                                        @if (request('end'))
                                            <input type="hidden" name="end" value="{{ request('end') }}">
                                        @endif
                                        <button class="dropdown-item" type="submit">All Transaction</button>
                                    </form>
                                    @foreach ($cashiers as $kasir)
                                    <li>
                                        <form action="/transaksi" method="get">
                                            @if (request('start'))
                                                <input type="hidden" name="start" value="{{ request('start') }}">
                                            @endif
                                            @if (request('end'))
                                                <input type="hidden" name="end" value="{{ request('end') }}">
                                            @endif
                                            <input type="hidden" name="kasir" value="{{ $kasir->name }}">
                                            <button class="dropdown-item {{ ($kasir->name == request('kasir')) ? 'active' : '' }}" type="submit">{{ $kasir->name }}</button>
                                        </form>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  Start Date
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="max-height: 10rem;overflow: auto">
                                    <form action="/transaksi">
                                        @if (request('kasir'))
                                            <input type="hidden" name="kasir" value="{{ request('kasir') }}">
                                        @endif
                                        @if (request('end'))
                                            <input type="hidden" name="end" value="{{ request('end') }}">
                                        @endif
                                        <button class="dropdown-item" type="submit">Remove Date</button>
                                    </form>
                                    <li>
                                        <form action="/transaksi" method="get" class="form-filter-date">
                                            @if (request('kasir'))
                                                <input type="hidden" name="kasir" value="{{ request('kasir') }}">
                                            @endif
                                            @if (request('end'))
                                                <input type="hidden" name="end" value="{{ request('end') }}">
                                            @endif
                                            <input type="date" name="start" class="dropdown-item date-filter" value="{{ (request('start') ? request('start') : '') }}">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  End Date 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="max-height: 10rem;overflow: auto">
                                    <form action="/transaksi">
                                        @if (request('kasir'))
                                            <input type="hidden" name="kasir" value="{{ request('kasir') }}">
                                        @endif
                                        @if (request('start'))
                                            <input type="hidden" name="start" value="{{ request('start') }}">
                                        @endif
                                        <button class="dropdown-item" type="submit">Remove Date</button>
                                    </form>
                                    <li>
                                        <form action="/transaksi" method="get" class="form-filter-date-end">
                                            @if (request('kasir'))
                                                <input type="hidden" name="kasir" value="{{ request('kasir') }}">
                                            @endif
                                            @if (request('start'))
                                                <input type="hidden" name="start" value="{{ request('start') }}">
                                            @endif
                                            <input type="date" name="end" class="dropdown-item date-filter-end" value="{{ (request('end') ? request('end') : '') }}">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <form action="/downloadPDF" method="get">
                                @if (request('kasir'))
                                    <input type="hidden" name="kasir" value="{{ request('kasir') }}">
                                @endif
                                @if (request('start'))
                                    <input type="hidden" name="start" value="{{ request('start') }}">
                                @endif
                                @if (request('end'))
                                    <input type="hidden" name="end" value="{{ request('end') }}">
                                @endif
                                <button type="submit" class="btn btn-primary">Export and Download PDF</button>
                            </form>
                            @endcan
                        </div>
                        <div class="table-responsive text-nowrap mt-4">
                            <table class="table text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pesanan</th>
                                        <th>Total Harga</th>
                                        <th>No Meja</th>
                                        <th>Tanggal</th>
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
                                            <td>{{ $transaksi->meja->no_meja }}</td>
                                            <td>{{ $transaksi->created_at->format('d M Y'); }}</td>
                                            @can('update_transaksi', 'delete_transaksi')
                                                <td class="d-flex justify-content-center">
                                                    <a href="/bayar/{{ $transaksi->id }}" class="btn btn-info" style="margin-right: 1rem;">Bayar</a>
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

@section('addjs')
    @can('filter_transaksi')
        <script>
            const dateFilter = document.querySelector('.date-filter');
            const formFilterDate = document.querySelector('.form-filter-date');

            const formFilterDateEnd = document.querySelector('.form-filter-date-end');
            const dateFilterEnd = document.querySelector('.date-filter-end');

            dateFilter.addEventListener('change', function(e) {
                formFilterDate.submit();
            })

            dateFilterEnd.addEventListener('change', function(){
                formFilterDateEnd.submit();
            })
        </script>
    @endcan
@endsection
