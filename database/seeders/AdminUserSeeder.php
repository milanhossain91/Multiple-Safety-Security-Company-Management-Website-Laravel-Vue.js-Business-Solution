<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the default admin account used to log in to the panel.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@atsl.com'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
