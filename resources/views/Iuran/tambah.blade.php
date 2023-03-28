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

<form action="{{ route('tambah-data') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <label for="inputEmail" class="col-sm-2 col-form-label">nik</label>
        <div class="col-sm-10">
            <input type="Text" class="form-control" id="id_nik" name="id_nik" value="{{ old('id_nik') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Jenis Transaksi</label>
        <div class="col-sm-10">
            <select  class="form-control" id="jenistrx_id" name="jenistrx_id" >
                <option selected="selected" value="">Pilih</option>
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nominal</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nominaltrx" name="nominaltrx" value="{{ old('nominaltrx') }}">
        </div>
    </div>


    <div class="row mb-3">
        <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
            <button type="submit" id="pay-button" class="btn btn-primary">Submit Form</button>
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

        $(document).ready(function(){


            $("#jenistrx_id").select2({
                placeholder:'Pilih',
                ajax:{
                    url:"{{ route('get-Dana') }}",
                    processResults: function({data}){
                        return  {
                            results: $.map(data, function(item){

                                return{
                                    id: item.id,
                                    text: item.nama,

                                }
                            })
                        }
                    }
                }

            });



            $("#jenistrx_id").change(function(){
                let id = $('#jenistrx_id').val();

                $.ajax({

                    url: "{{ url('getDanaNominal') }}/" + $(this).val(),

                    success : function({data}) {
                        return  {
                            results: $.map(data, function(item){
                                $('#nominaltrx').val(item.nominal);

                            })
                        }

                    },
                    error: function(response) {
                        alert(response.responseJSON.message);
                    }
                });

            });
        });

        // $.ajax({
            //     url:"{{ url('getDanaNominal/{id}') }}/"+ id,
            //     processResults: function({data}){
                //         return  {
                    //             results: $.map(data, function(item){
                        //                 return{
                            //                     id: item.id,
                            //                     text: item.name
                            //                 }
                            //             })
                            //         }
                            //     }
                            // })




                        });


                    </script>

                    @endsection
