<?php

namespace App\Http\Controllers;

use App\Models\Category; // Make sure to import the model at the top
use Illuminate\Http\Request;

class CategoryController extends Controller
{
        /**
     * GET: Fetch all categories from the categories table
     */
    public function getAllCategories()
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'Categories fetched successfully',
            'data' => $categories,
        ], 200);
    }
    /**
     * GET: Show a single category by ID
     */
    public function getCategoryById($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Category fetched successfully',
            'data' => $category,
        ], 200);
    }


        /**
     * POST: Add a new category to the categories table
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
        ]);

        return response()->json([
            'message' => 'Category added successfully',
            'data' => $category,
        ], 201);
    }
    /**
     * PUT/PATCH: Update an existing category
     */
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
        ]);

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        $category->name = $request->input('name');
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * DELETE: Delete a category
     */
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }


}
