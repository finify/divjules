<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRecords = [
            [
                'name'=>'Certari Admin', 
                'email'=>'info@certarigroup.com', 
                'password'=> Hash::make('AdminCertari50@'),
            ]
        ];
        User::insert($userRecords);
    }
}
