<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        Gate::authorize('view','products');

        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return ProductResource
     */
    public function show($id): ProductResource
    {
        Gate::authorize('view','products');

        return new ProductResource(Product::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        Gate::authorize('edit','products');

        $product = Product::create($request->only('title','desc','img','price'));

        return response($product, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('edit','products');

        $product = Product::find($id);

        $product->update($request->only('title','desc','img','price'));

        return response($product, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('edit','products');

        Product::destroy($id);

        return response(null,Response::HTTP_NO_CONTENT);
    }
}
