<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Warga;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class WargaController extends Controller
{
    public function index(){

       if (request()->ajax()) {
            $wargas = Warga::latest();
            return DataTables::of($wargas)
                ->addIndexColumn()
                ->editColumn('jeniskelamin', function($wargas){
                    if ($wargas->jeniskelamin == 1) return 'Laki-Laki';
                    return 'Perempuan';
                })
                ->addColumn('action', function($wargas){

                    $button = '<a href="'. route ('warga-detail', ['id'=>$wargas->id]) .'" class="btn btn-sm btn-warning">Detail</a> ';
                    $button .= '<a href="'. route ('warga-delete', ['id'=>$wargas->id]) .'"  class="btn btn-sm btn-danger">Hapus</a>';

                            return $button;
                })
                ->make(true);
        }

        return view('Warga.warga', [
            "title" => "Data Warga"
            ]);
        }




        public function detailwarga($id){
            $warga = Warga::where('id',$id)->first();
            $parseTgl = Carbon::parse($warga->tglLahir)->translatedFormat('l, d F Y');
            // dd($warga);
            $provinsi = Warga::with("province")->first($id);
            dd($provinsi);
            $kota = Warga::with("regency")->find($id);
            $kecamatan = Warga::with("district")->find($id);
            $kelurahan = Warga::with("village")->find($id);
            // dd($wilayah);
            // dd($provinces);
            // dd($warga);
            return view('Warga.warga_detail', [
                'warga' => $warga,
                'parseTgl' => $parseTgl,
                'provinsi' => $provinsi,
                'kota'  => $kota,
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
                "title" => "Data Warga"
            ]);
        }


        public function tambah(){
            return view ('Warga.warga_tambah', [
                "title" => "Tambah Data Warga"
            ]);
        }


        public function selectProv(){
            $data = Province::where('name','LIKE','%'.request('q').'%')->paginate(10);

            return response()->json($data);
        }

        public function selectKota($id){

            $data = Regency::where('province_id',$id)->where('name','LIKE','%'.request('q').'%')->paginate(10);

            return response()->json($data);
        }

        public function selectKecamatan($id){

            $data = District::where('regency_id',$id)->where('name','LIKE','%'.request('q').'%')->paginate(10);

            return response()->json($data);
        }

        public function selectKelurahan($id){

            $data = Village::where('district_id',$id)->where('name','LIKE','%'.request('q').'%')->paginate(10);

            return response()->json($data);
        }


        public function store(Request $request){

            #cara 1
            // $validatedData = $request->validate([
                // 'nama'  => 'required',
                // 'nik'  => 'required',
                // 'tglLahir'  => 'required',
                // 'provinsi_id'  => 'required',
                // 'kota_id'  => 'required',
                // 'kecamatan_id'  => 'required',
                // 'kelurahan_id'  => 'required',
                // 'alamat'  => 'required',
                // 'jeniskelamin'  => 'required',
                // 'nohp'  => 'required',
                // 'status' => 'required',
                // 'image'  => 'file|image|mimes:jpeg,png,jpg|max:2048'
                //     ]);

                //     if($request->file('image')){
                    //         $ext = $request->file('image')->getClientOriginalExtension();
                    //         $namaBaru = $request->nama.'-'.now()->timestamp.'.'.$ext;
                    //         $validatedData['image'] = $request->file('image')->storeAs('foto-profil', $namaBaru);
                    //     }

                    // Warga::create($validatedData);

                    #cara 2
                    // $nama   = $request->input('nama');
                    // $nik    = $request->input('nik');
                    // $tglLahir = $request->input('tglLahir');
                    // $provinsi = $request->input('provinsi');
                    // $kota   = $request->input('kota');
                    // $kecamatan = $request->input('kecamatan');
                    // $kelurahan  = $request->input('kelurahan');
                    // $alamat = $request->input('alamat');
                    // $jeniskelamin   = $request->input('jeniskelamin');
                    // $nohp   = $request->input('nohp');
                    // $status   = $request->input('status');

                    // $image = time().'.'.$request->image->getClientOriginalExtension();

                    // $request->image->move(public_path('assets/img'), $image);



                    // Warga::create(['nama'   =>  $nama,
                    //                'nik'    =>  $nik,
                    //                'tglLahir' => $tglLahir,
                    //                'provinsi_id' =>$provinsi,
                    //                'kota_id' =>$kota,
                    //                'kecamatan_id' =>$kecamatan,
                    //                'kelurahan_id' =>$kelurahan,
                    //                'alamat' =>  $alamat,
                    //                'jeniskelamin'   =>  $jeniskelamin,
                    //                'nohp'   =>  $nohp,
                    //                'status' => $status,
                    //                'file'   =>  $image

                    //             ]);

                    #cara 3
                    Session::flash('provinsi_id',$request->provinsi_id);

                    $request->validate([
                        'nama'  => 'required',
                        'nik'  => 'required|numeric',
                        'tglLahir'  => 'required',
                        'jeniskelamin'  => 'required',
                        'provinsi_id'  => 'required',
                        'kota_id'  => 'required',
                        'kecamatan_id'  => 'required',
                        'kelurahan_id'  => 'required',
                        'alamat'  => 'required',
                        'nohp'  => 'required',
                        'status' => 'required',
                        'image'  => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
                    ],[
                        'nama.required'=>'Nama Wajib Diisi',
                        'nik.required'=>'NIK Wajib Diisi',
                        'nik.numeric'=>'NIK Hanya Menggunakan Angka',
                        'tglLahir.required'=>'Tanggal Lahir Wajib Diisi',
                        'jeniskelamin.required'=>'Jenis Kelamin Wajib Diisi',
                        'provinsi_id.required'=>'Provinsi Wajib Diisi',
                        'kota_id.required'=>'Kota Wajib Diisi',
                        'kecamatan_id.required'=>'Kecamatan Wajib Diisi',
                        'kelurahan_id.required'=>'Kelurahan Wajib Diisi',
                        'alamat.required'=>'Alamat Wajib Diisi',
                        'nohp.required'=>'No Handphone Wajib Diisi',
                        'status.required'=>'Status Wajib Diisi',
                        'image.required'=>'Foto Wajib Diisi'

                    ]);

                    $image_file = $request->file('image');
                    $image_extension = $image_file->extension();
                    $image_name = date('ymdhis').".".$image_extension;
                    $image_file->move(public_path('foto-profil'),$image_name);


                    $data = [
                        'nama' => $request->input('nama'),
                        'nik'  => $request->input('nik'),
                        'tglLahir'  => $request->input('tglLahir'),
                        'provinsi_id'  => $request->input('provinsi_id'),
                        'kota_id'  => $request->input('kota_id'),
                        'kecamatan_id'  => $request->input('kecamatan_id'),
                        'kelurahan_id'  => $request->input('kelurahan_id'),
                        'alamat'  => $request->input('alamat'),
                        'jeniskelamin'  => $request->input('jeniskelamin'),
                        'nohp'  => $request->input('nohp'),
                        'status'  => $request->input('status'),
                        'image'  => $image_name
                    ];

                    Warga::create($data);

                    return redirect('datawarga')->with('Success','warga baru ditambahkan');
                }

                public function edit($id){
                    $warga = Warga::find($id);
                    return view('Warga.warga_edit',  ['warga' => $warga,
                    "title" => "Ubah Data Warga"]);
                }

                public function update(Request $request, $id){

                    #cara 1
                    // $nama   = $request->input('nama');
                    // $nik    = $request->input('nik');
                    // $tglLahir = $request->input('tglLahir');
                    // // $provinsi = $request->input('provinsi');
                    // // $kota   = $request->input('kota');
                    // // $kecamatan = $request->input('kecamatan');
                    // // $kelurahan  = $request->input('kelurahan');
                    // $alamat = $request->input('alamat');
                    // $jeniskelamin   = $request->input('jeniskelamin');
                    // $nohp   = $request->input('nohp');

                    // $warga = Warga::find($id);
                    // $warga->nama = $nama;
                    // $warga->nik  = $nik;
                    // $warga->tglLahir = $tglLahir;
                    // // $warga->provinsi_id = $provinsi;
                    // // $warga->kota_id = $kota;
                    // // $warga->kecamatan_id = $kecamatan;
                    // // $warga->kelurahan_id = $kelurahan;
                    // $warga->alamat = $alamat;
                    // $warga->jeniskelamin = $jeniskelamin;
                    // $warga->nohp = $nohp;
                    // $warga->save();
                    // return redirect('datawarga')->with("success","Warga telah diupdate!");


                    #cara 2 dengan validasi

                    $request->validate([
                        'nama'  => 'required',
                        'nik'  => 'required|numeric',
                        'tglLahir'  => 'required',
                        'jeniskelamin'  => 'required',
                        'alamat'  => 'required',
                        'nohp'  => 'required',
                        'status' => 'required',

                    ],[
                        'nama.required'=>'Nama Wajib Diisi',
                        'nik.required'=>'NIK Wajib Diisi',
                        'nik.numeric'=>'NIK Hanya Menggunakan Angka',
                        'tglLahir.required'=>'Tanggal Lahir Wajib Diisi',
                        'jeniskelamin.required'=>'Jenis Kelamin Wajib Diisi',
                        'alamat.required'=>'Alamat Wajib Diisi',
                        'nohp.required'=>'No Handphone Wajib Diisi',
                        'status.required'=>'Status Wajib Diisi'

                    ]);

                    $data = [
                        'nama' => $request->input('nama'),
                        'nik'  => $request->input('nik'),
                        'tglLahir'  => $request->input('tglLahir'),
                        'alamat'  => $request->input('alamat'),
                        'jeniskelamin'  => $request->input('jeniskelamin'),
                        'nohp'  => $request->input('nohp'),
                        'status'  => $request->input('status'),
                    ];

                    if ($request->hasFile('image')) {
                        $request->validate([
                            'image'  => 'required|file|image|mimes:jpeg,png,jpg|max:2048'
                        ],[
                            'image.mimes'=>'Hanya ekstensi JPEG,PNG,JPG yang dibolehkan'
                        ]);

                        $image_file = $request->file('image');
                        $image_extension = $image_file->extension();
                        $image_name = date('ymdhis').".".$image_extension;
                        $image_file->move(public_path('foto-profil'),$image_name);

                        $data_image = Warga::find($id);


                        File::delete(public_path('foto-profil').'/'.$data_image->image);

                        // $data = [
                            //     'image' => $image_name
                            // ];
                            $data['image'] = $image_name;

                        }

                        Warga::where('id',$id)->update($data);

                        return redirect('datawarga/detail/'.$id)->with("success","Warga telah diupdate!");
                    }

                    public function delete($id){

                        $data = Warga::find($id);
                        File::delete(public_path('foto-profil').'/'.$data->image);

                        $warga = Warga::find($id);
                        $warga->delete();



                        return redirect(route('datawarga'))->with("success","penjualan telah dihapus!");
                    }


                    public function tambahanggota()
                    {

                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "key: c2cb0d8070e0ac9fd45b42b8a5c3cb28"
                            ),
                        ));

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        $result = json_decode($response, TRUE);

                        // dd($result);

                        // dd(json_decode($response));

                        // $response = Http::get(env('YOUTUBE_API'));



                        //     $result = $response['items'][0]['snippet'];
                        //     // dd($result);

                        return view('Warga.warga_tambah_anggota', [
                            'title' => "Tambah Anggota Keluarga",
                            'result' => $result
                        ]);
                    }
                }
