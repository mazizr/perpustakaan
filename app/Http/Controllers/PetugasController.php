<?php

         

namespace App\Http\Controllers;

          

use App\Petugas;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetugasRequest;
use Illuminate\Http\Request;
use DataTables;
use Session;
use Auth;
        

class PetugasController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Petugas::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="glyphicon glyphicon-pencil"></i></a>';
                           if ($row->peminjaman->count() == 0) {
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePetugas"><i class="glyphicon glyphicon-trash"></i></a>';
                            }else {
                                $btn = $btn.' | <span class="label label-warning"> Dipakai</span>';
                            }
                           
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('petugas');
    }

     

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(PetugasRequest $request)

    {
        Petugas::updateOrCreate(['id' => $request->petugas_id],
                [
                    'kode_petugas' => $request->kode_petugas, 
                    'nama' => $request->nama,
                    'jk' => $request->jk,
                    'jabatan' => $request->jabatan,
                    'telepon' => $request->telepon,
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
        $petugas = Petugas::find($id);
        return response()->json($petugas);
    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {
        Petugas::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }

}