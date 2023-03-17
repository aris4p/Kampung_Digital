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

<form action="{{ route('payment') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <label for="inputEmail" class="col-sm-2 col-form-label">nik</label>
        <div class="col-sm-10">
            <input type="Text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Jenis Transaksi</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenistrx" name="jenistrx" value="{{ old('jenistrx') }}">
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

@endsection
