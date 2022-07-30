<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />

	<style>
		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
			text-align: center
		}
	</style>

	<title>Laporan Penjualan</title>
</head>

<body>
	<div class="container mt-4 p-0">
		<h2 class="text-center">Laporan Pendapatan Speed Cashier</h1>
			<table class="table table-bordered text-center">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Pesanan</th>
						<th scope="col">Total Harga</th>
						<th scope="col">Tanggal</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($transaksis as $transaksi)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td style="padding: 5px;">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nama</th>
										<th scope="col">QTY</th>
										<th scope="col">Sub Total</th>
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
						<td>{{ $transaksi->created_at->format('d M Y') }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
		</script>
</body>

</html>