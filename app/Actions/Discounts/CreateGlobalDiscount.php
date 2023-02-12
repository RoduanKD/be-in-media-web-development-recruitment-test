<?php

namespace App\Actions\Discounts;

use Illuminate\Routing\Router;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGlobalDiscount
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->post('discount/global', static::class)->name('global-discount.update');
    }

    public function getControllerMiddleware(): array
    {
        return ['auth'];
    }

    public function rules(): array
    {
        return [
            'discount' => 'required|numeric|min:0|max:100',
        ];
    }

    public function asController(ActionRequest $request): bool
    {
        return $this->handle($request->discount);
    }

    public function handle($discount): bool
    {
        /** @noinspection NullPointerExceptionInspection */
        return auth()->user()->addDiscount($discount);
    }
}
