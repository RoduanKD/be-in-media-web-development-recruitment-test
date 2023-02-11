<?php

namespace App\Actions\MenuItems;

use App\Http\Resources\MenuItemResource;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateMenuItem
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->post('menu-items', static::class)->name('menu-items.store');
    }

    public function getControllerMiddleware(): array
    {
        return ['auth'];
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:1|max:255',
            'price'       => 'required|numeric|min:1',
            'category_id' => 'nullable|numeric|exists:categories,id',
        ];
    }

    public function jsonResponse(MenuItem $menuItem): MenuItemResource
    {
        return MenuItemResource::make($menuItem);
    }

    public function asController(ActionRequest $request): MenuItem
    {
        return $this->handle($request->validated());
    }

    public function handle(array $data): MenuItem
    {
        return MenuItem::create($data);
    }
}
