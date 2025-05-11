<?php

  namespace App\Providers;

  use App\Models\Badge;
  use App\Policies\BadgePolicy;
  use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

  class AuthServiceProvider extends ServiceProvider
  {
      protected $policies = [
          Badge::class => BadgePolicy::class,
      ];

      public function boot()
      {
          $this->registerPolicies();
      }
  }