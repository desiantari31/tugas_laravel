<?php

namespace App\Http\Controllers;

use App\models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title="Data Mapel";
        if($request->has('cari')){
            $mapel = Mapel::where('pengajar','LIKE','%'.$request->cari.'%')->paginate(3);
        }else{
            $mapel=Mapel::paginate(3);
        }
        return view('admin.mapel',compact('title','mapel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $title="Tambah Data Mapel";
        return view('admin.tambahmapel',compact('title'));
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
            'mapel'=>'required',
            'hari'=>'required',
            'jamawal'=>'required',
            'jamakhir'=>'required',
            'pengajar'=>'required',
            'kelas'=>'required'
        ]);

        $validasi['id_mapel']=Auth::id();
        Mapel::create($validasi);
        return redirect('mapel')->with('success','Data berhasil disimpan');
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
        $mapel=Mapel::find($id);
        $title="Edit Data Mapel";
        return view('admin.tambahmapel',compact('title','mapel'));
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
            'mapel'=>'required',
            'hari'=>'required',
            'jamawal'=>'required',
            'jamakhir'=>'required',
            'pengajar'=>'required',
            'kelas'=>'required'
        ]);
        $validasi['id_mapel']=Auth::id();
        Mapel::where('id',$id)->update($validasi);
        return redirect('mapel')->with('success','Data berhasil terupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mapel=Mapel::find($id);
        if($mapel != null){
            $mapel=Mapel::find($mapel->id);
            Mapel::where('id',$id)->delete();
        }
        return redirect('mapel')->with('success','Data berhasil terhapus');
    }
}
