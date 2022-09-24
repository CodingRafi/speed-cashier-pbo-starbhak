@extends('myLayouts.main')

@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col mb-4">
                <div class="card" style="min-height: 28rem;">
                    <div class="card-body">
                        <button class="btn btn-primary d-flex justify-content-center align-items-center position-absolute tambah-colom" style="top: 1rem;right: 1rem;">+ Add Menu</button>
                        <h5 class="card-title text-primary">Update Transaksi</h5>
                        
                        @foreach ($transaksi->pesanan as $pesanan)
                        <form action="/pesanan/{{ $pesanan->id }}" method="post">
                            @csrf
                            @method('patch')
                                    <div class="row row-pesanan-{{ $pesanan->id }}">
                                        <div class="col-7">
                                            <div class="mb-3">
                                                <label for="menu" class="form-label">Menu</label>
                                                <select class="form-select fstdropdown-select" name="menu_id" id="menu">
                                                    @foreach ($menus as $menu)
                                                        @if ($menu->id == $pesanan->menu_id)
                                                            <option value="{{ $menu->id }}" selected>{{ $menu->nama }}</option>
                                                        @else
                                                            <option value="{{ $menu->id }}">{{ $menu->nama }}</option>  
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="mb-3">
                                                <label for="qty" class="form-label">Qty</label>
                                                <input type="number" class="form-control" id="qty" name="jml"
                                                    placeholder="Qty" required value="{{ $pesanan->jml }}">
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center align-items-center mt-2">
                                            <div class="row d-flex">
                                                <div class="col">
                                                    <button class="btn btn-warning p-2 button-edit" data-id="1" type="submit"><i class='bx bxs-edit'></i></button>
                                                </div>
                                            
                                                <div class="col">
                                                    <button class="btn btn-danger p-2 button-hapus" data-id="1" type="button"><i class='bx bx-trash' onclick="hapusMenu({{ $pesanan->id }})"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endforeach

                        <form action="/pesanan" method="post">
                            @csrf
                            <div class="container-form">
                                <h6 class="card-subtitle mb-2 mt-4 text-muted text-primary text-to-create" style="display: none">To Create</h6>
                                <hr class="garis-hr" style="display: none">
                                <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">
                            </div>
                            <button type="submit" class="btn btn-primary button-new-add-Menu" style="display: none;">Add Menu</button>
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
        let buttonHapusKe = 1;

        tambahColom.addEventListener('click', function(){
            // const containerInput = document.createElement("div");
            // containerInput.setAttribute('class', `row container-input-${buttonHapusKe}`);
            // containerForm.appendChild(containerInput);

            if(buttonHapusKe == 1){
                document.querySelector('.text-to-create').style.display = 'block';
                document.querySelector('.garis-hr').style.display = 'block';
                document.querySelector('.button-new-add-Menu').style.display = 'block';
            }

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

        function hapusMenu(id){
            if(confirm('Apakah anda yakin akan menghapus menu ini?')){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/pesanan/' + id,
                    dataType: 'json',
                    type: 'DELETE',
                    data: {
                        _method: 'delete',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        document.querySelector('.row-pesanan-' + id).innerHTML = '';
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            }
        }

    </script>
@endsection
