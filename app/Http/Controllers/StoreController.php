<?php

namespace App\Http\Controllers;

use App\Http\Resources\TokoResource;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::all();
        return response()->json(['data' => $stores]);
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
            'nama_brand' => 'required',
            'description' => 'required',
            'icons' => 'required',
        ]);
        $store = new Store();
        if($request->icons) {
            $fileName = $this->generateRandomString();
            $extension = $request->icons->extension();

            Storage::putFileAs('photos',$request->icons,$fileName.'.'.$extension);
            $store->icons = $fileName.'.'.$extension;
        }

        $idUser = Auth::user()->id;

        $store->id_user = $idUser;
        $store->nama_brand = $request->input('nama_brand');
        $store->description = $request->input('description');
        $store->save();

        return response()->json(['message' => 'Data berhasil ditambahkan','success' => true]);

    }

    /**
     * Display the specified resource.
     */
    public function showByIcons(Store $store,$fileName)
    {
        $path = storage_path('app/photos/' . $fileName);

        if (!file_exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $fileNameOnly = basename($fileName);

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header('Content-Type', $type);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    public function showByOwner(Store $store)
    {
        $user = Auth::user();
        $idToko = Store::where('id_user', $user->id)->first()->id;
        $toko = Store::find($idToko);

        return new TokoResource($toko);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store,$id)
    {
        $validation = $request->validate([
            'nama_brand' => 'required',
            'description' => 'required',
            'icons' => 'required',
        ]);
        $store = Store::find($id);

        if($request->hasFile('icons')) {
            $fileName = $this->generateRandomString();
            $extension = $request->icons->extension();

            if($store->icons) {
                Storage::delete('photos/' .$store->icons);
            }

            try {
                Storage::putFileAs('photos',$request->icons,$fileName.'.'.$extension);
                $store->icons = $fileName.'.'.$extension;
                $store->nama_brand = $request->input('nama_brand');
                $store->description = $request->input('description');
                $store->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diupdates'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data gagal diupdates'
                ]);
            }
        }

        return response()->json(['message' => 'Data berhasil diupdate','success' => true,'data' => $store]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store,$id)
    {
        $store = Store::find($id);
        if($store->icons) {
            Storage::delete('photos/' .$store->icons);
        }
        $store->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}