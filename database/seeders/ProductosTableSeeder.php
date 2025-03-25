<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;


class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Obtener todas las categorías
        $categorias = Category::all();

        $productos = [
            ['name' => 'Smartphone X', 'description' => 'Último modelo con cámara de 108MP', 'price' => 899.99, 'stock' => 50],
            ['name' => 'Laptop Pro', 'description' => '16GB RAM, 1TB SSD', 'price' => 1299.99, 'stock' => 30],
            ['name' => 'Camiseta Algodón', 'description' => '100% algodón orgánico', 'price' => 24.99, 'stock' => 100],
            ['name' => 'Sofá de Cuero', 'description' => 'Sofá de 3 plazas en cuero genuino', 'price' => 799.99, 'stock' => 15],
            ['name' => 'Balón de Fútbol', 'description' => 'Tamaño oficial FIFA', 'price' => 39.99, 'stock' => 75],
            ['name' => 'Set de Lego', 'description' => 'Edición especial con 1500 piezas', 'price' => 89.99, 'stock' => 40],
            ['name' => 'Aceite de Oliva', 'description' => 'Extra virgen, 1 litro', 'price' => 12.99, 'stock' => 200],
            ['name' => 'Vino Tinto Reserva', 'description' => 'Cosecha 2018, 750ml', 'price' => 29.99, 'stock' => 60],
            ['name' => 'Libro de Programación', 'description' => 'Aprende Laravel desde cero', 'price' => 45.99, 'stock' => 25],
            ['name' => 'Mesa de Centro', 'description' => 'Madera de roble macizo', 'price' => 199.99, 'stock' => 20],
            ['name' => 'Cortadora de Césped', 'description' => 'Motor a gasolina 140cc', 'price' => 249.99, 'stock' => 10],
            ['name' => 'Auriculares Inalámbricos', 'description' => 'Cancelación de ruido', 'price' => 149.99, 'stock' => 45],
            ['name' => 'Zapatillas Running', 'description' => 'Amortiguación premium', 'price' => 89.99, 'stock' => 60],
            ['name' => 'Juego de Sartenes', 'description' => 'Antiadherente de titanio', 'price' => 79.99, 'stock' => 35],
            ['name' => 'Raqueta de Tenis', 'description' => 'Peso ligero, grip ergonómico', 'price' => 129.99, 'stock' => 25]
        ];

        foreach ($productos as $producto) {
            Product::create([
                'name' => $producto['name'],
                'description' => $producto['description'],
                'price' => $producto['price'],
                'stock' => $producto['stock'],
                'category_id' => $categorias->random()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->command->info('¡Seeder de productos ejecutado correctamente!');
    }
}