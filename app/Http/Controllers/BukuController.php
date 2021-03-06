<?php      

namespace App\Http\Controllers;     

use App\Buku;
use App\Http\Controllers\Controller;
use App\Http\Requests\BukuRequest;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Auth;

        

class BukuController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {
        if ($request->ajax()) {

            $data = Buku::latest()->get();

            return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){

   

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="glyphicon glyphicon-pencil"></i></a>';
                        if ($row->rak->count() == 0 && $row->peminjaman->count() == 0) {
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBuku"><i class="glyphicon glyphicon-trash"></i></a>';
                        }else {
                            $btn = $btn.' | <span class="label label-warning"> Dipakai</span>';
                        }
                            return $btn;

                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

        $years = [];
        for ($year=1900; $year <= 2020; $year++) $years[$year] = $year;

        return view('buku', compact('year'));

    }

     

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(BukuRequest $request)

    {
        Buku::updateOrCreate(['id' => $request->buku_id],

                [
                    'kode_buku' => $request->kode_buku, 
                    'judul' => $request->judul,
                    'penulis' => $request->penulis,
                    'penerbit' => $request->penerbit,
                    'tahun_terbit' => $request->tahun_terbit

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

        $buku = Buku::find($id);

        return response()->json($buku);

    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $buku = Buku::find($id)->delete();
        Session::flash("flash_notification",[
            "level" => "Success",
            "message" => "Berhasil menghapus<b>"
                         . $buku->judul."</b>"
        ]);
        return response()->json(['success'=>'Product deleted successfully.']);

    }

}