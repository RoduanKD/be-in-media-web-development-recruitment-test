<?php

namespace App\Actions\Discounts;

use App\Models\Category;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCategoryDiscount
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->post('discount/category/{category}', static::class)->name('category-discounts.update');
    }

    public function getControllerMiddleware(): array
    {
        return ['auth'];
    }

    public function authorize(ActionRequest $request)
    {
        return $request->category->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'discount' => 'required|numeric|min:0|max:100',
        ];
    }

    public function asController(Category $category, ActionRequest $request): bool
    {
        return $this->handle($category, $request->discount);
    }

    public function handle($category, $discount): bool
    {
        return $category->addDiscount($discount);
    }
}
