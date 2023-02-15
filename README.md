<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Be In Media - Web development Recruitment test

This is the backend of the restaurant menu.

### Features & Technologies

Please Note that I did **NOT** cover the cases that aren't mentioned in the requirements (such as update/delete items)
file since the purpose of the project is to showcase the code structure and not to release a project. However, all
requirements that are mentioned in the file are covered here. To get started quickly I used **Laravel Breeze (API)** to
scaffold the project and focus on what matters.

### API Structure

| Method | Url                                                | Description                                           |
|--------|----------------------------------------------------|-------------------------------------------------------|
| GET    | `api/user`                                         | Get currently authenticated user                      |
| POST   | `api/v1/categories`                                | Store category                                        |
| GET    | `api/v1/categories/{category}/menu-items`          | Get menu Items of a category                          |
| POST   | `api/v1/discount/category/{category}`              | Add discount to a category                            |
| POST   | `api/v1/discount/global`                           | Add global discount                                   |
| POST   | `api/v1/discount/menu-item/{menuItem}`             | Add discount to menu item                             |
| POST   | `api/v1/menu-items`                                | Add menu item                                         |
| GET    | `api/v1/{user}/categories`                         | Get categories of a user                              |
| GET    | `api/v1/{user}/categories/can-have-child-category` | Get items for category selector (in category create)  |
| GET    | `api/v1/{user}/categories/can-have-menu-items`     | Get items for category selector (in menu item create) |

### Installation guide

1. Clone this repo
2. `composer install`
3. `cp .env.example .env`
4. update the `DATABASE` values in `.env`
5. `php artisan migrate --seed --seeder=DemoSeeder`
6. `php artisan serve`

### Testing

In this project, every single api is tested with the required tests that insures that it's working as it's intended to
do especially the ones mentioned in the requirements file

To run the tests use this command
`php artisan test`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
