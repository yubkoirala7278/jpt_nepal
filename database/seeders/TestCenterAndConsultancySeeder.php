<?php

namespace Database\Seeders;

use App\Models\Consultancy;
use App\Models\TestCenter;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TestCenterAndConsultancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Predefined data
        $cities = ['Kathmandu', 'Pokhara', 'Biratnagar', 'Butwal', 'Lalitpur', 'Bhaktapur', 'Janakpur', 'Dharan', 'Chitwan'];
        $colleges = [
            'Tribhuvan University',
            'Kathmandu University',
            'Patan Multiple Campus',
            'Birendra Multiple Campus',
            'Nepal Engineering College',
            'Pulchowk Engineering Campus',
            'B.P. Koirala Institute of Health Sciences',
            'St. Xavier\'s College',
            'KIST Medical College',
        ];
        $contactPersons = ['Ram Bahadur', 'Sita Kumari', 'Gopal Sharma', 'Binod Chaudhary', 'Mina Bhandari', 'Ramesh Koirala', 'Anita Thapa', 'Krishna Prasad', 'Manisha Shrestha'];
        $addresses = [
            'Koteshwor, Kathmandu',
            'Pulchowk, Lalitpur',
            'Dharan Sub-Metropolitan, Sunsari',
            'New Baneshwor, Kathmandu',
            'Siddharthanagar, Rupandehi',
            'Damak, Jhapa',
            'Pokhara, Kaski',
            'Janakpur, Dhanusha',
            'Birgunj, Parsa',
            'Bharatpur, Chitwan'
        ];

        // Create TestCenters
        User::factory()
            ->testCenterManager()
            ->count(100)
            ->create()
            ->each(function (User $user) use ($faker, $cities, $colleges, $contactPersons) {
                TestCenter::create([
                    'user_id' => $user->id,
                    'venue_address' => $faker->randomElement($cities),
                    'test_venue' => $faker->randomElement($cities),
                    'venue_code' => str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                    'venue_name' => $faker->randomElement($colleges),
                    'phone' => '9' . rand(7, 8) . rand(10000000, 99999999), // Random mobile number
                    'contact_person' => $faker->randomElement($contactPersons),
                    'mobile_no' => '9' . rand(7, 8) . rand(10000000, 99999999), // Random mobile number
                    'status' => 'active',
                    'disabled_reason' => null
                ]);
            });

        // Create Consultancies
        User::factory()
            ->consultancyManager()
            ->count(100)
            ->create()
            ->each(function (User $user) use ($faker, $addresses,$contactPersons) {
                $testCenterUser = User::whereHas('roles', function ($query) {
                    $query->where('name', 'test_center_manager');
                })->inRandomOrder()->first();

                Consultancy::create([
                    'user_id' => $user->id,
                    'test_center_id' => $testCenterUser->id, // Random test center for the consultancy
                    'phone' => '9' . rand(7, 8) . rand(10000000, 99999999), // Random mobile number
                    'address' => $faker->randomElement($addresses), // Random Nepalese address
                    'logo' => 'Storage/Consultancy/677775d3384f8.jpeg', // Static logo path
                    'status' => 'active',
                    'disabled_reason' => null,
                    'owner_name'=>$faker->randomElement($contactPersons),
                    'mobile_number'=>'9' . rand(7, 8) . rand(10000000, 99999999), // Random mobile number
                ]);
            });
    }
}