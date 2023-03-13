@extends('layouts.main')
@section('body')

{{-- @if ({{ title }}) --}}
<div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Data Warga</h5>
      <a href="/datawarga/tambah" class="btn btn-primary mb-3"> Tambah data warga </a>
      @if ($message = Session::get('Success') )
      <div class="alert alert-success alert-block">
        <strong>{{ $message }}</strong>
        </div>
  @endif

      <!-- Table with hoverable rows -->
      <table class="table table-hover">
        @php
        $no=1;
        @endphp
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">No HP</th>
            <th scope="col">Aksi</th>

        </tr>
        </thead>
        <tbody>
            {{-- @foreach ($warga as $d)

            <tr>
                <th scope="row">{{ $no++ }}</th>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->alamat }}</td>
                @if ($d->jeniskelamin == '1')
                <td> Laki-Laki</td>
                @elseif ($d->jeniskelamin == '2')
                <td> Perempuan </td>
                @endif
                <td>{{ $d->nohp }}</td>

                <td>
                <a href="{{ route ('warga-detail', ['id'=>$d->id]) }}" class="btn btn-sm btn-warning">Detail</a>
                <a href="{{ route ('warga-delete', ['id'=>$d->id]) }}" onclick="return confirm('Apakah yakin ingin menghapus?')" class="btn btn-sm btn-danger">Hapus</a>

            </td>
        </tr>


        @endforeach --}}
    </tbody>
</table>
      {{-- @else
    <p class="text-center fs-4">No Data Found.. </p>
@endif --}}
      <!-- End Table with hoverable rows -->

    </div>
  </div>
@endsection
