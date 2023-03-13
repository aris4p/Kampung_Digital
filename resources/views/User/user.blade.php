@extends('layouts.main')
@section('body')

@if ($mahasiswa->count())
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

      <!-- Table with hoverable rows -->
      <table class="table table-hover">
        @php
        $no=1;
        @endphp
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswa as $m)

            <tr>
                <th scope="row">{{ $no++ }}</th>
                <td>{{ $m->name }}</td>
                <td>{{ $m->username }}</td>
                <td>{{ $m->email }}</td>
          </tr>

          @endforeach
        </tbody>
      </table>
      @else
    <p class="text-center fs-4">No Data Found.. </p>
@endif
      <!-- End Table with hoverable rows -->

    </div>
  </div>
@endsection
