<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            [
                'name' => 'Executive BoardRoom',
                'capacity' => 14,
                'description' => 'A cozy meeting room with whiteboard and Tv connected to a Mini PC.',
            ],
            [
                'name' => 'Shark Tank BoardRoom',
                'capacity' => 14,
                'description' => 'A cozy meeting room with whiteboard and TV.',
            ],
            [
                'name' => 'Small Meeting Room',
                'capacity' => 5,
                'description' => 'A meeting room ',
            ],
            [
                'name' => 'Kifaru',
                'capacity' => 56,
                'description' => 'A Class room with whiteboard and projector.',
            ],
            [
                'name' => 'Oracle Lab',
                'capacity' => 22,
                'description' => 'A Class room with whiteboard and projector.',
            ],
            [
                'name' => 'Safaricom Lab',
                'capacity' => 35,
                'description' => 'A Class meeting room with whiteboard and projector.',
            ],
            [
                'name' => 'Ericsson Lab',
                'capacity' => 35,
                'description' => 'A Class meeting room with whiteboard and projector.',
            ],
            [
                'name' => 'Samsung Lab',
                'capacity' => 22,
                'description' => 'A Class meeting room with whiteboard and projector.',
            ],
            // Add more room entries as needed
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
