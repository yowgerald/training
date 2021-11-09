<?php

namespace App\Providers;

use App\Repository\AttendanceRepositoryInterface;
use App\Repository\Eloquent\AttendanceRepository;
use App\Repository\Eloquent\TeacherRepository;
use App\Repository\TeacherRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Repository\ClassUserRepositoryInterface;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\ClassUserRepository;

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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ClassUserRepositoryInterface::class, ClassUserRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
