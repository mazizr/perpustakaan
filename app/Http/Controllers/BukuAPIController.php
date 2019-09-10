<?php
namespace App\Http\Controllers;
use App\Buku;
use App\Http\Resources\PetugasCollection;
use App\Http\Resources\PetugasResource;
 
class BukuAPIController extends Controller
{
    public function index()
    {
        $buku = Buku::latest()->get();
        $response = [
            'success' => true,
            'data' =>  $buku,
            'message' => 'Berhasil ditampilkan.'
        ];
        return response()->json($response, 200);
    }
}