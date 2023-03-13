@extends('layouts.main')
@section('body')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Detail Data Warga</h5>
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
       @include('partials.pesanerror')
      <!-- General Form Elements -->
      <form action="{{ route('warga-update', ['id' => $warga->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Nama Lengkap</label>
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
          <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" id="tglLahir" name="tglLahir" value="{{ $warga->tglLahir }}">
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
          <label for="inputNumber" class="col-sm-2 col-form-label">Provinsi</label>
          <div class="col-sm-10">
            <input type="text" id="provinsi" name="provinsi" class="form-control" disabled value="{{$warga->province->name}} ">

        </div>
        </div>

        <div class="row mb-3">
          <label for="inputNumber" class="col-sm-2 col-form-label">Kabupaten/Kota</label>
          <div class="col-sm-10">
            <input type="text" id="kota" name="kota" class="form-control" disabled value="{{ $warga->regency->name }}">
          </div>
        </div>

        <div class="row mb-3">
          <label for="inputNumber" class="col-sm-2 col-form-label">Kecamatan</label>
          <div class="col-sm-10">
            <input type="text" id="kecamatan" name="kecamatan" class="form-control" disabled value="{{ $warga->district->name }}">
          </div>
        </div>

        <div class="row mb-3">
          <label for="inputNumber" class="col-sm-2 col-form-label">Kelurahan</label>
          <div class="col-sm-10">
            <input type="text" id="kelurahan" name="kelurahan" class="form-control" disabled value="{{ $warga->village->name }}">
          </div>
        </div>


        <div class="row mb-3">
          <label for="inputNumber" class="col-sm-2 col-form-label">No Hp</label>
          <div class="col-sm-10">
            <input class="form-control" id="nohp" name="nohp" type="text" value="{{ $warga->nohp }}" >
          </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
              <select class="form-select" id="status" name="status" aria-label="Default select example">
                <option value="">Pilih</option>
                <option value="1" {{ ($warga->status == '1' ? "selected='selected'" : "") }}>Kepala Keluarga</option>
                <option value="2" {{ ($warga->status == '2' ? "selected='selected'" : "") }}>Anggota Keluarga</option>
              </select>
            </div>
          </div>

        <div class="row mb-3">
        <label for="image" class="col-sm-2 col-form-label">Upload Gambar</label>
            <div class="col-sm-10">
                <input  class="form-control mb-3" type="file" id="image" name="image" onchange="previewImage()">

                <img class="img-preview img-fluid mb-3 col-sm-2" alt="">
            </div>
        </div>



        <div class="row mb-3">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Update Data</button>
          </div>
        </div>

      </form><!-- End General Form Elements -->

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

  <script>
  function previewImage(){
        const image =   document.querySelector('#image');
        const imgPreview   = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();

        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
    }
  </script>

@endsection
