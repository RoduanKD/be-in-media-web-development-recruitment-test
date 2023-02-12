<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create();
        Category::factory(null, ['user_id' => $user->id])->has(MenuItem::factory(3), 'items')->create();

        Category::factory(null, ['user_id' => $user->id])
            ->has(Category::factory(2, ['user_id' => $user->id])
                ->has(MenuItem::factory(3), 'items')
                , 'children')
            ->create();

        Category::factory(null, ['user_id' => $user->id])
            ->has(Category::factory(null, ['user_id' => $user->id])
                ->has(Category::factory(null, ['user_id' => $user->id])
                    ->has(MenuItem::factory(3), 'items')
                    , 'children')
                , 'children')
            ->create();

        Category::factory(2, ['user_id' => $user->id])
            ->has(Category::factory(3, ['user_id' => $user->id])
                ->has(Category::factory(2, ['user_id' => $user->id])
                    ->has(Category::factory(2, ['user_id' => $user->id])
                        ->has(MenuItem::factory(10), 'items')
                        , 'children')
                    , 'children')
                , 'children')
            ->create();
    }
}
