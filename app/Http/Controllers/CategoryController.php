<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    public function index(Request $request) {
        $query = Category::query();
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('id', 'like', '%' . $searchTerm . '%');
            });
        }        
        $categories = $query->paginate(10); 
        return response()->json($categories, 200);
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        try {
                Category::create($request->all());
                return response()->json(['message' => 'Categoría registrada con exito'], 201);
                              
        }catch(\Exception $e) {
            return response()->json([
                "message" => "Error al crear categoria.",
                "error" => $e->getMessage() 
            ], 500);
        }
    }

    public function show($id) {
        try {
            $Category = Category::find($id);
            if (!$Category) return response()->json(['message' => 'Categoría no encontrada'], 404);
            return response()->json($Category);
                          
        }catch(\Exception $e) {
            return response()->json([
                "message" => "Error al mostrar categoria.",
                "error" => $e->getMessage() 
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $Category = Category::find($id);
            if (!$Category) return response()->json(['message' => 'Categoría no encontrada'], 404);
            $request->validate(['name' => 'required|string|max:255']);
            $Category->update($request->all());
            return response()->json(['message' => 'Categoría editada con exito'], 200);
                          
        }catch(\Exception $e) {
            return response()->json([
                "message" => "Error al mostrar categoria.",
                "error" => $e->getMessage() 
            ], 500);
        }
    }

    public function destroy($id) {
        $Category = Category::find($id);
        if (!$Category) return response()->json(['message' => 'Categoría no encontrada'], 404);

        $Category->delete();
        return response()->json(['message' => 'Categoría eliminada con exito'],200);
    }
}
