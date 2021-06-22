<?php

namespace App\Http\Controllers;

use App\models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title="Data Guru";
        if($request->has('cari')){
            $guru = Guru::where('nama','LIKE','%'.$request->cari.'%')->paginate(3);
        }else{
            $guru = Guru::paginate(3);
        }
        return view('admin.guru',compact('title','guru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title="Tambah Data Guru";   
        return view('admin.tambah',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validasi=$request->validate([
            'nip'=>'required',
            'nama'=>'required',
            'status'=>'required',
            'jabatan'=>'required'
        ]);
        $validasi['id_guru']=Auth::id();
        Guru::create($validasi);
        return redirect('guru')->with('success','Data berhasil disimpan');
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
        $guru=Guru::find($id);
        $title="Edit Data Guru";   
        return view('admin.tambah',compact('title','guru'));
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
        $validasi=$request->validate([
            'nip'=>'required',
            'nama'=>'required',
            'status'=>'required',
            'jabatan'=>'required'
        ]);
        $validasi['id_guru']=Auth::id();
        Guru::where('id',$id)->update($validasi);
        return redirect('guru')->with('success','Data berhasil terupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guru=Guru::find($id);
        if($guru != null){
            $guru=Guru::find($guru->id);
            Guru::where('id',$id)->delete();
        }
        return redirect('guru')->with('success','Data berhasil terhapus');
    }
}
