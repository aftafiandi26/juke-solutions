<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Faker\Factory as faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = faker::create();

        for ($i = 0; $i < 100; $i++) {
            $data = [
                'first_name'    => $faker->firstName,
                'last_name'     => $faker->lastName,
                'bod'           => Carbon::now(),
                'email'         => $faker->safeEmail,
                'position'      => "staff",
                'province_id'   => 13,
                'province'      => "Sumatera Barat",
                'city'          => "Kota Padang",
                'ktp'           => rand(10000, 200000),
                'rek_bank_position' => "mandiri",
                'rek_bank'      => rand(1000, 9000),
                'phone'         => rand(12345678, 987654321),
                'address'       => $faker->address,
                'code_pos'      => rand(123456, 654321)
            ];

            # code...
            Employee::create($data);
        }
    }
}
