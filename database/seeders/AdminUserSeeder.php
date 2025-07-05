<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Check if admin already exists
        if (User::where('email', 'zaidalq4@gmail.com')->doesntExist()) {
            User::create([
                'name' => 'Admin',
                'email' => 'zaidalq4@gmail.com',
                'password' => Hash::make('Zaid10022001'), // Use a strong password!
                'role' => 'admin', // assuming you have a 'role' column
            ]);
        }
    }
}
