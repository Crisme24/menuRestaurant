<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAll()
    {
        try {
            //code...
            $categories = Category::with('products')->get();
            return response($categories);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchCategory($search)
    {
       $categories = Category::where('name', 'LIKE', "%$search%")->get();
        return $categories;
    }


    public function getOne($id)
    {
        try {
            $category = Category::find($id);
            return response ($category);
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
            $request->validate([
                'name' => 'required|unique:categories|string'
            ]);
            $body = $request->all();
            $category = Category::create($body);
            return response($category, 201);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'message' => 'There was a problem trying to create the category'
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            //code...
            $request->validate([
                'name' => 'required|unique:categories|string'
            ]);
            $body = $request->all();
            $category = Category::find($id);
            $category->update($body);
            return response([
                'category'=> $category,
                'message'=> 'Category succesfully updated',
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'error' => $e->getMessage(),
                'message' => 'There was a problem trying to update the category',
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            //code...
            $category = Category::find($id);
            $category->products()->detach();
            $category->delete();
            return response([
                'category'=> $category,
                'message'=> 'Category succesfully removed',
            ]);
        } catch (\Exception $e) {
            //throw $th;
            return response([
                'error' => $e->getMessage(),
                'message' => 'There was a problem trying to delete the category',
            ], 500);
        }
    }
}
