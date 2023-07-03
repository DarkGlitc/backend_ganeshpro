<?php

namespace App\Http\Controllers;

use App\Http\Resources\GigsResource;
use App\Http\Resources\ProductDetailResource;
use App\Models\Gigs;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class GigsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gigs = Gigs::all();
        return GigsResource::collection($gigs);
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
            'title' => 'required',
            'keywords' => 'required',
            'waktu_penyelesaian' => 'required',
            'batas_revisi' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required',
            'id_category' => 'required',
        ]);

        $gig = new Gigs();

        if($request->image) {
            $filename = $this->generateRandomString();
            $extension = $request->image->extension();

            Storage::putFileAs('photos',$request->image,$filename.'.'.$extension);
            $gig->image = $filename.'.'.$extension;
        }

        $user = Auth::user();
        $idToko = Store::where('id_user', $user->id)->first()->id;

        $gig->id_store = $idToko;
        $gig->id_category = $request->input('id_category');
        $gig->title = $request->input('title');
        $gig->keywords = $request->input('keywords');
        $gig->batas_revisi = $request->input('batas_revisi');
        $gig->price = $request->input('price');
        $gig->description = $request->input('description');
        $gig->save();

        return response()->json(['message' => 'Data berhasil ditambahkan','success' => true]);



    }

    /**
     * Display the specified esource.
     */
    public function showDetails(Gigs $gigs,$id)
    {
        $gigs = Gigs::find($id);
        return new ProductDetailResource($gigs);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gigs $gigs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gigs $gigs,$id)
    {
        $validation = $request->validate([
            'title' => 'required',
            'keywords' => 'required',
            'waktu_penyelesaian' => 'required',
            'batas_revisi' => 'required',
            'price' => 'required',
            'image' => 'required',
            'description' => 'required',
            'id_category' => 'required',
        ]);

        $gig = Gigs::find($id);

        if($request->image) {
            $filename = $this->generateRandomString();
            $extension = $request->image->extension();

            if($gig->image) {
                Storage::delete('photos/' .$gig->image);
            }

            Storage::putFileAs('photos',$request->image,$filename.'.'.$extension);
            $gig->image = $filename.'.'.$extension;
        }

        $user = Auth::user();
        $idToko = Store::where('id_user', $user->id)->first()->id;

        $gig->id_store = $idToko;
        $gig->id_category = $request->input('id_category');
        $gig->title = $request->input('title');
        $gig->keywords = $request->input('keywords');
        $gig->batas_revisi = $request->input('batas_revisi');
        $gig->price = $request->input('price');
        $gig->description = $request->input('description');
        $gig->save();

        return response()->json(['message' => 'Data berhasil ditambahkan','success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gigs $gigs,$id)
    {
        $gig = Gigs::find($id);
        if($gig->icons) {
            Storage::delete('photos/' .$gig->icons);
        }
        $gig->delete();
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
