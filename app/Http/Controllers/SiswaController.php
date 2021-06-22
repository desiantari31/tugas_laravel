<?php

namespace App\Http\Controllers;

use App\models\Siswa;
use App\models\jeniskelamin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title="Data Siswa";
        if($request->has('cari')){
            $siswa = Siswa::where('nama','LIKE','%'.$request->cari.'%')->paginate(3);
        }else{
            $siswa = Siswa::paginate(3);
        }
        return view('admin.siswa',compact('title','siswa'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title="Tambah Data Siswa";
        return view('admin.tambahsiswa',compact('title'));
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
            'nis'=>'required',
            'nisn'=>'required',
            'nama'=>'required',
            'tmptlhr'=>'required',
            'tgllhr'=>'required',
            'foto'=>'required'
        ]);
        $path = $request->file('foto')->store('medias');
        $validasi['id_siswa']=Auth::id();
        $validasi['foto']=$path;
        Siswa::create($validasi);
        return redirect('siswa')->with('toast_success','Data Berhasil Tersimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = "Detail Data";
        $siswa = Siswa::findOrfail($id);
        return view('admin.showsiswa',compact('title','siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $siswa=Siswa::find($id);
        $title="Edit Data Siswa";
        return view('admin.tambahsiswa',compact('title','siswa'));
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
            'nis'=>'required',
            'nisn'=>'required',
            'nama'=>'required',
            'tmptlhr'=>'required',
            'tgllhr'=>'required'
        ]);
        if($request->hasFile('foto')){
            $fileName=time().$request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('medias',$fileName);
            $validasi['foto']=$path;
            $siswa=Siswa::find($id);
            Storage::delete($siswa->foto);
        }
        $validasi['id_siswa']=Auth::id();
        Siswa::where('id',$id)->update($validasi);
        return redirect('siswa')->with('toast_success','Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa=Siswa::find($id);
        if($siswa != null){
            Siswa::where('id',$id)->delete();
        }
        return redirect('siswa')->with('info','Data Berhasil Dihapus');
    }
}
