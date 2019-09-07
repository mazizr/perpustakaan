<?php
namespace App\Http\Controllers;
use App\Rak;
use App\Http\Resources\PetugasCollection;
use App\Http\Resources\PetugasResource;
 
class RakAPIController extends Controller
{
    public function index()
    {
        $rak = Rak::latest()->get();
        $response = [
            'success' => true,
            'data' =>  $rak,
            'message' => 'Berhasil ditampilkan.'
        ];
        return response()->json($response, 200);
    }
}