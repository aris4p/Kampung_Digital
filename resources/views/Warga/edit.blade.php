@extends('layouts.main')
@section('body')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Data Warga</h5>
          <!-- Notifikasi menggunakan flash session data -->
          {{-- @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
          @endif

          @if (session('error'))
          <div class="alert alert-error">
              {{ session('error') }}
          </div>
          @endif --}}

      <!-- General Form Elements -->
      <form action="{{ route('warga-update', ['id' => $warga->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $warga->nama }}">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputEmail" class="col-sm-2 col-form-label">Nik</label>
          <div class="col-sm-10">
            <input type="Text" class="form-control" id="nik" name="nik" value="{{ $warga->nik }}">
          </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
              <select class="form-select" id="jeniskelamin" name="jeniskelamin" aria-label="Default select example">
                <option selected="">Pilih</option>
                <option {{ ($warga->jeniskelamin == '1' ? "selected='selected'" : "") }} value="1">Laki-Laki</option>
                <option {{ ($warga->jeniskelamin == '2' ? "selected='selected'" : "") }} value="2">Perempuan</option>
              </select>
            </div>
          </div>

        <div class="row mb-3">
          <label for="inputNumber" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <input type="text" id="alamat" name="alamat" class="form-control" value="{{ $warga->alamat }}">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputNumber" class="col-sm-2 col-form-label">No Hp</label>
          <div class="col-sm-10">
            <input class="form-control" id="nohp" name="nohp" type="text" value="{{ $warga->nohp }}" >
          </div>
        </div>



        <div class="row mb-3">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Submit Form</button>
          </div>
        </div>

      </form><!-- End General Form Elements -->

    </div>
  </div>
@endsection

