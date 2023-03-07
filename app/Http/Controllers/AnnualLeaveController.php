<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cut;
use Illuminate\Http\Request;
use App\Http\Resources\CutiResource;
use Illuminate\Support\Facades\Auth;

class AnnualLeaveController extends Controller
{
    public function index()
    {
        // dd('test');
        // Ambil semua data permohonan cuti dari database
        $cuti = Cut::all();
        // menggunakn Resource sesuai rekomendari ORM laravel
        return CutiResource::collection(($cuti->loadMissing([
            'writer:id,name'
        ])));
    }


    public function show($id)
    {
        // akan mencari data permohonan cuti dengan id yang sesuai menggunakan method find() dari model Cuti
        try {
            $cuti = Cut::with('writer:id,name')->findOrFail($id);
            return new CutiResource(($cuti->loadMissing([
                'writer:id,name'
            ])));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create annual leave request',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // akan melakukan validasi data yang dikirimkan melalui request, kemudian membuat permohonan cuti baru dengan menggunakan method create()
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required',
            'status' => 'required'
        ], [
            'user_id.required' => 'User ID diperlukan',
            'user_id.exists' => 'ID Pengguna Salah',
            'start_date.required' => 'Tanggal mulai diperlukan',
            'start_date.date' => 'Format tanggal mulai salah',
            'end_date.required' => 'Tanggal akhir wajib diisi',
            'end_date.date' => 'Format tanggal akhir salah',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai',
            'reason.required' => 'Alasan diperlukan',
            'status.required' => 'Status diperlukan'
        ]);

        try {
            $cuti = Cut::create($validatedData);
            return new CutiResource($cuti->loadMissing('writer:id,name'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create annual leave request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
