<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
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
        $data = Kategori::latest()->paginate(5);
        return view('kategori.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //tampilkan form input yang ada dalam resources/views/kategori/ create.blade.php
        return view('kategori.create'); 
        //menuju atau membuka file create.blade.php yang ada dalam folder kategori
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $simpan = Kategori::create($request->all());

        if($simpan){
            //redirect dengan pesan sukses
            return redirect('/kategori')->with(['success'=>'Data Sukses Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect('/kategori')->with(['error' => 'Data Gagal Disimpan!']);
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
        $ubah=kategori::find($id);
        //ubah adalah pengambilan data dari variabel $ubah, namanya harus sama
        return view('kategori.edit',compact(['ubah']));
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
        $upd = kategori::find($id);
        $upd->update($request->all());
        if($upd){
            return redirect('/kategori')->with(['success'=>'Data Sukses di ubah']);
        }else{
            return redirect('/kategori')->with(['error'=>'Data gagal di ubah']);
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
        $del=kategori::find($id);
        $del->delete(); //perintah untuk hapus
        if($del){
            //redirect dengan pesan sukses
            return redirect('/kategori')->with(['success'=>'Data Sukses Dihapus!']);
        }else{
            //redirect dengan pesan error
            return redirect('/kategori')->with(['error' => 'Data Gagal Dihapus!']);
        }   
    }
    public function search(Request $request)
    {
        $keyword = $request->search; //fungsi cari yang hasilnya dimasukkan ke dalam variabel keyword
        //menjalan model kategori untuk menampilkan data berdasarkan keyword yang dicari di nama kategori
        $data = Kategori::where('nama_kategori', 'like', "%" . $keyword . "%")->paginate(5);

        //menampilkan hasil pencarian yang isinya sudah ditampung dalam variabel data
        //dengan menampilkan hasil pencarian untuk keyword yang mirip sebanyak maksimal 5 data perhalaman
        return view('kategori.index', compact('data'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
