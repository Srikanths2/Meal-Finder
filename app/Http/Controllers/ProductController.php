<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET all food items with category relationship
     */
    public function index()
    {
        $categories = Product::with('category:id,name')->get(); // eager load related category name
        return response()->json($categories, 200);
    }

    /**
     * GET by category name only
     */
    public function showByProduct($products)
    {
        // First, find the category by name (case insensitive)
        $category = Category::where('name', $products)->first();
       
    
        if (!$category) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Now get all food items with that category_id
        $items = Product::where('category_id', $category->id)
            ->get();
    
        if ($items->isEmpty()) {
            return response()->json(['message' => 'No Products found in this category'], 404);
        }
    
        return response()->json($items, 200);
    }


    public function show($id)
    {
        $item = Product::find($id);

        if (!$item) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($item, 200);
    }


    /**
     * POST create new food item
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Handle file upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        $category = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * PUT update food item
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $categoryRecord = Product::find($id);

        if (!$categoryRecord) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        $categoryRecord->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $categoryRecord
        ], 200);
    }

    /**
     * DELETE food item
     */
    public function destroy($id)
    {
        $categoryRecord = Product::find($id);

        if (!$categoryRecord) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $categoryRecord->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    /**
     * TOGGLE active status of a food item
     */
    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'active' => 'required|boolean',
        ]);

        $category = Product::findOrFail($id);
        $category->active = $request->active;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully.',
            'active' => $category->active
        ]);
    }
}
