<?php

namespace App\Http\Controllers;

use App\Mail\ActivationEmail;
use App\Models\Activity;
use App\Models\Department;
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
use Iterator;

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
        $itemsCount=Item::count();
        $departmentsCount=Department::count();
        $usersCount = User::where('role', 0)->count();
        $rooms = Room::all();
        $users = User::all();
        $items = Item::all();
        $pendingBookingsCount = Reservation::where('status', 'pending')->count();
        $reservationsAcceptedCount = Reservation::where('status', 'Accepted')->count();
        // In your controller method
        $monthlyReservationCounts = Reservation::select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, COUNT(*) reservation_count'))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        $currentDate = now()->format('Y-m-d'); // Get the current date in 'Y-m-d' format
        $dailyReservations = []; // Initialize an empty array
        $roomColors = [
            'Kifaru' => 'Orange',
            'Shark Tank Boardroom' => 'Blue',
            'Executive Boardroom' => 'Green',
            'Oracle Lab' => 'Black',
            'Safaricom Lab' => 'Black',
            'Ericsson Lab' => 'Black',
            'Small Meeting Room' => 'Purple',
            'Samsung Lab' => 'Black'
            // Add more rooms and colors as needed
        ];
        
        foreach ($rooms as $room) {
            // Query to get daily reservation counts for a specific room on the current date
            $dailyCount = DB::table('reservations')
                ->where('room_id', $room->id)
                ->whereDate('created_at', $currentDate)
                ->count();
        
            // Get the background color for the room
            $backgroundColor = $roomColors[$room->name];
        
            // Format the data for the room
            $roomData = [
                'label' => $room->name,
                'data' => [$dailyCount], // Use an array with the count for the current date
                'backgroundColor' => $backgroundColor, // Use the color from $roomColors
                'borderColor' => 'rgba(255, 255, 255, 0.8)',
                'borderWidth' => 1,
            ];
        
            $dailyReservations[] = $roomData;
        }
        
    // Create a separate array for dates as labels



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
        return view('super-admin.dashboard', compact('reservations', 'events', 'pendingBookingsCount', 'usersCount', 'roomsCount', 'users', 'rooms', 'items', 'roomColors','reservationsAcceptedCount','monthlyReservationCounts','dailyReservations','itemsCount','departmentsCount'));
    }

    public function users()
    {
        $users = User::paginate(7);
        $roles = Role::all();
        return view('super-admin.users', compact('users', 'roles'));
    }

    public function manageRole()
    {
        $users = User::all();
        $roles = Role::all();
        return view('super-admin.manage-role', compact('users', 'roles'));
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
        } elseif ($request->status === 'Cancelled') {
            // Notify the user that the booking has been canceled
            $reservation->user->notify(new BookingCanceledNotification($reservation, $request->remark));
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
            'is_guest' => 'required|in:0,1',
            'department' => 'required|in:eHealth,IT Outsourcing & BITCU,Digital Learning,Data Science,IoT,IT Security,iBizAfrica,IR & EE,PR,IT Department,Others',
            'other_department' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        // Update user information
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->is_guest = $request->input('is_guest'); // Update the user type

        // Update the password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->input('department') !== 'Others') {
            $user->department = $request->input('department');
        } else {
            // If 'Others' selected, use the value from the 'other_department' field
            $user->department = $request->input('other_department');
        }

        $user->contact = $request->input('contact');

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
            'contact' => 'required|string|max:20', // Adjust the rules accordingly
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
        $user->contact = $request->input('contact');
        $user->activation_token = $activationToken; // Store activation token

        $activationLink = route(
            'activate.account',
            ['token' => $user->activation_token]
        );


        $user->save();

        return back()->with('success', 'User information added successfully.');

        // Handle success and return a response
    }

    public function createReservation(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'requestItems' => 'boolean',
            'itemRequests' => 'nullable|array', // Make the itemRequests field optional            
            'itemRequests.*' => 'exists:items,id', // Validate each item in the array           
            'duration' => 'required|integer',
            'capacity' => 'required|integer',
            'reservationDate' => 'required|date',
            'reservationTime' => 'required|date_format:H:i',
            'timelimit' => 'required|date_format:H:i',
            'selectRoom' => 'required|exists:rooms,id',
            'event' => 'nullable|string',
            'itServices' => 'boolean',
            'setupAssistance' => 'boolean',
            'timelimit'=>'required',        
            'comment' => 'nullable|string', // Comment field is optional
            'additionalDetails' => 'nullable|string',
            'mealSetupDetails' => 'nullable|string',

        ]);

       
        $isRoomAvailable = !DB::table('reservations')
            ->where('room_id', $validatedData['selectRoom'])
            ->where('reservationDate', $validatedData['reservationDate'])
            ->where('reservationTime', $validatedData['reservationTime'])
            ->exists();

        if (!$isRoomAvailable) {
            throw ValidationException::withMessages(['selectRoom' => 'This room is not available at the selected date and time.']);
        }
        

        // Create a new reservation instance and populate it with the form data
        $reservation = new Reservation();
        $reservation->user_id = $validatedData['user_id'];
        $reservation->reservationDate = $validatedData['reservationDate'];
        $reservation->reservationTime = $validatedData['reservationTime'];
        $reservation->timelimit = $validatedData['timelimit']; // Store the calculated end time
        $reservation->room_id = $validatedData['selectRoom'];
        $reservation->event = $validatedData['event'];
        $reservation->status = 'Accepted';
        $reservation->event = $validatedData['event'];
        $reservation->itServices = $validatedData['itServices'] ?? false;
        $reservation->setupAssistance = $validatedData['setupAssistance'] ?? false;
        $reservation->comment = $validatedData['comment'];
        $reservation->additional_details = $validatedData['additionalDetails']; 
        $reservation->meal_setup_details = $validatedData['mealSetupDetails']; // Add meal setup details


    
        // Save the reservation to the database
        

        // Save the reservation to the database
        $reservation->save();

        if ($request->has('itemRequests')) {
            $itemRequests = $request->input('itemRequests');
            // Now, you can work with $itemRequests
        }
        
    

        // Attach selected items (if any) to the reservation
        Session::flash('success', 'Reservation made successfully!');

        // Redirect back with a success message
        return redirect()->back();
    }

    public function showActivities()
    {
        $activities = Activity::simplepaginate(10); // Paginate the latest 10 activities        

        return view('super-admin.activities', ['activities' => $activities]);
    }
    public function showProfile()
    {
        return view('super-admin.profile');
    }
    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:8',
            'new_password_confirmation' => 'nullable|same:new_password',
            'contact' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

       // Check if the current password is provided and matches the authenticated user's password
if ($request->current_password && !Hash::check($request->current_password, Auth::user()->password)) {
    return redirect()->back()->with('error', 'Incorrect current password');
}

// Check if the new password is provided and is too obvious (e.g., contains "password" or "123456")
$obviousPasswords = ['password', '123456']; // Add more obvious passwords if needed
if ($request->new_password && in_array($request->new_password, $obviousPasswords)) {
    return redirect()->back()->with('error', 'Please choose a stronger password');
}

        // Update the user's password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->department = $request->input('department') === 'Others'
        ? $request->input('other_department') // Use "other_department" if "Others" selected
        : $request->input('department'); // Use the selected department
        $user->contact = $request->input('contact');
        $user->save();

        return redirect()->back()->with('success', 'User Profile updated Successfully');
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
    
    public function items(){
        $items=Item::all();
        $items = Item::simplePaginate(10); // You can specify the number of items per page (e.g., 10 per page) // You can change the number of items per page (e.g., 10) as needed
        return view('super-admin.items',compact('items'));
    }

    public function storeItems(Request $request)
    {
        // Validation rules for the asset creation form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'asset_tag' => 'required|string|max:50',
        ]);
    
        // Create and save the asset
        $item = new Item([
            'name' => $validatedData['name'],
            'asset_tag' => $validatedData['asset_tag'],
        ]);
    
        $item->save();
    
        $items=Item::all();
        return redirect()->back()->with('success', 'Asset added successfully');
    }
    public function deleteItem(Item $item)
{
    // Delete the item from the database
    $item->delete();
    $items=Item::all();


    return redirect()->back()->with('success', 'Item deleted successfully');
}
// SuperAdminController.php
public function updateItem(Request $request, $id)
{
    // Validation rules for updating the item
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'asset_tag' => 'required|string|max:50',
    ]);

    // Find the item by ID
    $item = Item::findOrFail($id);

    // Update the item's attributes
    $item->update([
        'name' => $validatedData['name'],
        'asset_tag' => $validatedData['asset_tag'],
    ]);

    // Redirect back to the page with a success message
    return redirect()->back()->with('success', 'Item updated successfully');
}
public function Department(){
    $departments=Department::all();
    return view('super-admin.department',compact('departments'));
}
public function storeDepartment(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255', // Add any validation rules you need
    ]);

    // Create and store the department
    $department = new Department();
    $department->name = $validatedData['name'];
    $department->save();

    return redirect()->back()->with('success', 'Department added successfully');
}
public function updateDepartment(Request $request, Department $department)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $department->update([
        'name' => $request->input('name'),
    ]);

    return redirect()->back()->with('success', 'Department updated successfully.');
}

public function destroy(Department $department)
{
    $department->delete();

    return redirect()->back()->with('success', 'Department deleted successfully.');
}


public function rooms(){
    $rooms=Room::all();
    $rooms = Room::simplePaginate(10); // You can specify the number of items per page (e.g., 10 per page) // You can change the number of items per page (e.g., 10) as needed


    return view('super-admin.room',compact('rooms'));
}

public function storeRoom(Request $request)
{
    // Validate the incoming data
    $validatedData = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'capacity' => 'required|integer',
    ]);

    // Create a new room using the validated data
    Room::create($validatedData);

    // Redirect back or to a specific page after creating the room
    return redirect()->back()->with('success', 'Room created successfully');
}
public function updateRoom(Request $request, Room $room)
{
    // Validate the incoming data
    $validatedData = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'capacity' => 'required|integer',
    ]);

    // Update the room attributes
    $room->update($validatedData);

    // Redirect back or to a specific page after updating the room
    return redirect()->back()->with('success', 'Room updated successfully');
}
public function Roomdestroy(Room $room)
{
    // Delete the room
    $room->delete();

    // Redirect back or to a specific page after deleting the room
    return redirect()->back()   ->with('success', 'Room deleted successfully');
}
}
