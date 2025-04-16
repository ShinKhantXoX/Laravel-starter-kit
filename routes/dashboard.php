<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermissionEnum;
use App\Enums\PermissionEnum;
use App\Http\Controllers\Dashboard\{
    AuthController,
    UserController,
    LadiesController,
    RoomController,
    RoomTypeController,
    SectionController,
    EmployeeController,
    BedController,
    MenuCategoryController,
    MenuController,
    OrderController,
    OrderListController,
};


Route::prefix('v1')->group(function () {

    Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    // For Password Reset Form
    Route::get('/auth/reset-password/{token}', function ($token) {
        return view('auth.passwords.reset', ['token' => $token]);
    })->name('password.reset');
    Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
    Route::get('/auth/send-test-email', [AuthController::class, 'sendTestEmail'])->name('sendTestEmail');


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('refresh-token', [AuthController::class, 'refresh'])
            ->name('refresh');
    });

    Route::prefix('me')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', function () {
            return response()->json('OK');
        })->name('test');
    });    
    

    // Protect routes with Sanctum authentication middleware
    Route::middleware('auth:sanctum')->group(function () {
        // Route to get the authenticated user's information

        Route::group(['middleware' => ['role:MANAGER']], function () { 

            // Route::controller(UserController::class)->prefix('users')->group(function () {
            //     Route::get('/', 'index');  // List all users
            //     Route::post('/', 'store');         // Create a new user
            //     Route::get('/{id}', 'show');         // Get a specific user
            //     Route::put('/{id}', 'update');     // Update a user
            //     Route::delete('/{id}', 'destroy');  // Delete a user
            // });

        });

        Route::controller(UserController::class)->prefix('users')->group(function () {
                Route::get('/', 'index');  // List all users
                Route::post('/', 'store');         // Create a new user
                Route::get('/{id}', 'show');         // Get a specific user
                Route::put('/{id}', 'update');     // Update a user
                Route::delete('/{id}', 'destroy');  // Delete a user
                Route::get('/authority/permissions', 'getUserPermissions');
        });

    
        Route::controller(LadiesController::class)->prefix('ladies')->group(function () {
            Route::get('/', 'index');          // List all ladies
            Route::post('/', 'store');        // Create a new lady
            Route::get('/{id}', 'show');      // Get a specific lady
            Route::put('/{id}', 'update');    // Update a lady
            Route::delete('/{id}', 'destroy');// Delete a lady
        });

        Route::controller(RoomController::class)->prefix('rooms')->group(function () {
            Route::get('/', 'index');          // List all rooms
            Route::post('/', 'store');        // Create a new room
            Route::get('/{id}', 'show');      // Get a specific room
            Route::put('/{id}', 'update');    // Update a room
            Route::delete('/{id}', 'destroy');// Delete a room
        });

        Route::controller(BedController::class)->prefix('beds')->group(function () {
            Route::get('/', 'index');          // List all rooms
            Route::post('/', 'store');        // Create a new room
            Route::get('/{id}', 'show');      // Get a specific room
            Route::put('/{id}', 'update');    // Update a room
            Route::delete('/{id}', 'destroy');// Delete a room
        });

        Route::controller(RoomTypeController::class)->prefix('room-types')->group(function () {
            Route::get('/', 'index');          // List all rooms
            Route::post('/', 'store');        // Create a new room
            Route::get('/{id}', 'show');      // Get a specific room
            Route::put('/{id}', 'update');    // Update a room
            Route::delete('/{id}', 'destroy');// Delete a room
        });

        Route::controller(SectionController::class)->prefix("sections")->group(function () {
            Route::get('/', 'index');          // List all sections
            Route::post('/', 'store');         // Create a new section
            Route::get('/{id}', 'show');       // Get a specific section
            Route::put('/{id}', 'update');     // Update a section
            Route::delete('/{id}', 'destroy'); // Delete a section
        });

        Route::controller(EmployeeController::class)->prefix("employees")->group(function () {
            Route::get('/', 'index');          // List all sections
            Route::post('/', 'store');         // Create a new section
            Route::get('/{id}', 'show');       // Get a specific section
            Route::post('/{id}', 'update');     // Update a section
            Route::delete('/{id}', 'destroy'); // Delete a section
        });

        Route::controller(MenuCategoryController::class)->prefix("menu-category")->group(function () {
            Route::get('/', 'index');          // List all sections
            Route::post('/', 'store');         // Create a new section
            Route::get('/{id}', 'show');       // Get a specific section
            Route::put('/{id}', 'update');     // Update a section
            Route::delete('/{id}', 'destroy'); // Delete a section
        });

        Route::controller(MenuController::class)->prefix("menu")->group(function () {
            Route::get('/', 'index');          // List all sections
            Route::post('/', 'store');         // Create a new section
            Route::get('/{id}', 'show');       // Get a specific section
            Route::post('/{id}', 'update');     // Update a section
            Route::delete('/{id}', 'destroy'); // Delete a section
        });

        Route::controller(OrderController::class)->prefix("order")->group(function () {
            Route::get('/', 'index');          // List all sections
            Route::post('/', 'store');         // Create a new section
            Route::get('/{id}', 'show');       // Get a specific section
            Route::put('/{id}', 'update');     // Update a section
            Route::delete('/{id}', 'destroy'); // Delete a section
        });

        Route::controller(OrderListController::class)->prefix("order-list")->group(function () {
            Route::get('/', 'index');          // List all sections
            Route::post('/', 'store');         // Create a new section
            Route::get('/{id}', 'show');       // Get a specific section
            Route::put('/{id}', 'update');     // Update a section
            Route::delete('/{id}', 'destroy'); // Delete a section
        });

    });

});
