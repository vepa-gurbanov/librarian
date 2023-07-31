<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Model::preventLazyLoading(!app()->isProduction());
        View::composer('*', function ($view) {
            $categories = Category::whereDoesntHave('parent')
                ->withCount('books')
                ->orderByDesc('books_count')
                ->get(['id', 'name', 'slug', 'books_count']);

            $authors = Author::withCount('books')
                ->orderByDesc('books_count')
                ->take(6)
                ->get(['id', 'name', 'slug', 'books_count']);

            $data = [
                'categories' => $categories,
                'authors' => $authors,
            ];

            return $view->with($data);
        });
    }
}
