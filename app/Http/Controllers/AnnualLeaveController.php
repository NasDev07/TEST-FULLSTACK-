<?php

namespace App\Http\Controllers;

use App\Http\Resources\CutiResource;
use App\Models\Cut;
use Illuminate\Http\Request;

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
        $cuti = Cut::with('writer:id,name')->findOrFail($id);
        return new CutiResource(($cuti->loadMissing([
            'writer:id,name'
        ])));
    }

    public function store(Request $request)
    {
        // akan melakukan validasi data yang dikirimkan melalui request, kemudian membuat permohonan cuti baru dengan menggunakan method create()
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required',
            'status' => 'required'
        ]);

        $cuti = Cut::create($validatedData);

        return response()->json([
            'message' => 'Annual leave request created successfully',
            'data' => $cuti
        ], 201);
    }
}
