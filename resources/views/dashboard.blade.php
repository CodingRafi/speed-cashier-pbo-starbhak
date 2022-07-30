@extends('myLayouts.main')

@section('container')
<div class="container-fluid mt-4">
    <div class="row" style="flex-wrap: wrap">
        <div class="col-8">
            <div class="row">
                @if ( Auth::user()->hasRole('kasir') )
                    <div class="col-6">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body text-center">
                            <h5 class="card-title text-primary">Transaction Amount</h5>
                            <p class="card-text" style="font-size: 2rem;">{{ $jml_transaksi }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ( Auth::user()->hasRole('manager') )
                    <div class="col-6">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body text-center">
                            <h5 class="card-title text-primary">Categories Amount</h5>
                            <p class="card-text" style="font-size: 2rem;">{{ $categories }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body text-center">
                            <h5 class="card-title text-primary">Menus Amount</h5>
                            <p class="card-text" style="font-size: 2rem;">{{ $menus }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ( Auth::user()->hasRole('admin') )
                    <div class="col-6">
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
        <div class="col-4">
            @if ( Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager') )
            <div class="card" style="width: 18rem;">
                <div class="card-body" style="height: 30rem;overflow: auto">
                  <h4 class="card-title">Log Pengguna</h4>
                  @foreach ($logs as $log)  
                  <div class="card mt-3 mb-3">
                    <div class="card-body p-3">
                        <p class="m-0 p-0" style="font-weight: 700">{{ $log->message }}</p>
                        <p class="m-0 mt-1">Pengubah: {{ $log->user->name }}</p>
                    </div>
                  </div>
                  @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>    
</div>        
@endsection