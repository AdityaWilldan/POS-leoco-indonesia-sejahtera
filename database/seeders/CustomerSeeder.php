<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\People\Entities\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::firstOrCreate(
            ['customer_name' => 'Non Member'],
            [
                'customer_email' => '-',
                'customer_phone' => '-',
                'city'           => '-',
                'country'        => '-',
                'address'        => '-',
            ]
        );

        Customer::firstOrCreate(
            ['customer_name' => 'Member'],
            [
                'customer_email' => '-',
                'customer_phone' => '-',
                'city'           => '-',
                'country'        => '-',
                'address'        => '-',
            ]
        );
    }
}
