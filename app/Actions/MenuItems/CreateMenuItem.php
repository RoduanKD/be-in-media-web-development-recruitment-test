<?php

namespace App\Actions\MenuItems;

use Illuminate\Routing\Router;
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
}
