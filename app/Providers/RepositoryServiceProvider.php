<?php

namespace App\Providers;

use App\Repository\EloquentRepositoryInterface; 
use App\Repository\CompanyRepositoryInterface; 
use App\Repository\Eloquent\CompanyRepository; 
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\InvoiceRepository;
use App\Repository\InvoiceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
    }
}
