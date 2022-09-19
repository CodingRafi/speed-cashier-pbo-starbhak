@extends('mylayouts.main')

@section('container')
<div class="card m-4">
    <h5 class="card-header">Data Meja</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr class="text-center">
                <th>No</th>
                <th>Nomor Meja</th>
                <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <tr class="text-center">
                <td><strong>1</strong></td>
                <td>1</td>
                <td>Isi</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection