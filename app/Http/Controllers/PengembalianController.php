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
            $data = \DB::select('SELECT pg.id, pg.kode_kembali, pj.kode_pinjam, 
            date_format(pg.tanggal_kembali,"%d-%m-%Y") AS tanggal_kembali, 
            date_format(pj.tanggal_kembali,"%d-%m-%Y") AS jatuh_tempo,
            ags.nama AS nama_anggota, 
            pg.denda_per_hari, pg.total_denda, pt.nama AS nama_petugas, pg.jumlah_hari, pg.kode_pinjam AS id_kode_pinjam
                        FROM pengembalians AS pg 
                        LEFT JOIN peminjamen AS pj ON pj.id = pg.kode_pinjam
                        LEFT JOIN petugas AS pt ON pt.id = pj.kode_petugas
                        LEFT JOIN anggotas AS ags ON  ags.id = pj.kode_anggota
            ');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="glyphicon glyphicon-pencil"></i></a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePetugas"><i class="glyphicon glyphicon-trash"></i></a>';
                            return $btn;
                    })
                    ->addColumn('buku', function($row){
                        $peminjaman_buku = \DB::select('SELECT pb.id, bk.judul, pj.kode_pinjam
                                                        FROM peminjaman_buku AS pb
                                                        LEFT JOIN bukus AS bk ON bk.id = pb.id_buku
                                                        LEFT JOIN peminjamen AS pj ON  pj.id = pb.id_peminjaman
                                                        WHERE pb.id_peminjaman = '.$row->id_kode_pinjam.'
                                            ');
                                            $databuku = '';
                                            foreach ($peminjaman_buku as $value) {
                                                $databuku .= "-".$value->judul;
                                            }
                                            return $databuku;
                                                        
                        })
                        
                    ->rawColumns(['action','buku'])
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
        $peminjaman = \DB::select('SELECT b.id,b.kode_pinjam,p.nama AS nama_petugas,a.nama AS nama_anggota, date_format(tanggal_kembali,"%d-%m-%Y") AS tanggal_kembali,
                                    a.id AS id_anggota, p.id AS id_petugas
                                    FROM peminjamen AS b 
                                    LEFT JOIN petugas AS p ON p.id = b.kode_petugas
                                    LEFT JOIN anggotas AS a ON a.id = b.kode_anggota
                                    WHERE b.id = '.$id.'
                                ');
        $peminjaman_buku = \DB::select('SELECT pb.id, bk.judul, pj.kode_pinjam, pb.id_buku
                                    FROM peminjaman_buku AS pb
                                    LEFT JOIN bukus AS bk ON bk.id = pb.id_buku
                                    LEFT JOIN peminjamen AS pj ON  pj.id = pb.id_peminjaman
                                    WHERE pb.id_peminjaman = '.$id.'
                                ');
        $databuku = '';
        foreach ($peminjaman_buku as $value) {
            $databuku .= $value->judul.' ';
        }

        $data = ['datapeminjaman' => $peminjaman, 'buku' => $databuku];
        return response()->json($data);
    }


    public function store(PengembalianRequest $request)
    {
        $tanggal_kembali = \Carbon\Carbon::parse($request->tanggal_kembali)->format("Y-m-d");
        $jatuh_tempo = \Carbon\Carbon::parse($request->jatuh_tempo)->format("Y-m-d");
        $tanggal_kembali_detik =  strtotime($request->tanggal_kembali);
        $jatuh_tempo_detik = strtotime($request->jatuh_tempo);
        $jumlah =  $tanggal_kembali_detik - $jatuh_tempo_detik ;
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
                    'tanggal_kembali' => $tanggal_kembali,
                    'jatuh_tempo' => $jatuh_tempo,
                    'denda_per_hari' => 2000,
                    'jumlah_hari' => $jumlah_hari,
                    'total_denda' => $total_denda,
                    'kode_petugas' => $request->kode_petugas,
                    'kode_anggota' => $request->kode_anggota
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
        $peminjaman = \DB::select('SELECT pg.id, a.nama AS nama_anggota, p.nama AS nama_petugas, pm.kode_pinjam,p.id AS id_petugas,a.id AS id_anggota,
        date_format(pm.tanggal_kembali,"%d-%m-%Y") AS jatuh_tempo,
        date_format(pg.tanggal_kembali,"%d-%m-%Y") AS tanggal_kembali
                                    FROM pengembalians AS pg
                                    LEFT JOIN petugas AS p ON p.id = pg.kode_petugas
                                    LEFT JOIN anggotas AS a ON a.id = pg.kode_anggota
                                    LEFT JOIN peminjamen pm ON pm.id = pg.kode_pinjam                         
                                    WHERE pg.id = '.$id.'
                                    ');
            foreach ($peminjaman as $value) {
                $option = '<option value="' .$value->id. '" ' . ($value->id == $pengembalian->id ? 'selected' : '') . '>' . $value->kode_pinjam . '</option>';
            }

            $buku = \DB::select('SELECT b.id,b.judul,rb.id_peminjaman 
                            FROM bukus AS b 
                            left JOIN peminjaman_buku AS rb ON rb.id_buku = b.id 
                            AND rb.id_peminjaman=' .$pengembalian->kode_pinjam.'
            ');
            $op ='';
            foreach ($buku as $value) {
                if ($value->id_peminjaman == $pengembalian->kode_pinjam) {
                    $op .= $value->judul;
                }
                
            }

        $data = ['datapengembalian' => $pengembalian, 'buku' => $op, 'peminjaman' => $peminjaman, 'kode_pinjam' => $option];
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