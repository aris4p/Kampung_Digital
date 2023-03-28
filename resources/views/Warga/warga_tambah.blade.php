@extends('layouts.main')
@section('body')

<div class="card">
    <div class="card-body">
      <h5 class="card-title">Tambah Data Warga</h5>

        @include('partials.pesanerror')
      <!-- General Form Elements -->
      <form action="{{ route('warga-tambah') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
          </div>
        </div>
        <div class="row mb-3">
          <label for="inputEmail" class="col-sm-2 col-form-label">Nik</label>
          <div class="col-sm-10">
            <input type="Text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
          </div>
        </div>

        <div class="row mb-3">
          <label for="tglLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
          <div class="col-sm-10">
            <input type="date" class="form-control" id="tglLahir" name="tglLahir" value="{{ old('tglLahir') }}">
          </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
              <select class="form-select" id="jeniskelamin" name="jeniskelamin" aria-label="Default select example">
                <option value="">Pilih</option>
                <option value="1" @if (old('jeniskelamin') == "1") {{ 'selected' }} @endif>Laki-Laki</option>
                <option value="2" @if (old('jeniskelamin') == "2") {{ 'selected' }} @endif>Perempuan</option>
              </select>
            </div>
          </div>

        <div class="row mb-3">
          <label for="inputNumber" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <textarea  id="alamat" name="alamat" rows="5" cols="5" class="form-control" value="{{ old('alamat') }}"></textarea>
          </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Provinsi</label>
            <div class="col-sm-10">
                <select class="form-select" id="provinsi" name="provinsi_id" aria-label="Default select example">
                    <option selected="selected" value="">Pilih Provinsi</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Kota/Kabupaten</label>
            <div class="col-sm-10">
                <select class="form-select" id="kota" name="kota_id" aria-label="Default select example">
                    <option value="">Pilih Kabupaten/Kota</option>
                </select>
            </div>
        </div>

         <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Kecamatan</label>
            <div class="col-sm-10">
                <select class="form-select" id="kecamatan" name="kecamatan_id" aria-label="Default select example">
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Kelurahan/Desa</label>
            <div class="col-sm-10">
                <select class="form-select" id="kelurahan" name="kelurahan_id" aria-label="Default select example">
                    <option value="">Pilih Kelurahan/Desa</option>
                </select>
            </div>
        </div>

    <div class="row mb-3">
      <label for="inputNumber" class="col-sm-2 col-form-label">No Hp</label>
      <div class="col-sm-10">
        <input class="form-control" id="nohp" name="nohp" type="text"  value="{{ old('nohp') }}">
      </div>
    </div>

     <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-10">
              <select class="form-select" id="status" name="status" aria-label="Default select example">
                <option value="">Pilih</option>
                <option value="1" @if (old('status') == "1") {{ 'selected' }} @endif>Kepala Keluarga</option>
                <option value="2" @if (old('status') == "2") {{ 'selected' }} @endif>Anggota Keluarga</option>
              </select>
            </div>
          </div>

    <div class="row mb-3">
        <label for="image" class="col-sm-2 col-form-label">Upload Gambar</label>
        <div class="col-sm-10">
            <input  class="form-control mb-5" type="file" id="image" name="image" onchange="previewImage()">

            <img class="img-preview img-fluid mb-3 col-sm-2" alt="">
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
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>


    $(function(){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

     $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
      });

    $(document).ready(function(){

        $("#provinsi").select2({
            placeholder:'Pilih Provinsi',
            ajax:{
                url:"{{ route('selectProv') }}",
                processResults: function({data}){
                    return  {
                        results: $.map(data, function(item){
                            return{
                               id: item.id,
                               text: item.name
                             }
                        })
                    }
                }
            }

    });

        $("#provinsi").change(function(){
            let id = $('#provinsi').val();

            $("#kota").select2({
            placeholder:'Pilih Kota/Kabupaten',
            ajax:{
                url:"{{ url('selectKota') }}/"+ id,
                processResults: function({data}){
                    return  {
                        results: $.map(data, function(item){
                            return{
                               id: item.id,
                               text: item.name
                             }
                        })
                    }
                }
            }
        });
         });


        $("#kota").change(function(){
            let id = $('#kota').val();

            $("#kecamatan").select2({
            placeholder:'Pilih Kecamatan',
            ajax:{
                url:"{{ url('selectKecamatan') }}/"+ id,
                processResults: function({data}){
                    return  {
                        results: $.map(data, function(item){
                            return{
                               id: item.id,
                               text: item.name
                             }
                        })
                    }
                }
            }
        });
      });

       $("#kecamatan").change(function(){
            let id = $('#kecamatan').val();

            $("#kelurahan").select2({
            placeholder:'Pilih Kelurahan/Desa',
            ajax:{
                url:"{{ url('selectKelurahan') }}/"+ id,
                processResults: function({data}){
                    return  {
                        results: $.map(data, function(item){
                            return{
                               id: item.id,
                               text: item.name
                             }
                        })
                    }
                }
            }
        });
      });

    });

});

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
