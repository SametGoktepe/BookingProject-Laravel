<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = [
            ['name' => 'One Bed'],
            ['name' => 'Two Beds'],
            ['name' => 'Three Beds'],
            ['name' => 'Four Beds'],
            ['name' => 'King Bed'],
            ['name' => 'Families'],
            ['name' => 'Junior Suites'],
            ['name' => 'Suites'],
            ['name' => 'Presidential Suites'],
            ['name' => 'Duplex Room'],
            ['name' => 'Disabled room'],
        ];

        foreach ($type as $key => $value) {
            \App\Models\RoomTypes::create($value);
        }
    }
}
