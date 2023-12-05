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
            // Assuming your Excel file columns are 'name' and 'email'
            $name = $row[0]; // Adjust the column index as needed
            $email = $row[1]; // Adjust the column index as needed

            // Validate email
            if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $userData = [
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt('Kenya@2030'),
                    'activated' => false,
                    'activation_token' => Str::random(60),
                    'is_guest' => 0,
                    'role' => 0,
                    'department' => null,
                    'contact' => null,
                ];

                // Create a new user or update an existing one based on email
                User::updateOrCreate(['email' => $userData['email']], $userData);
            } else {
                // Handle invalid email (optional)
                // You might want to log an error, skip the row, or perform other actions
            }
        }
    }
}
