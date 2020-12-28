<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ["name" => "Aves"],
            ["name" => "Bebidas"],
            ["name" => "Bolos e Tortas"],
            ["name" => "Carnes"],
            ["name" => "Doces e Sobremesas"],
            ["name" => "Lanches"],
            ["name" => "Massas"],
            ["name" => "Peixes e Frutos do Mar"],
            ["name" => "Saladas e Molhos"],
            ["name" => "Sopas"],
        ];
        foreach($categories as $category) {
            Category::create($category);
        }
    }
}
