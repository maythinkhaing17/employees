<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EmployeeInterface;
use App\Repositories\EmployeeRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
    }

}
