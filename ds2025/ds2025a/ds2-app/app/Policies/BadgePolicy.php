<?php

  namespace App\Policies;

  use App\Models\Badge;
  use App\Models\User;
  use Illuminate\Auth\Access\HandlesAuthorization;

  class BadgePolicy
  {
      use HandlesAuthorization;

      public function view(User $user, Badge $badge)
      {
          return $user->id === $badge->user_id;
      }

      public function update(User $user, Badge $badge)
      {
          return $user->id === $badge->user_id;
      }

      public function delete(User $user, Badge $badge)
      {
          return $user->id === $badge->user_id;
      }
  }
