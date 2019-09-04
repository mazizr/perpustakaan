<?php

         

namespace App\Http\Controllers;

          

use App\Rak;

use Illuminate\Http\Request;

use DataTables;

        

class RakController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {
        if ($request->ajax()) {
            $data = Rak::with('buku')->get();            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><ion-icon name="create"></ion-icon></a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><ion-icon name="trash"></ion-icon></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('rak') ;
    }

     

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        Rak::updateOrCreate(['id' => $request->rak_id],

                [
                    'kode_rak' => $request->kode_rak, 
                    'nama_rak' => $request->nama_rak,
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

        $rak = Rak::find($id);

        return response()->json($rak);

    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Rak::find($id)->delete();

     

        return response()->json(['success'=>'Product deleted successfully.']);

    }

}