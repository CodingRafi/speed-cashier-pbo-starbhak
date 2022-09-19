<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Register Restoran</title>
  </head>
  <body>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card col-lg-6" style="box-shadow: 0px 0px 10px rgb(220, 220, 220); margin: 50px;">
            <div class="card-body">
                <h4 class="card-title">Register Restoran</h4>
                <hr>
                <div class="mt-3 mb-3">
                    <label for="namaRestoran" class="form-label">Nama Restoran</label>
                    <input type="text" class="form-control" name="namaRestoran" id="namaRestoran" placeholder="Masukan nama restoran">
                </div>
                <div class="mt-3 mb-3">
                    <label for="namaPemilik" class="form-label">Nama Pemilik</label>
                    <input type="text" class="form-control" name="namaPemilik" id="namaPemilik" placeholder="Masukan nama pemilik">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                </div>
                <div class="mb-3">
                    <label for="kota" class="form-label">Kota</label>
                    <select class="form-control" name="" id="">
                        <option value="">Pilih kota</option>
                        <option value="">Jakarta</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamat"></textarea>
                </div>
                <div class="tombol">
                    <button class="btn text-white d-block" style="background-color: #696cff; margin: auto;">Register</button>
                    <span class="d-block m-2 text-center"><a href="">Already have account? back to login</a></span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>