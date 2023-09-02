<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Item 1', 'asset_tag' => 'TAG123', 'model_number' => 'Model A', 'serial_number' => 'S12345'],
            ['name' => 'Item 2', 'asset_tag' => 'TAG456', 'model_number' => 'Model B', 'serial_number' => 'S67890'],
            ['name' => 'Item 3', 'asset_tag' => 'TAG789', 'model_number' => 'Model C', 'serial_number' => 'S54321'],
            // Add more items as needed
        ];
        foreach ($items as $itemData) {
            Item::create($itemData);
        }
    }
}
