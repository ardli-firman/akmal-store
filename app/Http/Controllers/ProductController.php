<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Resources\CustomerOrderCollectionResource;
use App\Http\Resources\CustomerOrderResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderResourceCollection;
use App\Http\Resources\ProductCollectionResource;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ResponseResource;
use App\Order;
use Illuminate\Support\Str;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $imgPath;

    public function __construct()
    {
        $this->imgPath = storage_path('product_image');
    }

    public function index()
    {
        return (new ProductCollectionResource(Product::all()))
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required',
            'measure' => 'required',
            'image' => 'required|image'
        ]);
        $imageName = Str::random(32);
        $request->image->move($this->imgPath, $imageName);
        $valid['image'] = $imageName;
        $product = Product::firstOrCreate($valid);
        if ($product != null) {
            return (new ResponseResource($product, 'Berhasil'))
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($productId)
    {
        $product = Product::find($productId);
        if ($product != null) {
            return (new ProductResource($product))
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productId)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        $product = Product::find($productId);
        if ($product == null) {
            return (new ResponseResource(null, 'Product tidak ada'))
                ->response()
                ->setStatusCode(400);;
        }
        $img = $this->imgPath . "\\" . $product->image;
        if (file_exists($img)) {
            unlink($img);
            if ($product->delete()) {
                return (new ResponseResource($product, 'Berhasil'))
                    ->response()
                    ->setStatusCode(204);
            }
        }
        return (new ResponseResource(null, 'Gagal'))
            ->response()
            ->setStatusCode(400);;
    }

    public function showImage($imageName)
    {
        $filePath = $this->imgPath . "\\" . $imageName;
        if (file_exists($filePath)) {
            $file = file_get_contents($filePath);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }
        return (new ResponseResource(null, 'Tidak ada'))
            ->response()
            ->setStatusCode(404);
    }
}
