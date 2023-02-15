<?php

namespace App\Actions\Categories;

use App\Http\Resources\CanHaveChildCategoriesResource;
use App\Models\User;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueryBuilder\QueryBuilder;

class GetCanHaveChildCategories
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->get('{user}/categories/can-have-child-category', static::class)
            ->name('categories.can-have-child-category.index');
    }

    public function handle(User $user, ActionRequest $request)
    {
        return CanHaveChildCategoriesResource::collection(QueryBuilder::for($user->categories())
            ->doesntHave('items')
            ->orderByDesc('id')
            ->get()
            ->filter(fn($category) => $category->level < 4)
        );
    }
}
