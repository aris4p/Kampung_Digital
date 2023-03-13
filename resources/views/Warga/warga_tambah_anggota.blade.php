@extends('layouts.main')
@section('body')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Tambah Anggota Keluarga</h5>

        <table class="table">

            <tr>
                <td>Nama</td>
                <td>Email</td>
            </tr>
            @foreach ($result['rajaongkir']['results'] as $req)
            <tr>
                <td>{{ $req['province_id'] }}</td>
                <td>{{ $req['province'] }}</td>
            </tr>
            @endforeach
        </table>

    </div>
  </div>
@endsection
