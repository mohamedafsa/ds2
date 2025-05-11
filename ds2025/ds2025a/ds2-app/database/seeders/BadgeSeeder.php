<?php
namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User; // Likely imported
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        // Create a user to associate with badges
        $user = User::factory()->create(); // This line caused the error

        // Create badges
        $badge = Badge::create([
            'name' => 'First Goal Achiever',
            'description' => 'Awarded for completing your first goal.',
        ]);

        // Possibly associate the badge with the user via badge_user_goal
        $user->badges()->attach($badge->id, [
            'goal_id' => 1, // Assuming a goal exists
            'awarded_at' => now(),
        ]);
    }
}