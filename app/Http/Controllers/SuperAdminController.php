<?php

namespace App\Http\Controllers;

use App\Mail\ActivationEmail;
use App\Models\Activity;
use App\Notifications\UserReservationNotification;
use TCPDF;
use App\Models\Item;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Room;
use App\Notifications\BookingAcceptedNotification;
use App\Notifications\BookingDeclinedNotification;
use App\Rules\RoomAvailability;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon; // Import the Carbon library
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class SuperAdminController extends Controller
{
    //
    public function dashboard()
    {
        $rooms = Room::all()->pluck('name', 'id')->prepend(trans('Select...'), '');
        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $reservations = Reservation::where('status', 'accepted')->get();
        $events = [];
        $roomsCount = Room::count();
        $usersCount = User::where('role', 0)->count();
        $rooms = Room::all();
        $users = User::all();
        $items = Item::all();
        $pendingBookingsCount = Reservation::where('status', 'pending')->count();
        $reservationsAcceptedCount = Reservation::where('status', 'Accepted')->count();


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
        return view('super-admin.dashboard', compact('reservations', 'events', 'pendingBookingsCount', 'usersCount', 'roomsCount', 'users', 'rooms', 'items', 'roomColors','reservationsAcceptedCount'));
    }

    public function users()
    {
        $users = User::with('roles')->where('role', '!=', 1)->paginate(7);
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
        $pendingReservations = Reservation::where('status', 'Pending')
            ->orderBy('created_at', 'asc') // Order by the created_at column in ascending order
            ->paginate(10);
        $acceptedReservations = Reservation::where('status', 'Accepted')
            ->orderBy('created_at', 'asc') // Order by the created_at column in ascending order
            ->paginate(10);
        $reservations = Reservation::paginate(10);
        return view('super-admin.reservation', compact('reservations', 'acceptedReservations', 'pendingReservations'));
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


        if ($request->status === 'Accepted') {
            // Notify the user that the booking has been accepted
            $reservation->user->notify(new BookingAcceptedNotification($reservation));
        } elseif ($request->status === 'Declined') {
            // Notify the user that the booking has been declined and include a remark
            $reservation->user->notify(new BookingDeclinedNotification($reservation, $request->remark));
        }


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
    public function store(Request $request)
    {
        // Validate the user creation data
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2',
            'email' => 'string|email|required|max:100|unique:users',
            'password' => 'string|required|confirmed|min:6',
            'role' => 'required', // Add validation rules for role
            'department' => 'required', // Remove the "not_in:Others" rule
            'other_department' => 'required_if:department,Others', // Make "other_department" required only when "department" is "Others"
        ]);

        // If the user selected "Others," validate the custom department

        $activationToken = Str::random(32);
        // Create and save the user
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->department = $request->input('department') === 'Others'
            ? $request->input('other_department') // Use "other_department" if "Others" selected
            : $request->input('department'); // Use the selected department
        $user->activation_token = $activationToken; // Store activation token

        $activationLink = route(
            'activate.account',
            ['token' => $user->activation_token]
        );

        Mail::to($user->email)->send(new ActivationEmail($user, $activationLink));

        $user->save();

        return back()->with('success', 'User information added successfully.');

        // Handle success and return a response
    }

    public function createReservation(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'nullable|array|max:5', // Assuming you want to allow up to 5 items
            'items.*' => 'exists:items,id', // Validate each item in the array
            'duration' => 'required|integer',
            'reservationDate' => 'required|date',
            'reservationTime' => 'required',
            'timelimit' => 'required',
            'selectRoom' => 'required|exists:rooms,id',
            'event' => 'nullable|string',
        ]);

        $startTime = strtotime($validatedData['reservationTime']);
        $endTime = date('H:i', strtotime("+" . $validatedData['duration'] . " hours", $startTime));

        // Check if the room is available at the selected date and time
        $isRoomAvailable = !DB::table('reservations')
            ->where('room_id', $validatedData['selectRoom'])
            ->where('reservationDate', $validatedData['reservationDate'])
            ->where('reservationTime', $validatedData['reservationTime'])
            ->exists();

        if (!$isRoomAvailable) {
            throw ValidationException::withMessages(['selectRoom' => 'This room is not available at the selected date and time.']);
        }
        $selectedItems = array_slice($validatedData['items'], 0, 5);
        $itemIds = implode(',', $selectedItems);


        // Create a new reservation instance and populate it with the form data
        $reservation = new Reservation();
        $reservation->user_id = $validatedData['user_id'];
        $reservation->item_id = $itemIds;
        $reservation->reservationDate = $validatedData['reservationDate'];
        $reservation->reservationTime = $validatedData['reservationTime'];
        $reservation->timelimit = $endTime; // Store the calculated end time
        $reservation->room_id = $validatedData['selectRoom'];
        $reservation->event = $validatedData['event'];

        $reservation->status = 'accepted';

        // Save the reservation to the database
        $reservation->save();

        // Attach selected items (if any) to the reservation
        Session::flash('success', 'Reservation made successfully!');

        // Redirect back with a success message
        return redirect()->back();
    }

    public function showActivities()
    {
        $activities = Activity::latest()->paginate(10); // Paginate the latest 10 activities        

        return view('super-admin.activities', ['activities' => $activities]);
    }
    public function showProfile()
    {
        return view('super-admin.profile');
    }
    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // Check if the current password matches the authenticated user's password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Incorrect current password');
        }

        // Check if the new password is too obvious (e.g., contains "password" or "123456")
        $obviousPasswords = ['password', '123456']; // Add more obvious passwords if needed
        if (in_array($request->new_password, $obviousPasswords)) {
            return redirect()->back()->with('error', 'Please choose a stronger password');
        }

        // Update the user's password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully');
    }
    public function searchReservations(Request $request)
    {
        $searchQuery = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $query = Reservation::query();
    
        if (!empty($status)) {
            $query->where('status', $status);
        }
    
        if (!empty($searchQuery)) {
            $query->where(function ($subquery) use ($searchQuery) {
                $subquery->whereHas('user', function ($query) use ($searchQuery) {
                    $query->where('name', 'like', '%' . $searchQuery . '%');
                })
                ->orWhereHas('room', function ($query) use ($searchQuery) {
                    $query->where('name', 'like', '%' . $searchQuery . '%');
                })
                ->orWhere('event', 'like', '%' . $searchQuery . '%');
            });
        }
    
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('ReservationDate', [$startDate, $endDate]);
        }
    
        $Results = $query->paginate(10);
    
        return view('super-admin.search-results', compact('Results'));
    }

    public function generatePDF(Request $request)
    {
        // Get the search and filter criteria from the request
        $search = $request->input('search');
        $filter = $request->input('filter');
    
        // Query the activities based on the filter and search criteria
        $query = Activity::query();
        
        if ($filter === 'action') {
            $query->where('action', 'like', '%' . $search . '%');
        } elseif ($filter === 'user') {
            $query->whereHas('user', function ($userQuery) use ($search) {
                $userQuery->where('name', 'like', '%' . $search . '%');
            });
        }
    
        $filteredActivities = $query->get();
    
        // Create a new TCPDF instance
        $pdf = new TCPDF();
    
        // Set document information
        $pdf->SetCreator('iLab Booking System');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('System Activities PDF');
        $pdf->SetSubject('System Activities Report');
        $pdf->SetKeywords('system activities, report, PDF');
        $pdf->SetMargins(20, 20, 20);
    
        // Add a page
        $pdf->AddPage();
    
        // Set font
        $pdf->SetFont('times', '', 12);
    
        // Extend the PDF template and pass the $filteredActivities variable
        $pdf->writeHTML(view('pdf.template', ['activities' => $filteredActivities])->render());
    
        $pdf->SetY(-15); // Move to the bottom of the page
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 10, 'Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    
        // Output the PDF (inline or as a download)
        return $pdf->Output('system_activities.pdf', 'D');
    }
    

    


    
}
