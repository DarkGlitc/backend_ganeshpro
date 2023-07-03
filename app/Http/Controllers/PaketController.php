<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pakets = Paket::all();
        return response()->json([
            'data' => $pakets
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama_paket' => 'required',
            'description' => 'required',
            'id_gigs' => 'required',
        ]);

        $paket = new Paket();
        $paket->nama_paket = $request->input('nama_paket');
        $paket->description = $request->input('description');
        $paket->id_gigs = $request->input('id_gigs');
        $paket->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Paket $paket,$id)
    {
        $validation = $request->validate([
            'nama_paket' => 'required',
            'description' => 'required',
            'id_gigs' => 'required',
        ]);

        $paket = Paket::find($id);
        $paket->nama_paket = $request->input('nama_paket');
        $paket->description = $request->input('description');
        $paket->id_gigs = $request->input('id_gigs');
        $paket->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket,$id)
    {
        $paket = Paket::find($id);
        $paket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}