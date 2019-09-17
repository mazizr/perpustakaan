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
            $data = \DB::select('SELECT pj.id, pj.kode_pinjam, pt.nama AS nama_petugas, ags.nama AS nama_anggota, bk.judul, 
            date_format(tanggal_pinjam,"%d-%m-%Y") AS tanggal_pinjam,date_format(pj.tanggal_kembali,"%d-%m-%Y") AS tanggal_kembali
            FROM peminjamen AS pj 
            LEFT JOIN petugas AS pt ON pt.id = pj.kode_petugas
                     LEFT JOIN anggotas AS ags ON  ags.id = pj.kode_anggota
                     LEFT JOIN bukus AS bk ON bk.id = pj.kode_buku 
                     
            ');
            // $data = Peminjaman::with('petugas','anggota','buku')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                    $pengembalian = \DB::select('SELECT id FROM pengembalians WHERE kode_pinjam='.$data->id.'');
                    
                           if ($pengembalian) {
                            $btnn = '<span class="badge badge-success">Dikembalikkan</span>';
                            return $btnn;
                            
                        }else {
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="glyphicon glyphicon-pencil"></i></a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePetugas"><i class="glyphicon glyphicon-trash"></i></a>';
                            return $btn;
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
        $tanggal_pinjam = \Carbon\Carbon::parse($request->tanggal_pinjam)->format("Y-m-d");
        $tanggal_kembali = \Carbon\Carbon::parse($request->tanggal_kembali)->format("Y-m-d");
        Peminjaman::updateOrCreate(['id' => $request->peminjaman_id],
                [
                    'kode_pinjam' => $request->kode_pinjam, 
                    'tanggal_pinjam' => $tanggal_pinjam,
                    'tanggal_kembali' => $tanggal_kembali,
                    'kode_petugas' => $request->kode_petugas,
                    'kode_anggota' => $request->kode_anggota,
                    'kode_buku' => $request->kode_buku
                ]
        );       
        return response()->json(['success'=>'Product saved successfully.']);
    }


    public function edit($id)

    {
        $peminjaman = \DB::select('SELECT peminjamen.id,kode_pinjam,date_format(tanggal_pinjam,"%d-%m-%Y") AS tanggal_pinjam, date_format(tanggal_kembali,"%d-%m-%Y") AS tanggal_kembali,pet.nama AS nama_petugas, ang.nama AS nama_anggota,buk.judul,pet.id AS id_petugas,ang.id AS id_anggota,buk.id AS id_buku
                                    FROM peminjamen
                                    LEFT JOIN petugas AS pet ON pet.id = peminjamen.kode_petugas
                                    LEFT JOIN anggotas AS ang ON ang.id = peminjamen.kode_anggota
                                    LEFT JOIN bukus AS buk ON buk.id = peminjamen.kode_buku 
                                WHERE peminjamen.id = ' . $id . '');
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