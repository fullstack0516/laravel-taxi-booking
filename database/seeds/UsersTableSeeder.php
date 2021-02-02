<?php

use App\Models\Profile;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customerRole = config('roles.models.role')::where('name', '=', 'Customer')->first();
        $driverRole = config('roles.models.role')::where('name', '=', 'Driver')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (config('roles.models.defaultUser')::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Admin',
                'email'    => 'admin@admin.com',
                'password' => bcrypt('America@12345'),
                'phone_number' => '+8613889313583',
            ]);

            $newUser->markEmailAsVerified();
            $newUser->markPhoneAsVerified();

            $profile = new Profile();
            $newUser->profile()->save($profile);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'customer@youwala.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Customer',
                'email'    => 'customer@youwala.com',
                'password' => bcrypt('password'),
                'phone_number' => '+8613889313583',
            ]);

            $newUser->markEmailAsVerified();
            $newUser->markPhoneAsVerified();

            $profile = new Profile();
            $newUser->profile()->save($profile);

            $newUser->attachRole($customerRole);
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'customer2@youwala.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Customer2',
                'email'    => 'customer2@youwala.com',
                'password' => bcrypt('password'),
                'phone_number' => '+8613889313583',
            ]);

            $newUser->markEmailAsVerified();
            $newUser->markPhoneAsVerified();

            $profile = new Profile();
            $newUser->profile()->save($profile);

            $newUser->attachRole($customerRole);
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'driver@youwala.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Driver',
                'email'    => 'driver@youwala.com',
                'password' => bcrypt('password'),
                'phone_number' => '+8613889313583',
            ]);

            $newUser->markEmailAsVerified();
            $newUser->markPhoneAsVerified();

            $profile = new Profile();
            $newUser->profile()->save($profile);

            $newUser->attachRole($driverRole);
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'driver2@youwala.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Driver2',
                'email'    => 'driver2@youwala.com',
                'password' => bcrypt('password'),
                'phone_number' => '+8612345678901',
            ]);

            $newUser->markEmailAsVerified();
            $newUser->markPhoneAsVerified();

            $profile = new Profile();
            $newUser->profile()->save($profile);

            $newUser->attachRole($driverRole);
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'driver3@youwala.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Driver3',
                'email'    => 'driver3@youwala.com',
                'password' => bcrypt('password'),
                'phone_number' => '+8612345678901',
            ]);

            $newUser->markEmailAsVerified();
            $newUser->markPhoneAsVerified();

            $profile = new Profile();
            $newUser->profile()->save($profile);

            $newUser->attachRole($driverRole);
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'driver4@youwala.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Driver4',
                'email'    => 'driver4@youwala.com',
                'password' => bcrypt('password'),
                'phone_number' => '+8612345678901',
            ]);

            $newUser->markEmailAsVerified();
            $newUser->markPhoneAsVerified();

            $profile = new Profile();
            $newUser->profile()->save($profile);

            $newUser->attachRole($driverRole);
        }
    }


}
