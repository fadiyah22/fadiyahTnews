<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
        {
            $this->middleware('auth');
        }

    public function index()
    {
        //
        $data = Berita::latest()->paginate(10);
        return view('berita.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //sebelumnya pastikan sudah import modul Berita
        $datakat = Kategori::All();
        //sebelumnya pastikan sudah import modul Berita
        $data = Berita::all(); //untuk mengambil data dari tabel berita
        //tampilkan form untuk input yang ada dalam resources/views/berita/create.blade.php
        return view('berita.create',compact(['datakat']));
        return view('berita.create',compact(['data'])); //menuju atau membuka file create.blade.php yang ada dalam folder berita
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'id_berita'     => 'required',
            'id_kategori'   => 'required',
            'judul'   => 'required',
            'tanggal'   => 'required',
            'isi'   => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png|max:2048'
         ]);

         //proses upload gambar
         if($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $image->move(public_path('gambar'),$image->getClientOriginalName());
        }else{
            $image=NULL;
        }
         $simpan = Berita::create([
             'id_berita'   => $request->id_berita,
             'id_kategori'   => $request->id_kategori,
             'judul'   => $request->judul,
             'tanggal'   => $request->tanggal,
             'isi_berita'   => $request->isi,
             'gambar'   => $image->getClientOriginalName()
         ]);
         if($simpan){

            //redirect dengan pesan sukses
            return redirect('/berita')->with(['success' => 'Data Berhasil Disimpan!']);

        }else{

            //redirect dengan pesan error
            return redirect('/berita')->with(['error' => 'Data Gagal Disimpan!']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //buat variable yang disesuaikan dengan variabel yang dipakai pada form di file edit.blade.php
        $datakat=Kategori::all();
        $berita=Berita::find($id);
        return view('berita.edit',compact(['berita','datakat']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //
       $this->validate($request, [
        'id_berita'     => 'required',
        'id_kategori'   => 'required',
        'judul'   => 'required',
        'tanggal'   => 'required',
        'isi'   => 'required',
        'gambar' => 'mimes:jpg,jpeg,png|max:2048'
 ]);
 $upd = Berita::find($id);

if($request->file('gambar') == "") {

    $upd->update([
        'id_berita'   => $request->id_berita,
         'id_kategori'   => $request->id_kategori,
         'judul'   => $request->judul,
         'tanggal'   => $request->tanggal,
         'isi_berita'   => $request->isi,
    ]);

} else {

     //hapus old image
    $photo = $upd->gambar;
    if(File::exists(public_path('gambar/'.$photo))){
        File::delete(public_path('gambar/'.$photo));
    }

    //proses upload gambar baru
        $image = $request->file('gambar');
        $image->move(public_path('gambar'),$image->getClientOriginalName());

    $upd ->update([
       'id_berita'   => $request->id_berita,
         'id_kategori'   => $request->id_kategori,
         'judul'   => $request->judul,
         'tanggal'   => $request->tanggal,
         'isi_berita'   => $request->isi,
         'gambar'   => $image->getClientOriginalName()
    ]);
}

 if($upd){

    //redirect dengan pesan sukses
    return redirect('/berita')->with(['success' => 'Data Berhasil Disimpan!']);

    }else{

        //redirect dengan pesan error
        return redirect('/berita')->with(['error' => 'Data Gagal Disimpan!']);

    }
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //mencari data berdasarkan id yang dikirimkan dari tombol delete
        $del=Berita::find($id);
        $del->delete(); //perintah untuk hapus
        if($del){
            //hapus gambar
            $photo = $del->gambar;
            if(File::exists(public_path('gambar/'.$photo))){
                File::delete(public_path('gambar/'.$photo));
             }
            //redirect dengan pesan sukses
            return redirect('/berita')->with(['success' => 'Data Berhasil Dihapus!']);

        }else{
            //redirect dengan pesan error
            return redirect('/berita')->with(['error' => 'Data Gagal Dihapus!']);

        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search; //fungsi cari yang hasilnya dimasukkan ke dalam variabel keyword
        //menjalan model kategori untuk menampilkan data berdasarkan keyword yang dicari di judul berita
        $data = Berita::where('judul', 'like', "%" . $keyword . "%")->paginate(5);

        //menampilkan hasil pencarian yang isinya sudah ditampung dalam variabel data
        //dengan menampilkan hasil pencarian untuk keyword yang mirip sebanyak maksimal 5 data perhalaman
        return view('berita.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
