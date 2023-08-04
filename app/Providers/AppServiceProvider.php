<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Shelf;
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
            $categories = Category::query()
                ->whereDoesntHave('parent')
                ->withCount('books')
                ->orderByDesc('books_count')
                ->get(['id', 'name', 'slug']);

            $shelves = Shelf::query()
                ->withCount('books')
                ->orderBy('name')
                ->get(['id', 'name']);

            $authors = Author::query()
                ->withCount('books')
                ->orderByDesc('books_count')
                ->take(6)
                ->get(['id', 'name', 'slug']);

            $available = config()->get('settings.languages');
            $locale = app()->getLocale();

            $data = [
                'categories' => $categories,
                'authors' => $authors,
                'shelves' => $shelves,
                'languages' => [
                    'locale' => $locale,
                    'available' => $available,
                ],
            ];

            return $view->with($data);
        });
    }
}
