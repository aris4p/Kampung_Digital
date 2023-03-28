@extends('layouts.main')
@section('body')
<section class="section profile">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    @if ($warga->jeniskelamin == 1)

                    @if ($warga->image)
                    <img src="{{asset ('foto-profil/'.$warga->image) }}" alt="Profile" class="rounded-circle">
                    @else
                    <img src="{{asset ('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    @endif
                    @else
                    @if ($warga->image)

                    <img src="{{asset ('foto-profil/'.$warga->image) }}" alt="Profile" class="rounded-circle">
                    @else
                    <img src="{{asset ('assets/img/messages-1.jpg') }}" alt="Profile" class="rounded-circle">

                    @endif

                    @endif

                    <h2>{{ $warga->nama }}</h2>
                    @if ($warga->status == 1)

                    <h3>Kepala Keluarga</h3>
                    <a href="{{ route('anggota-tambah') }}" class="btn btn-primary mb-3"> Tambah Anggota Keluarga </a>
                    @else
                    <h3>Anggota Keluarga</h3>
                    @endif
                    <a href="{{ route('warga-edit', ['id'=> $warga->id]) }}" class="btn btn-primary mb-3"> Edit </a>
                    {{-- <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div> --}}
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" id="tabMenu">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Tagihan-overview">Tagihan</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade active show profile-overview" id="profile-overview">
                            {{-- <h5 class="card-title">About</h5>
                            <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> --}}

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                                <div class="col-lg-9 col-md-8">{{ $warga->nama }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">NIK</div>
                                <div class="col-lg-9 col-md-8">{{ $warga->nik }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
                                <div class="col-lg-9 col-md-8">{{ $parseTgl }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                                @if ( $warga->jeniskelamin == 1 )
                                <div class="col-lg-9 col-md-8">Laki-Laki</div>
                                @else
                                <div class="col-lg-9 col-md-8">Perempuan</div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Alamat</div>
                                <div class="col-lg-9 col-md-8">{{ $warga->alamat }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Provinsi</div>
                                <div class="col-lg-9 col-md-8">{{ $provinsi->province->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Kabupaten/Kota</div>
                                <div class="col-lg-9 col-md-8">{{ $kota->regency->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Kecamatan</div>
                                <div class="col-lg-9 col-md-8">{{ $kecamatan->district->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Kelurahan/Desa</div>
                                <div class="col-lg-9 col-md-8">{{ $kelurahan->village->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Handphone</div>
                                <div class="col-lg-9 col-md-8">{{ $warga->nohp }}</div>
                            </div>


                        </div>


                    </div><!-- End Bordered Tabs -->

                    <div class="tab-content pt-2">

                        <div class="tab-pane fade active show profile-overview" id="Tagihan-overview">
                            {{-- <h5 class="card-title">About</h5>
                            <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> --}}

                            <h5 class="card-title">Tagihan</h5>

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">TRX ID</th>
                                        <th scope="col">Jenis Trx</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach ($map as $value)
                                    <tr>
                                        <th scope="row">{{ $no++ }}</th>
                                        <td>{{ $value['idtrx'] }}</td>
                                        <td>{{ $value['jenistrx'] }}</td>
                                        @if ($value['statustrx']  === "pending")
                                        <td>
                                            <a href="{{ route('datawarga') }}" class="btn btn-warning">Belum Bayar</a>
                                        </td>
                                        @else
                                        <td>
                                            <span class="btn btn-success">Sudah Bayar</span>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>


                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>

</section>
@endsection
