<?php

use App\Exports\UsersExport;
use App\Http\Controllers\ActivationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DataImportController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GuestBookingController;
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
    $roomColors = [
        'Kifaru' => 'Orange',
        'Shark Tank Boardroom' => 'blue',
        'Executive Boardroom' => 'green',
        'Oracle Lab' => 'black',
        'Safaricom Lab' => 'black',
        'Ericsson Lab' => 'black',
        'Small Meeting Room' => 'purple',
        'Samsung Lab' => 'black'


        // Add more rooms and colors as needed
    ];

    foreach ($reservations as $reservation) {
        $roomName = $reservation->room->name;
        $color = $roomColors[$roomName] ?? 'gray'; // Default to gray if no color is defined
        $events[] = [
            'title' => $reservation->event, // Use the event details
            'start' => $reservation->reservationDate . 'T' . $reservation->reservationTime,
            'end' => $reservation->reservationDate . 'T' . $reservation->timelimit,
            'room' => $reservation->room->name,
            'color' => $color, // Assign the color based on the room
        ];
    }

    return view('welcome', compact('reservations', 'events', 'roomColors'));
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
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('sdashboard');

    Route::get('/users', [SuperAdminController::class, 'users'])->name('superAdminUsers');
    Route::get('/manage-role', [SuperAdminController::class, 'manageRole'])->name('manageRole');
    Route::post('/update-role', [SuperAdminController::class, 'updateRole'])->name('updateRole');
    Route::get('/reservation', [SuperAdminController::class, 'reservation'])->name('sadminreservation');
    Route::get('/reservationstatus', [SuperAdminController::class, 'changeStatus'])->name('changeStatus');
    Route::put('/users/{user}/update', [SuperAdminController::class, 'update'])->name('users.update');
    Route::post('/users', [SuperAdminController::class, 'store'])->name('users.store');
    Route::post('/superadmin/create-reservation', [SuperAdminController::class, 'createReservation'])->name('superadmin.createReservation'); // You can name the route as you prefer
    Route::get('/activities', [SuperAdminController::class, 'showActivities'])->name('superadminactivities');
    Route::get('/profile', [SuperAdminController::class, 'showProfile'])->name('superadmin.profile.show');
    Route::post('/profile/update-password', [SuperAdminController::class, 'updatePassword'])->name('profile.updatePassword');




    // web.php

    Route::patch('/admin/reservation/update/{id}', [SuperAdminController::class, 'updateReservationStatus'])
        ->name('superadmin.updateReservationStatus');
});

// ********** Sub Admin Routes *********
Route::group(['prefix' => 'sub-admin', 'middleware' => ['web', 'isSubAdmin']], function () {
    Route::get('/dashboard', [SubAdminController::class, 'dashboard'])->name('subdashboard');
    Route::get('/resevation', [SubAdminController::class, 'reservation'])->name('subadminreservation');
    Route::put('/subadmin/reservation/update/{id}', [SubAdminController::class, 'updateReservationStatus'])->name('subadmin.update');
    Route::get('/profile', [SubAdminController::class, 'showProfile'])->name('subadmin.profile.show');
});

// ********** Admin Routes *********
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'isAdmin']], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admindashboard');
    Route::get('/reservation', [AdminController::class, 'reservation'])->name('adminreservation');
    Route::put('/admin/reservation/update/{id}', [AdminController::class, 'updateReservationStatus'])->name('admin.update');
    Route::get('/profile', [AdminController::class, 'showProfile'])->name('admin.profile.show');
});
Route::middleware(['auth', 'miniadmin'])->group(function () {
    Route::get('/miniadmin/dashboard', [MiniAdminController::class, 'dashboard'])->name('minidashboard');
    Route::get('/miniadmin/reservation', [MiniAdminController::class, 'reservation'])->name('miniadminreservation');
    Route::put('/miniadmin/reservation/update/{id}', [MiniAdminController::class, 'updateReservationStatus'])->name('miniadmin.update');
    Route::get('/miniadmin/profile', [MiniAdminController::class, 'showProfile'])->name('miniadmin.profile.show');
    Route::post('/miniadmin/profile/update-password', [MiniAdminController::class, 'updatePassword'])->name('Edit.Password');





    // Routes accessible only to authenticated users with the MiniAdmin role
    // Define your MiniAdmin-specific routes here
});

// ********** User Routes *********
Route::group(['middleware' => ['web', 'isUser', 'verified']], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('userdashboard');
    Route::get('/booking', [UserController::class, 'booking'])->name('booking');
    Route::get('/reservation', [UserController::class, 'reservation'])->name('reservation');
    Route::post('/booking', [ReservationController::class, 'store'])->name('submit.reservation');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile.show');
    Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');
});
Route::get('/get-bookings', [BookingController::class, 'getBookings']);

Route::get('/login/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/callback-url', [AuthController::class, 'googleCallback']);
Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/activate-account', [AuthController::class, 'showActivationPage'])->name('account.activate');

// Route to handle the activation request
Route::post('/account/activate', [AuthController::class, 'activate'])
    ->name('account');
Route::get('/reservation-ended/{reservationId}', [UserController::class, 'reservationEnded'])->name('reservation.ended');


Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Handle the Password Reset Request Submission
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::get('activate/{token}', [ActivationController::class, 'activateAccount'])->name('activate.account');
// routes/web.php

Route::post('/import-data', [DataImportController::class, 'import'])->name('import.data');
Route::get('/export-users', function () {
    return Excel::download(new UsersExport, 'users.xlsx');
});

Route::view('/activation-success', 'activation_success')->name('activation.success');
// Activation Route
Route::post('/users/activate/{user}', [UserController::class, 'activateUser'])->name('user.activate');

// Deactivation Route
Route::post('/deactivate-user/{user}', [UserController::class, 'deactivateUser'])->name('deactivate.user');


// routes/web.php
Route::get('/guest-booking', [GuestBookingController::class, 'showForm'])->name('guest.booking.form');
// routes/web.php
Route::post('/guest-booking', [GuestBookingController::class, 'submitBooking'])->name('guest.booking.submit');
Route::get('/guest/thankyou', [GuestBookingController::class, 'thankYou'])->name('guest.thankyou');



Route::get('/change-password', [AuthController::class, 'changePasswordForm'])->name('change-password');
Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.post');
Route::get('/activate/{user}/{token}', [AuthController::class, 'activateAccount'])->name('activate');

Route::post('/send-reservation-email', [ReservationController::class, 'sendEmail']);


Route::post('/account/check-activation', [UserController::class, 'checkActivation'])->name('account.check-activation');
Route::get('/password/change', [UserController::class, 'changePassword'])->name('password.change'); // Implement this method in UserController
