@extends('layouts.main')

@section('body')

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
        <table id="datatables" class="table table-striped" style="width:100%" >
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
            {{-- <tbody>
                @foreach ($warga as $d)

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
                        <a href="{{ route ('warga-delete', ['id'=>$d->id]) }}" onclick="return confirm('Apakah yakin ingin menghapus?')" class="btn btn-sm btn-danger">Hapus</a>
                        <a href="{{ route ('warga-detail', ['id'=>$d->id]) }}" class="btn btn-sm btn-warning">Detail</a>

                    </td>
                </tr>


                @endforeach
            </tbody> --}}
        </table>

        <!-- End Table with hoverable rows -->

    </div>
</div>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link href="//cdn.datatables.net/1.13.3/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="//cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.bootstrap.min.css" rel="stylesheet" />
<link href="//cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap.min.css" rel="stylesheet" />


{{-- DataTables --}}
<script type="text/javascript" src="//code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.13.3/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>







<script type="text/javascript">
    $(document).ready(function () {
        $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ url()->current() }}',
            columns: [

            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'alamat', name: 'alamat' },
            { data: 'jeniskelamin', name: 'jeniskelamin' },
            { data: 'nohp', name: 'nohp' },
            { data: 'action', name: 'action', orderable: true, searchable: true },


            ]
        });
        //  new $.fn.dataTable.FixedHeader( table );
    });
</script>

@endsection
