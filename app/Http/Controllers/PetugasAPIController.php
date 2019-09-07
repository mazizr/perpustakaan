<?php
namespace App\Http\Controllers;
use App\Petugas;
use App\Http\Resources\PetugasCollection;
use App\Http\Resources\PetugasResource;
 
class PetugasAPIController extends Controller
{
    public function index()
    {
        $petugas = Petugas::latest()->get();
        $response = [
            'success' => true,
            'data' =>  $petugas,
            'message' => 'Berhasil ditampilkan.'
        ];
        return response()->json($response, 200);
    }
}