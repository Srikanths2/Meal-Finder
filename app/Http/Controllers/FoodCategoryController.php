<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use App\Models\Category;
use App\Http\Requests\StoreFoodCategoryRequest;
use App\Http\Requests\UpdateFoodCategoryRequest;
use Illuminate\Http\Request;

class FoodCategoryController extends Controller
{
    /**
     * GET all food items with category relationship
     */
    public function index()
    {
        $categories = FoodCategory::with('category:id,name')->get(); // eager load related category name
        return response()->json($categories, 200);
    }

    /**
     * GET by category name only
     */
    // public function showByCategory($categoryName)
    // {
    //     $categories = FoodCategory::whereHas('category', function ($query) use ($categoryName) {
    //         $query->whereRaw('LOWER(name) = ?', [strtolower($categoryName)]);
    //     })->with('category:id,name')->get();

    //     if ($categories->isEmpty()) {
    //         return response()->json(['message' => 'No matching categories found'], 404);
    //     }

    //     return response()->json($categories, 200);
    // }
    public function showByCategory($categorys)
    {
        // First, find the category by name (case insensitive)
        $category = Category::where('name', $categorys)->first();
       
    
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
    
        // Now get all food items with that category_id
        $items = FoodCategory::where('category_id', $category->id)
            ->get();
    
        if ($items->isEmpty()) {
            return response()->json(['message' => 'No items found in this category'], 404);
        }
    
        return response()->json($items, 200);
    }
    



    public function show($id)
    {
        $item = FoodCategory::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item, 200);
    }

    /**
     * GET by category name AND partial food item name
     */
    // public function showByCategoryAndName($categoryName, $name)
    // {
    //     $items = FoodCategory::whereHas('category', function ($query) use ($categoryName) {
    //         $query->whereRaw('LOWER(name) = ?', [strtolower($categoryName)]);
    //     })
    //     ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%'])
    //     ->with('category:id,name')
    //     ->get();

    //     if ($items->isEmpty()) {
    //         return response()->json(['message' => 'No matching items found in this category'], 404);
    //     }

    //     return response()->json($items, 200);
    // }

    /**
     * POST create new food item
     */
    public function store(StoreFoodCategoryRequest $request)
    {
        $validated = $request->validated();

        // Handle file upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        $category = FoodCategory::create($validated);

        return response()->json([
            'message' => 'Category item created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * PUT update food item
     */
    public function update(UpdateFoodCategoryRequest $request, $id)
    {
        $categoryRecord = FoodCategory::find($id);

        if (!$categoryRecord) {
            return response()->json(['error' => 'Category item not found'], 404);
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
            'message' => 'Category item updated successfully',
            'data' => $categoryRecord
        ], 200);
    }

    /**
     * DELETE food item
     */
    public function destroy($id)
    {
        $categoryRecord = FoodCategory::find($id);

        if (!$categoryRecord) {
            return response()->json(['error' => 'Category item not found'], 404);
        }

        $categoryRecord->delete();

        return response()->json(['message' => 'Category item deleted successfully'], 200);
    }

    /**
     * TOGGLE active status of a food item
     */
    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'active' => 'required|boolean',
        ]);

        $category = FoodCategory::findOrFail($id);
        $category->active = $request->active;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category status updated successfully.',
            'active' => $category->active
        ]);
    }
}
