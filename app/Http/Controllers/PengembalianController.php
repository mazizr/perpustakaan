<?php
         

namespace App\Http\Controllers;

          

use App\Pengembalian;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengembalianRequest;
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
    public function isi(Request $request,$id)
    {
        
        $pengembalian = new Pengembalian;
        $peminjaman = \DB::select('SELECT b.id,b.kode_pinjam,p.nama AS nama_petugas,a.nama AS nama_anggota,bk.judul, b.tanggal_kembali, 
        a.id AS id_anggota, p.id AS id_petugas, bk.id AS id_buku
        FROM peminjamen AS b 
        LEFT JOIN petugas AS p ON p.id = b.kode_petugas
        LEFT JOIN anggotas AS a ON a.id = b.kode_anggota
        LEFT JOIN bukus AS bk ON bk.id = b.kode_buku
        WHERE b.id = '.$id.'
                            ');
        
        return response()->json($peminjaman);
    }


    public function store(PengembalianRequest $request)
    {
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
        return response()->json(['success' => 'Saved']);
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
        $peminjaman = \DB::select('SELECT pg.id, a.nama AS nama_anggota, p.nama AS nama_petugas, bk.judul, pm.kode_pinjam
                                    FROM pengembalians AS pg
                                    LEFT JOIN petugas AS p ON p.id = pg.kode_petugas
                                    LEFT JOIN anggotas AS a ON a.id = pg.kode_anggota
                                    LEFT JOIN bukus AS bk ON bk.id = pg.kode_buku 
                                    LEFT JOIN peminjamen pm ON pm.id = pg.kode_pinjam
                                    WHERE pg.id = '.$id.'
                                    ');
                                    foreach ($peminjaman as $value) {
        $option = '<option value="' .$value->id. '" ' . ($value->id == $pengembalian->id ? 'selected' : '') . '>' . $value->kode_pinjam . '</option>';
    }
        $data = ['datapengembalian' => $pengembalian, 'peminjaman' => $peminjaman, 'kode_pinjam' => $option];
        return response()->json($data);
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