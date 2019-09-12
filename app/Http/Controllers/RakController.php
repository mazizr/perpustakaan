<?php

         

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\KodeRakStoreRequest;
use App\Rak;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Auth;

        

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
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteRak"><ion-icon name="trash"></ion-icon></a>';
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

    public function store(KodeRakStoreRequest $request)

    {
        $rak = Rak::updateOrCreate(['id' => $request->rak_id],

                [
                    'kode_rak' => $request->kode_rak, 
                    'nama_rak' => $request->nama_rak
                    
                ],

                
        );     
        $rak->buku()->sync($request->buku);
   
        $validated = $request->validated();
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
        $data_rak = ['id' => $rak->id, 'nama_rak' => $rak->nama_rak, 'kode_rak' => $rak->kode_rak];
        $buku = \DB::select('SELECT b.id,b.judul,rb.rak_id 
                            FROM bukus AS b 
                            left JOIN rak_buku AS rb ON rb.buku_id = b.id 
                            AND rb.rak_id=' .$rak->id.'
                            ');
        foreach ($buku as $value) {
            $option[] = '<option value="' .$value->id. '" ' . ($value->rak_id == $rak->id ? 'selected' : '') . '>' . $value->judul . '</option>';
        }
        $test = implode('', $option);

        $data = ['datarak' => $data_rak, 'buku' => $test, 'rak' => $rak];
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

        Rak::find($id)->delete();

     

        return response()->json(['success'=>'Product deleted successfully.']);

    }

}