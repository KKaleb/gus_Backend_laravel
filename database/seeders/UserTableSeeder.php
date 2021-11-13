<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admins = [
            [
                'id' => 1,
                'phone_number' => '08137331282',
                'email' => 'oluwatobi@brandmobile.net',
                'password' => Hash::make('solomon001'),
                'is_Admin' => true,

            ],
            [
                'id' => 2,
                'phone_number' => '07009887263',
                'email' => 'olatunde.oluwatona@insightpublicis.com',
                'password' => Hash::make('Ultimatechampion2021'),
                'is_Admin' => true,
            ],
            [
                'id' => 3,
                'phone_number' => '07009887261',
                'email' => 'sani.malik@insightpublicis.com',
                'password' => Hash::make('Ultimatechampion2021'),
                'is_Admin' => true,
            ],
            [
                'id' => 4,
                'phone_number' => '07009887262',
                'email' => 'adedayo@brandmobile.net',
                'password' => Hash::make('Ultimatechampion2021'),
                'is_Admin' => true,
            ],
            [
                'id' => 5,
                'phone_number' => '07009887265',
                'email' => 'Moshood@brandmobile.net',
                'password' => Hash::make('Ultimatechampion2021'),
                'is_Admin' => true,
            ],
            [
                'id' => 6,
                'phone_number' => '07009887260',
                'email' => 'Tofunmi@brandmobile.net',
                'password' => Hash::make('Ultimatechampion2021'),
                'is_Admin' => true,
            ],
        ];

        foreach($admins as $admin)
        {
            User::firstOrCreate($admin);
        }

    }
}
