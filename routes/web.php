<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MiniAdminController;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $rooms = Room::all()->pluck('name', 'id')->prepend(trans('Select...'), '');
    $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    $reservations = Reservation::where('status', 'accepted')->get();
    $events = [];

    foreach ($reservations as $reservation) {
        $events[] = [
            'title' => $reservation->event, // Use the event details
            'start' => $reservation->reservationDate . 'T' . $reservation->reservationTime,
            'end' => $reservation->reservationDate . 'T' . $reservation->timelimit,
            'room' => $reservation->room->name,
        ];
    }

    return view('welcome', compact('reservations', 'events'));
});

Route::get('/register', [AuthController::class, 'loadRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', function () {
    return redirect('/');
});
Route::get('/login', [AuthController::class, 'loadLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/login/validate', [AuthController::class, 'validateLogin'])->name('login.validate');


// ********** Super Admin Routes *********
Route::group(['prefix' => 'super-admin', 'middleware' => ['web', 'isSuperAdmin']], function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard']);

    Route::get('/users', [SuperAdminController::class, 'users'])->name('superAdminUsers');
    Route::get('/manage-role', [SuperAdminController::class, 'manageRole'])->name('manageRole');
    Route::post('/update-role', [SuperAdminController::class, 'updateRole'])->name('updateRole');
    Route::get('/reservation', [SuperAdminController::class, 'reservation'])->name('sadminreservation');
    Route::get('/reservationstatus', [SuperAdminController::class, 'changeStatus'])->name('changeStatus');
    Route::put('/users/{user}/update', [SuperAdminController::class, 'update'])->name('users.update');

    // web.php

    Route::patch('/admin/reservation/update/{id}', [SuperAdminController::class, 'updateReservationStatus'])
        ->name('superadmin.updateReservationStatus');
});

// ********** Sub Admin Routes *********
Route::group(['prefix' => 'sub-admin', 'middleware' => ['web', 'isSubAdmin']], function () {
    Route::get('/dashboard', [SubAdminController::class, 'dashboard']);
    Route::get('/resevation', [SubAdminController::class, 'reservation'])->name('subadminreservation');
    Route::put('/subadmin/reservation/update/{id}', [SubAdminController::class, 'updateReservationStatus'])->name('subadmin.update');
});

// ********** Admin Routes *********
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'isAdmin']], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/reservation', [AdminController::class, 'reservation'])->name('adminreservation');
    Route::put('/admin/reservation/update/{id}', [AdminController::class, 'updateReservationStatus'])->name('admin.update');
});
Route::middleware(['auth', 'miniadmin'])->group(function () {
    Route::get('/miniadmin/dashboard', [MiniAdminController::class, 'dashboard']);
    Route::get('/miniadmin/reservation', [MiniAdminController::class, 'reservation'])->name('miniadminreservation');
    Route::put('/miniadmin/reservation/update/{id}', [MiniAdminController::class, 'updateReservationStatus'])->name('miniadmin.update');



    // Routes accessible only to authenticated users with the MiniAdmin role
    // Define your MiniAdmin-specific routes here
});

// ********** User Routes *********
Route::group(['middleware' => ['web', 'isUser']], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/booking', [UserController::class, 'booking'])->name('booking');
    Route::get('/reservation', [UserController::class, 'reservation'])->name('reservation');
    Route::post('/booking', [ReservationController::class, 'store'])->name('submit.reservation');
});
Route::get('/get-bookings', [BookingController::class, 'getBookings']);
