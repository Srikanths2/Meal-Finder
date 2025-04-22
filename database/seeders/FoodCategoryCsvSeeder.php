<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FoodCategoryCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $path = storage_path('app/csv/food_categories.csv');
    $data = array_map('str_getcsv', file($path));

    $header = array_shift($data);

    // Debugging: Print the header and the first row
    $this->command->info('Header: ' . implode(', ', $header));
    $this->command->info('First Row: ' . implode(', ', $data[0]));

    foreach ($data as $row) {
        // Check if the number of columns matches the header
        if (count($row) !== count($header)) {
            $this->command->error('Mismatch between header and row: ' . implode(', ', $row));
            continue;
        }
    
        // Sanitize row data (remove extra spaces)
        $row = array_map(function($value) {
            return is_string($value) ? trim(preg_replace('/\s+/', ' ', $value)) : $value;
        }, $row);
    
        $row_data = array_combine($header, $row);
    
        // Insert each row into the database
        DB::table('food_categories')->insert([
            'categories' => $row_data['categories'],
            'name' => $row_data['name'],
            'image' => $row_data['image'],
            'description' => $row_data['description'],
            'amount' => (float) $row_data['amount'],
            'active' => filter_var($row_data['active'], FILTER_VALIDATE_BOOLEAN),
        ]);
    }
    
    $this->command->info('Food categories imported successfully!');
}

}
