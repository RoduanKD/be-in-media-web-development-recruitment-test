<?php

namespace App\Actions\Categories;

use App\Http\Resources\CategoriesResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueryBuilder\QueryBuilder;

class GetCategories
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->get('{user}/categories', static::class)->name('categories.index');
    }

    public function handle(User $user, ActionRequest $request)
    {
        return CategoriesResource::collection(QueryBuilder::for($user->categories())
            ->scopes('topLevel')
            ->with('children')
            ->orderByDesc('id')
            ->allowedSorts('name')
            ->allowedFilters('slug')
            ->paginate()
        );
    }
}
