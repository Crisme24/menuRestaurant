<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function getAll(){
        try {
            //code...
            $products = Product::with('categories')->get();
            return $products;
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'error'=> $e->getMessage()
            ], 500);
        }
    }

    public function searchProduct($search)
    {
       $search = Product::where('name', 'LIKE', "%$search%")->get();
        return $search;
    }

    public function getOne($id)
    {
        try {
            $product = Product::find($id);
            return response($product);
        } catch (\Exception $e) {
            return response([
                'error' => $e
            ], 500);
        }

    }


    public function insert(Request $request)
    {
        try {
            //code...
           // $categoriesIds = Category::all()->map(fn ($category) => $category->id)->toArray();
            $categoriesIds = Category::all()->map(function($category) {
                return $category->id;
            })->toArray();

            $body = $request->validate([
                'name' => 'required|string|max:50',
                'description' => 'string',
                'address' => 'required|string',
                'telephone' => 'required|string',
                'categories' => 'array|in:' . implode(',', $categoriesIds)
            ]);
            $body = $request->all();
            $product = Product::create($body);
            $product->categories()->attach($body['categories']);
            return response($product->load('categories'), 201);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'error'=> $e->getMessage(),
                'message'=> 'There was a problem to trying to created the product'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // $categoriesIds = Category::all()->map(function($category) {
            //     return $category->id;
            // })->toArray();

            $body = $request->validate([
                'name' => 'string|max:50',
                'description' => 'string',
                'address' => 'string',
                'telephone' => 'string',
                'image_path' => 'string',
                //'categories' => 'required|array|in:' . implode(',', $categoriesIds)
            ]);

            $product = Product::find($id);

            $product->update($body);

            if ($request->has('categories')) {
                $product->categories()->sync($body['categories']);
            }
            return response($product->load('categories'));

        } catch (\Exception $e) {
            //throw $th;
            return response([
                'error' => $e
            ], 500);
        }
    }

    public function uploadImage(Request $request, $id)
    {
        try {
            $request->validate(['img' => 'required|image']);
            // $request->validate(['imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
            $product = Product::find($id);//buscamos el producto a actualizar la ruta de la imagen
            $imageName = time() . '-' . request()->img->getClientOriginalName();//time() es como Date.now()
            request()->img->move('images/products', $imageName);//mueve el archivo subido al directorio indicado (en este caso public path es dentro de la carpeta public)
            $product->update(['image_path' => $imageName]);//actualizamos el image_path con el nuevo nombre de la imagen
            return response($product);
        } catch (\Exception $e) {
            return response([
                'error' => $e,
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::find($id);
            $product->delete();
            return response([
                'message' => 'Product successfully removed',
                'product' => $product
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'error' => $e
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $products = Product::withTrashed()->where('id', $id)->get();
            // dd($products);
            if ($products->isEmpty() || !$products[0]->trashed()) {
                return response([
                    'message' => 'Product not found'
                ], 400);
            }
            $product = $products[0];
            $product->restore();
            return response([
                'message' => 'Product successfully recovered',
                'product' => $product
            ], 400);
        } catch (\Exception $e) {
            return response([
                'error' => $e,
            ], 500);
        }
    }
}
