<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryCollectionResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ResponseResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (new CategoryCollectionResource(Category::all()))
            ->additional(['message' => 'Berhasil']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Category::firstOrCreate($valid);
        if ($category != null) {
            return (new ResponseResource($category, 'Berhasil'))
                ->response()
                ->setStatusCode(201);
        }
        return (new ResponseResource(null, 'Gagal'))
            ->response()
            ->setStatusCode(400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category != null) {
            return (new CategoryResource($category))
                ->additional(['message' => 'Berhasil']);
        }
        return (new ResponseResource(null, 'Tidak ada'))
            ->response()
            ->setStatusCode(400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category == null) {
            return (new ResponseResource(null, 'Category tidak ada'))
                ->response()
                ->setStatusCode(400);;
        }
        if ($category->delete()) {
            return (new ResponseResource($category, 'Berhasil'))
                ->response()
                ->setStatusCode(204);
        }
        return (new ResponseResource(null, 'Gagal'))
            ->response()
            ->setStatusCode(400);;
    }
}
