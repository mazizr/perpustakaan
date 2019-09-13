<?php

         

namespace App\Http\Controllers;

          

use App\Peminjaman;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeminjamanRequest;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Auth;

        

class PeminjamanController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Peminjaman::with('petugas','anggota','buku')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           
                           if ($row->pengembalian->count() == 0) {
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><ion-icon name="create"></ion-icon></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePetugas"><ion-icon name="trash"></ion-icon></a>';
                            return $btn;
                        }else {
                            
                            $btnn = '<span class="badge badge-success">Dikembalikkan</span>';
                            return $btnn;
                            
                        }
                            
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('peminjaman');
    }

     

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(PeminjamanRequest $request)

    {
        Peminjaman::updateOrCreate(['id' => $request->peminjaman_id],
                [
                    'kode_pinjam' => $request->kode_pinjam, 
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'kode_petugas' => $request->kode_petugas,
                    'kode_anggota' => $request->kode_anggota,
                    'kode_buku' => $request->kode_buku
                ]
        );       
        return response()->json(['success'=>'Product saved successfully.']);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {
        $peminjaman = Peminjaman::find($id);
        return response()->json($peminjaman);
    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {
        Peminjaman::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }

}