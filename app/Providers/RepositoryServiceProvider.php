<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\TaskInterface;
use App\Repositories\TaskRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskInterface::class, TaskRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
