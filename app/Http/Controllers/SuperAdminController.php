<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon; // Import the Carbon library

class SuperAdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('super-admin.dashboard');
    }

    public function users()
    {
        $users = User::with('roles')->where('role', '!=', 1)->get();
        $roles = Role::all();
        return view('super-admin.users', compact('users', 'roles'));
    }

    public function manageRole()
    {
        $users = User::where('role', '!=', 1)->get();
        $roles = Role::all();
        return view('super-admin.manage-role', compact(['users', 'roles']));
    }

    public function updateRole(Request $request)
    {
        User::where('id', $request->user_id)->update([
            'role' => $request->role_id
        ]);
        return redirect()->back();
    }
    public function reservation()
    {
        $reservations = Reservation::paginate(10);
        return view('super-admin.reservation', compact('reservations'));
    }
    // SuperAdminController.php

    public function updateReservationStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:Accepted,Declined',
            'remarks' => 'nullable|string|max:255',
        ]);

        $reservation = Reservation::findOrFail($id);

        $reservation->status = $validatedData['status'];
        $reservation->remarks = $validatedData['remarks'];

        $reservation->save();

        // Display a success message using SweetAlert
        Alert::success('Success', 'Reservation status updated successfully!')->autoClose(60000);
        return redirect()->back();
    }

    public function update(Request $request, User $user)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:0,1,2,3,4',
            'password' => 'nullable|string|min:6', // Password is optional
        ]);

        // Update user information
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        // Redirect back with a success message
        return back()->with('success', 'User information updated successfully.');
    }
    
}
