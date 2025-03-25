<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriasTableSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Electrónica',
            'Ropa',
            'Hogar',
            'Deportes',
            'Juguetes',
            'Alimentos',
            'Bebidas',
            'Libros',
            'Muebles',
            'Jardín'
        ];

        foreach ($categorias as $categoria) {
            Category::create([
                'name' => $categoria,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->command->info('¡Seeder de categorías ejecutado correctamente!');
    }
}