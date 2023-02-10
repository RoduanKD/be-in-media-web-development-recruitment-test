<?php

namespace App\Actions\Categories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewCategory
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->post('categories', static::class)->name('categories.store');
    }

    public function getControllerMiddleware(): array
    {
        return ['auth'];
    }

    public function prepareForValidation(ActionRequest $request): void
    {
        if ($request->parent_id && is_numeric($request->parent_id)) {
            $parentLevel = Category::find($request->parent_id, ['id', 'parent_id'])->level;
            $request->merge(['level' => $parentLevel + 1]);
        }
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|min:1|max:255',
            'parent_id' => 'nullable|numeric|exists:categories,id',
            'level'     => 'nullable|numeric|lte:4',
        ];
    }

    public function jsonResponse(Category $article): CategoryResource
    {
        return CategoryResource::make($article);
    }

    public function asController(ActionRequest $request): Category
    {
        return $this->handle(auth()->user(), $request->validated());
    }

    public function handle(User $user, array $data): Category
    {
        return $user->categories()->create($data);
    }
}
