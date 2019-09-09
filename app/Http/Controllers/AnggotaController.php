<?php

         

namespace App\Http\Controllers;

          

use App\Anggota;

use Illuminate\Http\Request;

use DataTables;
use Session;
use Auth;

        

class AnggotaController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

   

        if ($request->ajax()) {

            $data = Anggota::latest()->get();

            return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){

   

                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><ion-icon name="create"></ion-icon></a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteAnggota"><ion-icon name="trash"></ion-icon></a>';

    

                            return $btn;

                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

      

        return view('anggota');

    }

     

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        Anggota::updateOrCreate(['id' => $request->anggota_id],

                [
                    'kode_anggota' => $request->kode_anggota, 
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'jurusan' => $request->jurusan,
                    'alamat' => $request->alamat

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

        $anggota = Anggota::find($id);

        return response()->json($anggota);

    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Anggota::find($id)->delete();

     

        return response()->json(['success'=>'Product deleted successfully.']);

    }

}