<?php
         

namespace App\Http\Controllers;

          

use App\Pengembalian;

use Illuminate\Http\Request;

use DataTables;
use Session;
use Auth;

        

class PengembalianController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pengembalian::with('petugas','anggota','buku','peminjaman')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><ion-icon name="create"></ion-icon></a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePetugas"><ion-icon name="trash"></ion-icon></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('pengembalian');
    }

     

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {

        $request->validate([
            'kode_kembali' => 'required|max:4'
        ]);

        $tanggal_kembali = strtotime($request->tanggal_kembali);
        $jatuh_tempo = strtotime($request->jatuh_tempo);
        $jumlah =  $tanggal_kembali - $jatuh_tempo ;
        $jumlah_hari = floor($jumlah / (60 * 60 * 24));
        if ($jumlah_hari <= 0) {
            $jumlah_hari = 0;
            $total_denda = 0;
        }else {
            $total_denda = $jumlah_hari*2000;
        }

        
        Pengembalian::updateOrCreate(['id' => $request->pengembalian_id],
                [
                    'kode_kembali' => $request->kode_kembali, 
                    'kode_pinjam' => $request->kode_pinjam, 
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'jatuh_tempo' => $request->jatuh_tempo,
                    'denda_per_hari' => 2000,
                    'jumlah_hari' => $jumlah_hari,
                    'total_denda' => $total_denda,
                    'kode_petugas' => $request->kode_petugas,
                    'kode_anggota' => $request->kode_anggota,
                    'kode_buku' => $request->kode_buku,
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
        $pengembalian = Pengembalian::find($id);
        return response()->json($pengembalian);
    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {
        Pengembalian::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }

}