<?php

namespace App\Actions\MenuItems;

use App\Http\Resources\MenuItemsResource;
use App\Models\Category;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueryBuilder\QueryBuilder;

class GetMenuItems
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->get('/categories/{category}/menu-items', self::class)->name('menu-items.index');
    }

    public function handle(Category $category, ActionRequest $request)
    {
        return MenuItemsResource::collection(QueryBuilder::for($category->items())
            ->orderByDesc('id')
            ->allowedSorts(['name', 'price', 'discount_price'])
            ->allowedFilters('slug')
            ->paginate()
        );
    }
}
