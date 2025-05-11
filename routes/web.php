<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\WebGoalController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoalController;

Route::middleware('web')->group(function () {
    // Page d'accueil
    Route::get('/', function () {
        return view('dashboard');
    });

    // Routes d'authentification
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::middleware('auth')->group(function () {
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    });
    
    // Routes protégées par auth
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Routes pour les objectifs (goals)
        Route::get('/goals', [WebGoalController::class, 'index'])->name('goals.index');
        Route::get('/goals/create', [WebGoalController::class, 'create'])->name('goals.create');
        Route::post('/goals', [WebGoalController::class, 'store'])->name('goals.store');
        Route::get('/goals/{goal}', [WebGoalController::class, 'show'])->name('goals.show')->middleware('ensure.user.owns.goal');
        Route::delete('/goals/{goal}', [WebGoalController::class, 'destroy'])->name('goals.destroy')->middleware('ensure.user.owns.goal');
        Route::post('/goals/{goal}/update-progress', [WebGoalController::class, 'updateProgress'])->name('goals.updateProgress')->middleware('ensure.user.owns.goal');
        Route::post('/goals/{goal}/steps', [StepController::class, 'store'])->name('steps.store')->middleware('ensure.user.owns.goal');

        // Autres routes protégées
        Route::get('/maps', [MapController::class, 'index'])->name('maps.index');
        Route::post('/map-pins', [MapController::class, 'store'])->name('maps.store');

        //Route::post('/maps', [MapController::class, 'store'])->name('maps.store');

        Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline.index');
        Route::post('/timeline', [TimelineController::class, 'store'])->name('timeline.store');

        Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
        Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');

        Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
        Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
        Route::post('/groups/{group}/join', [GroupController::class, 'join'])->name('groups.join');
        Route::post('/groups/{group}/add-goal', [GroupController::class, 'addGoal'])->name('groups.addGoal');

        Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
        Route::post('/friends/request', [FriendController::class, 'request'])->name('friends.request');
        Route::post('/friends/{friend}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    });
   
Route::post('/suggest-steps', [GoalController::class, 'suggestSteps'])->middleware('auth');



Route::get('/test', function () {
    return 'Test OK';
});
});
