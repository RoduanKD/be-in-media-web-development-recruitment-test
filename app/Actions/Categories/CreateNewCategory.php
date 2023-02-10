<?php

namespace App\Actions\Categories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:255',
        ];
    }

    public function jsonResponse(Category $article): CategoryResource
    {
        return CategoryResource::make($article);
    }

    public function asController(Request $request): Category
    {
        return $this->handle(auth()->user(), $request->all());
    }

    public function handle(User $user, array $data): Category
    {
        return $user->categories()->create($data);
    }
}
