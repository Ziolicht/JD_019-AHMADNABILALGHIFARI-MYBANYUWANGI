<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // jadikan user pertama admin
        $admin = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->update(['is_admin' => true]);

        Event::factory()->count(6)->create([
            'is_published' => true,
            'created_by' => $admin->id,
        ]);

        // contoh manual
        Event::create([
            'title' => 'Pasar Malam Alun-Alun',
            'description' => "Nikmati kuliner dan hiburan rakyat.",
            'category' => 'budaya',
            'location' => 'Alun-Alun Kota',
            'starts_at' => now()->addDays(3)->setTime(18, 0),
            'ends_at' => now()->addDays(3)->setTime(22, 0),
            'is_published' => true,
            'created_by' => $admin->id,
        ]);
    }
}
