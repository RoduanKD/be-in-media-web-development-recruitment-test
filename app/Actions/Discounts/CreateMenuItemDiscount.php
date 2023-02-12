<?php

namespace App\Actions\Discounts;

use App\Models\MenuItem;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateMenuItemDiscount
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->post('discount/menu-item/{menuItem}', static::class)->name('item-discount.update');
    }

    public function getControllerMiddleware(): array
    {
        return ['auth'];
    }

    public function authorize(ActionRequest $request)
    {
        return $request->menuItem->category->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'discount' => 'required|numeric|min:0|max:100',
        ];
    }

    public function asController(MenuItem $menuItem, ActionRequest $request): bool
    {
        return $this->handle($menuItem, $request->discount);
    }

    public function handle($category, $discount): bool
    {
        return $category->addDiscount($discount);
    }
}
