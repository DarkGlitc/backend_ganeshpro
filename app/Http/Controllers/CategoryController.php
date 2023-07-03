<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return response()->json(['data' => $category],200);
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
        $validated = $request->validate([
            'name_category' => 'required',
            'icons' => 'required',
        ]);

        if($request->icons) {
            $fileName = $this->generateRandomString();
            $extension = $request->icons->extension();

            Storage::putFileAs('photos',$request->icons,$fileName.'.'.$extension);
        }

        $category = new Category();
        $category->name_category = $request->input('name_category');
        $category->icons = $fileName.'.'.$extension;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function showImage(Category $category,$fileName)
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
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category,$id)
    {
        $validated = $request->validate([
            'name_category' => 'required',
            'icons' => 'required',
        ]);

        $category = Category::find($id);

        if($request->hasFile('icons')) {
            $fileName = $this->generateRandomString();
            $extension = $request->icons->extension();

            if($category->icons) {
                Storage::delete('photos/' .$category->icons);
            }

            try {
                Storage::putFileAs('photos',$request->icons,$fileName.'.'.$extension);
                $category->icons = $fileName.'.'.$extension;
                $category->name_category = $request->input('name_category');
                $category->save();

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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category,$id)
    {
        $category = Category::find($id);
        if($category->icons) {
            Storage::delete('photos/' .$category->icons);
        }
        $category->delete();
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