@extends('myLayouts.main')

@section('container')
<div class="container-fluid mt-4">
    <div class="row">
        @if ( Auth::user()->hasRole('kasir') )
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body text-center">
                    <h5 class="card-title text-primary">Transaction Amount</h5>
                    <p class="card-text" style="font-size: 2rem;">{{ $jml_transaksi }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if ( Auth::user()->hasRole('manager') )
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body text-center">
                    <h5 class="card-title text-primary">Categories Amount</h5>
                    <p class="card-text" style="font-size: 2rem;">{{ $categories }}</p>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body text-center">
                    <h5 class="card-title text-primary">Menus Amount</h5>
                    <p class="card-text" style="font-size: 2rem;">{{ $menus }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if ( Auth::user()->hasRole('admin') )
            <div class="col-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body text-center">
                    <h5 class="card-title text-primary">User Amount</h5>
                    <p class="card-text" style="font-size: 2rem;">{{ $users }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>    
</div>        
@endsection