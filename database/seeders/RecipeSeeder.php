<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Ingredient;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipes = [
            [
                "name" => "Limonada",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2Flimonada.jpeg?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 5,
                "how_to_cook" => [
                    "Esprema os limões em uma jarra",
                    "Coloque a água",
                    "Adicione o açúcar",
                    "Misture tudo"
                ],
                "category_id" => 2,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "Limão",
                        "quantity" => 5,
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "Água",
                        "quantity" => 1,
                        "measure" => "litro"
                    ],
                    [
                        "name" => "Açúcar",
                        "quantity" => 3,
                        "measure" => "colher de chá"
                    ]
                ]
            ],
            [
                "name" => "Suco de laranja",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2Flaranja.png?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 15,
                "how_to_cook" => [
                    "Esprema as laranjas em uma jarra",
                    "Coloque a água",
                    "Adicione o açúcar",
                    "Misture tudo"
                ],
                "category_id" => 2,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "Laranja",
                        "quantity" => 5,
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "Água",
                        "quantity" => 1,
                        "measure" => "litro"
                    ],
                    [
                        "name" => "Açúcar",
                        "quantity" => 5,
                        "measure" => "colher de chá"
                    ]
                ]
            ],
            [
                "name" => "Salada de legumes",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 30,
                "how_to_cook" => [
                    "Corte as cenouras em rodelas",
                    "Cozinhe as cenouras até ficarem macias",
                    "Fervente a ervilha",
                    "Cozinhe o brócolis",
                    "Pique o alface",
                    "Misture todos os ingredientes"
                ],
                "category_id" => 9,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "cenoura",
                        "quantity" => "3",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "brócolis",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "ervilha",
                        "quantity" => "150",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "folha de alface",
                        "quantity" => "5",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Salada de batata com maionese",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 30,
                "how_to_cook" => [
                    "Descasque as batatas e pique em cubos, leve para cozinhar até que fiquem macias",
                    "Escorra a água das batatas",
                    "Misture a maionese nas batatas com o sal e o cheiro verde"
                ],
                "category_id" => 9,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "batata",
                        "quantity" => "500",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "maionese",
                        "quantity" => "200",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "cheiro verde",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Salada tropical",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 40,
                "how_to_cook" => [
                    "Corte todos os ingredientes em cubos",
                    "Cozinhe a cenoura e o brócolis até ficarem macios",
                    "Escorra a água e misture todos os ingredientes e tempere com sal"
                ],
                "category_id" => 9,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "Pé de alface",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "Pepino",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "cenoura",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "brócolis",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "tomate",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "manga",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "cebola",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Carne de panela",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 40,
                "how_to_cook" => [
                    "Corte a cebola, a cenoura e o alho em cubos",
                    "Em uma panela, coloque o óleo e doure a cebola e o alho",
                    "Acrescente a carne e deixe cozinhar acrescentando água quando necessário",
                    "Acrescente sal",
                    "Quando a carne estiver quase cozida, acrescente a cenoura e a batata e deixe cozinhar"
                ],
                "category_id" => 4,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "carne de vaca",
                        "quantity" => "1000",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "cebola",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "dente de alho",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "óleo",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "cenoura",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "batata",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Escondidinho de frango",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 60,
                "how_to_cook" => [
                    "Cozinhe o frango e desfie",
                    "Cozinhe a batata e amasse",
                    "Corte o dente de alho",
                    "Prepare um purê de batatas misturando a batata cozida e amassada com a manteiga e o sal em uma panela no fogo",
                    "Em uma panela, frite o alho e acrescente o frango desfiado, o sal e o molho de tomate",
                    "Em um refratário, monte camdas de purê de batata e frando, alternando-as e finalize com a muçarela",
                    "Leve ao forno pré-aquecido por 15 minutos"
                ],
                "category_id" => 4,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "peito de frango",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "batata",
                        "quantity" => "1000",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "dente de alho",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "manteiga",
                        "quantity" => "1",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "molho de tomate",
                        "quantity" => "500",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "queijo muçarela",
                        "quantity" => "100",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Estrogonofe",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 40,
                "how_to_cook" => [
                    "Corte em cubos a cebola, alho e frango",
                    "Em uma panela, frite o alho e a cebola e acrescente o frango, deixe cozinhar",
                    "Após o frango cozido acrescente o extrado de tomate e mexa",
                    "Acrescente a manteiga e mexa até derreter",
                    "Acrescente a farinha e mexa até a farinha dourar",
                    "Acrescente o leite e mexa até formar uma mistura cremosa",
                    "Acrescente o creme de leite e acerte o tempero"
                ],
                "category_id" => 4,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "peito de frango",
                        "quantity" => "1000",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "cebola",
                        "quantity" => "0.5",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "dente de alho",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "extrato de tomate",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "manteiga",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "farinha de trigo",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "leite",
                        "quantity" => "2",
                        "measure" => "copo americano"
                    ],
                    [
                        "name" => "creme de leite",
                        "quantity" => "0.5",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Purê de batatas",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 40,
                "how_to_cook" => [
                    "Amasse a batata (se preferir um purê mais fino passe em uma peneira)",
                    "Coloque em uma panela o azeite e acrescente a batata, o leite e o sal",
                    "Misture por volta de 3 minutos até ficar uma mistura homogênea",
                    "Retire do fogo e acrescente a cebolinha"
                ],
                "category_id" => 11,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "batata",
                        "quantity" => "4",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "azeite",
                        "quantity" => "3",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "leite",
                        "quantity" => "1",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "cebolinha",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0.5",
                        "measure" => "colher de sobremesa"
                    ],
                ],
            ],
            [
                "name" => "Arroz branco",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 20,
                "how_to_cook" => [
                    "Em uma panela, aqueça o óleo e frite o alho",
                    "Adicione o arroz e mexa até ficar brilhante",
                    "Coloque 3 xícaras de água fervente e acrescente o sal e mistute",
                    "Cozinhe em fogo baixo até a água secar completamente"
                ],
                "category_id" => 11,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "Óleo",
                        "quantity" => "1",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "dente de alho",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "Arroz",
                        "quantity" => "1.5",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0.5",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "Água",
                        "quantity" => "3",
                        "measure" => "xícara de chá"
                    ],
                ],
            ],
            [
                "name" => "Feijão tropeiro",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 40,
                "how_to_cook" => [],
                "category_id" => 11,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "farinha de mandioca",
                        "quantity" => "1",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "bacon",
                        "quantity" => "250",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "calabresa",
                        "quantity" => "300",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "cebola",
                        "quantity" => "0.5",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "cebolinha",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "ovo",
                        "quantity" => "3",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "feijão cozido",
                        "quantity" => "3",
                        "measure" => "xícaras de chá"
                    ],
                    [
                        "name" => "óleo",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                ],
            ],
            [
                "name" => "Pudim de leite condensado",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 60,
                "how_to_cook" => [
                    "Prepare a calda com o açúcar",
                    "Hidrate a gelatina conforme a embalagem e dissolva-a no leite",
                    "Coloque o leite condensado, o creme de leite, o leite com a gelatina e bata bem até formar uma mistura homogênea",
                    "Despeje a mistura na forma e leve para a geladeira por 4 horas",
                    "Desenform em um prato"
                ],
                "category_id" => 5,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "leite condensado",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "creme de leite",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "leite",
                        "quantity" => "1",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "gelatina sem sabor",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "acúcar",
                        "quantity" => "3",
                        "measure" => "colher de sopa"
                    ],
                ],
            ],
            [
                "name" => "Torta de bis",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 10,
                "cooking_time" => 40,
                "how_to_cook" => [
                    "Misture o creme de leite e o doce de leite e coloque em uma travessa",
                    "Triture os bis e coloque por cima",
                    "Leve a torta na geladeira por 2 horas"
                ],
                "category_id" => 3,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "doce de leite",
                        "quantity" => "500",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "creme de leite",
                        "quantity" => "4",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "caixa de bis",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Molho pesto",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 20,
                "cooking_time" => 20,
                "how_to_cook" => [],
                "category_id" => 9,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "manjericão",
                        "quantity" => "2",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "noz",
                        "quantity" => "3",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "queijo parmesão",
                        "quantity" => "1",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "dente de alho",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "azeite",
                        "quantity" => "1.5",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Molho branco",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 4,
                "cooking_time" => 15,
                "how_to_cook" => [
                    "Dissolva a farinha de trigo em meia xícara de leite e reserve",
                    "Coloque em uma panela a manteiga, o alho e a cebola e deixe dourar",
                    "Adicione o leite com a farinha e mexa",
                    "Adicione o restante do leite, mexa até levantar fervura e engrossar"
                ],
                "category_id" => 9,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "leite",
                        "quantity" => "2",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "manteiga",
                        "quantity" => "2",
                        "measure" => "colher de chá"
                    ],
                    [
                        "name" => "dente de alho",
                        "quantity" => "2",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "cebola",
                        "quantity" => "0.5",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "farinha de trigo",
                        "quantity" => "2",
                        "measure" => "colher de sopa"
                    ],
                    [
                        "name" => "Sal",
                        "quantity" => "0",
                        "measure" => "unidade"
                    ],
                ],
            ],
            [
                "name" => "Pão de queijo",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 18,
                "cooking_time" => 50,
                "how_to_cook" => [
                    "Misture em uma tigela o polvilho azedo, o creme de leite e o queijo",
                    "Adicione o sal e misture",
                    "Enrole as bolinhas e coloque em um tabuleiro untado com óleo",
                    "Pré-aqueça o forne e asse por 40 minutos"
                ],
                "category_id" => 6,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "creme de leite",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "queijo ralado",
                        "quantity" => "1",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "polvilho azedo",
                        "quantity" => "1",
                        "measure" => "xícara de chá"
                    ],
                    [
                        "name" => "sal",
                        "quantity" => "0.25",
                        "measure" => "colher de chá"
                    ],
                ],
            ],
            [
                "name" => "Suco de abacaxi, maçã e gengibre",
                "image" => env("STORAGE_URL")."/public%2Frecipes%2F{image}?alt=media",
                "number_of_servings" => 8,
                "cooking_time" => 10,
                "how_to_cook" => [
                    "Bata todos os ingredientes no liquidificador"
                ],
                "category_id" => 2,
                "user_id" => 1,
                "ingredients" => [
                    [
                        "name" => "rodelas de abacaxi",
                        "quantity" => "4",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "maça",
                        "quantity" => "1",
                        "measure" => "unidade"
                    ],
                    [
                        "name" => "gengibre",
                        "quantity" => "2",
                        "measure" => "gramas"
                    ],
                    [
                        "name" => "água",
                        "quantity" => "1",
                        "measure" => "litro"
                    ],
                ],
            ]
        ];


        foreach($recipes as $recipe_array) {
            $ingredients = $recipe_array["ingredients"];
            unset($recipe_array["ingredients"]);
            $recipe = Recipe::create($recipe_array);
            $recipe->saveIngredients($ingredients);
        }
    }
}
