<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Mail\ActivationEmail;
use App\Models\User; // Adjust the namespace and model class as needed
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersDataImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Assuming your Excel file columns are 'name', 'email', and 'department'
            $userData = [
                'name' => $row[1], // Adjust the column index as needed
                'email' => $row[2], // Adjust the column index as needed
                'department' => $row[3], // Adjust the column index as needed
                'password' => bcrypt('Kenya@2030'), // Set a default password
                'activated' => false, // Users are initially not activated
                'activation_token' => Str::random(60), // Generate a unique activation token
            ];

            // Create a new user or update an existing one based on email
            $user = User::updateOrCreate(['email' => $userData['email']], $userData);
            $activationUrl = route('activate.account', ['token' => $userData['activation_token']]);
            Mail::to($user)->send(new ActivationEmail($user, $activationUrl));
        }
    }
}
