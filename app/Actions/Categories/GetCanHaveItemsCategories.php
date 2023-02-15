<?php

namespace App\Actions\Categories;

use App\Http\Resources\CanHaveChildCategoriesResource;
use App\Models\User;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueryBuilder\QueryBuilder;

class GetCanHaveItemsCategories
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->get('{user}/categories/can-have-menu-items', static::class)
            ->name('categories.can-have-menu-items.index');
    }

    public function handle(User $user, ActionRequest $request)
    {
        return CanHaveChildCategoriesResource::collection(QueryBuilder::for($user->categories())
            ->doesntHave('children')
            ->orderByDesc('id')
            ->get()
        );
    }
}
