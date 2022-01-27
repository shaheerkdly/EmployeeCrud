<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $designations = [
            'Designer',
            'Developer',
            'Tester',
            'Manager',
            'Director',
        ];
        foreach( $designations as $designation ) {
            \App\Models\Designation::create([
                'name' => $designation,
            ]);
        }
    }
}
