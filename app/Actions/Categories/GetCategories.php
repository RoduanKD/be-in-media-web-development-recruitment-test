<?php

namespace App\Actions\Categories;

use App\Http\Resources\CategoriesResource;
use App\Models\Category;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueryBuilder\QueryBuilder;

class GetCategories
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->get('categories', static::class)->name('categories.index');
    }

    public function handle(ActionRequest $request)
    {
        return CategoriesResource::collection(QueryBuilder::for(Category::class)
            ->scopes('topLevel')
            ->with('children')
            ->orderByDesc('id')
            ->allowedSorts('name')
            ->allowedFilters('slug')
            ->paginate()
        );
    }
}
