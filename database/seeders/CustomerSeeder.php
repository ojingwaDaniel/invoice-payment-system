<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Ojingwa Daniel',
                'email' => 'ojingwadanny@gmail.com',
                'phone' => '08101338296',
                'address' => 'Odafe Garuba Street',
            ],
            [
                'name' => 'Mary Johnson',
                'email' => 'mary@example.com',
                'phone' => '08098765432',
                'address' => '45 Market Road, Abuja',
            ],
            [
                'name' => 'TechCorp Ltd',
                'email' => 'info@techcorp.com',
                'phone' => '09011223344',
                'address' => 'No 23 Business Avenue, Port Harcourt',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
