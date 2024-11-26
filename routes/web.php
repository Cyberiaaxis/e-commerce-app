<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    ProductController,
    UserController,
    CartController,
    CustomerController,
    ContactController,
    AboutController,
    CategoryController,
    OrderController,
    RoleController,
    PermissionController,
    TicketController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Register web routes for your application.
| Routes will be assigned to the "web" middleware group.
|
*/

// Public Routes
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/best-customers', [CustomerController::class, 'index'])->name('best.customers');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/showRegisterForm', function () {
    return view('Staff.pages.registration');
})->name('showRegisterForm');
Route::post('/register', [UserController::class, 'createUser'])->name('register');

// Cart Routes
Route::post('/cart', [CartController::class, 'addToCart']);
Route::delete('/cart/{id}', [CartController::class, 'removeFromCart']);
Route::patch('/cart/{id}', [CartController::class, 'updateQuantity']);
Route::get('/cart', [CartController::class, 'viewCart']);


// Protected User Routes (Requires Authentication)
Route::middleware(['auth'])->group(
    function () {
        // dd(auth()->check());

        // User Management Routes
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'users'])->name('index');
            Route::get('{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('{id}', [UserController::class, 'update'])->name('update');
            Route::delete('{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Admin-Only Routes for Roles & Permissions
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', function () {
                return view('Staff.pages.dashboard');
            })->name('dashboard');

            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::resource('products', ProductController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('tickets', TicketController::class);
            // Define the assign-permission route correctly here
            Route::post('/roles/{role}/assign-permission', [RoleController::class, 'assignPermission'])
                ->name('roles.assign-permission');
            // Route::patch('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
        });

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    }
);


// Fallback Route (404 Page)
Route::fallback(function () {
    return view('errors.404');
});
