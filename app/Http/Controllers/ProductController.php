<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                if (is_numeric($searchTerm)) {
                    $q->orWhere('id', $searchTerm);
                }
                $q->orWhere('name', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('category', function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }
        $query->orderBy('id', 'desc');
        return $query->paginate(10);
    }

    public function store(Request $request) {
      

        $request->validate(['name' => 'required|string|max:255']);
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'descripiion' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
            ]);
    
            $Product = Product::create($request->all());
            return response()->json($Product, 201);
                              
        }catch(\Exception $e) {
            return response()->json([
                "message" => "Error al crear product.",
                "error" => $e->getMessage() 
            ], 500);
        }
    }

    public function show($id) {
       
        try {
            $Product = Product::with('category')->find($id);
            if (!$Product) return response()->json(['message' => 'Product no encontrado'], 404);
            return response()->json($Product);
    
        }catch(\Exception $e) {
            return response()->json([
                "message" => "Error al mostrar product.",
                "error" => $e->getMessage() 
            ], 500);
        }
    }

    public function update(Request $request, $id) {
       

        try {
            $Product = Product::find($id);
            if (!$Product) return response()->json(['message' => 'Product no encontrado'], 404);
    
            $request->validate([
                'name' => 'required|string|max:255',
                'descripiion' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
            ]);
    
            $Product->update($request->all());
            return response()->json(['message' => 'Product editada con exito'], 200);
                          
        }catch(\Exception $e) {
            return response()->json([
                "message" => "Error al mostrar Product.",
                "error" => $e->getMessage() 
            ], 500);
        }

    }

    public function destroy($id) {
        $Product = Product::find($id);
        if (!$Product) return response()->json(['message' => 'Product no encontrado'], 404);

        $Product->delete();
        return response()->json(['message' => 'Product eliminada con exito'],200);
    }
}
