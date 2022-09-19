@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        @if (count($menus) > 0)
                        <button class="btn btn-primary d-flex justify-content-center align-items-center p-0 position-absolute tambah-colom" style="border-radius: 50%;width: 2rem;height: 2rem;top: 1rem;right: 1rem;">+</button>
                        @endif 
                        <h5 class="card-title text-primary">Create Transaction</h5>
                        <form action="/transaksi" method="post">
                            @csrf
                            @if (count($menus) > 0) 
                                @if (count($mejas) > 0)   
                                <div class="container-form">
                                    <div class="row container-input-1">
                                        <div class="col-8">
                                            <div class="mb-3">
                                                <label for="menu" class="form-label">Menu</label>
                                                <select class="form-select fstdropdown-select" name="menu_id[]" id="menu">
                                                    @foreach ($menus as $menu)
                                                        <option value="{{ $menu->id }}">{{ $menu->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="qty" class="form-label">Qty</label>
                                                <input type="number" class="form-control" id="qty" name="jml[]"
                                                    placeholder="Qty" required>
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center align-items-center mt-2">
                                            <button class="btn btn-danger p-1 button-hapus" data-id="1" type="button" onclick="hapusInput(1)"><i class='bx bx-trash'></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Meja</label>
                                        <select class="form-select" aria-label="Default select example" name="meja_id">
                                            @foreach ($mejas as $meja)
                                            <option value="{{ $meja->id }}">{{ $meja->no_meja }}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Transaction</button>
                                @else
                                <div class="container d-flex mt-5 justify-content-center align-items-center">
                                    <div class="alert alert-primary" role="alert">
                                        Maaf, Tidak ada meja tersedia
                                      </div>
                                </div>
                                @endif
                            @else
                            <div class="container d-flex mt-5 justify-content-center align-items-center">
                                <div class="alert alert-primary" role="alert">
                                    Maaf, Tidak ada menu tersedia
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

@section('addjs')
    <script>
        const tambahColom = document.querySelector('.tambah-colom');
        const containerForm = document.querySelector('.container-form');
        let buttonHapus = document.querySelectorAll('.button-hapus');
        let buttonHapusKe = 2;

        tambahColom.addEventListener('click', function(){
            // const containerInput = document.createElement("div");
            // containerInput.setAttribute('class', `row container-input-${buttonHapusKe}`);
            // containerForm.appendChild(containerInput);

            containerForm.innerHTML +=  `<div class="row container-input-${buttonHapusKe}">
                                    <div class="col-8">
                                        <div class="mb-3">
                                            <label for="menu" class="form-label">Menu</label>
                                            <select class="form-select fstdropdown-select" name="menu_id[]" id="menu">
                                                @foreach ($menus as $menu)
                                                    <option value="{{ $menu->id }}">{{ $menu->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="qty" class="form-label">Qty</label>
                                            <input type="number" class="form-control" id="qty" name="jml[]"
                                                placeholder="Qty" required>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center align-items-center mt-2">
                                        <button class="btn btn-danger p-1 button-hapus" data-id="${buttonHapusKe}" type="button" onclick="hapusInput(${buttonHapusKe})"><i class='bx bx-trash'></i></button>
                                    </div>
                                </div>`;

                                buttonHapusKe++;
                                buttonHapus = document.querySelectorAll('.button-hapus');
        })
        
        function hapusInput(i){
            document.querySelector('.container-input-' + i).innerHTML = '';
        }

    </script>
@endsection
