<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AliMehraei\ZohoAllInOne\Models\ZohoModelHasRole;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ZohoUserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        ZohoModelHasRole::truncate();

        foreach (config('zoho-v3.roles') as $key => $role) {
            $user = User::where('email', $role['default_email'])->first();
            if (!$user) {
                $user = new User();
                $user->name = $role['name'];
                $user->email = $role['default_email'];
                $user->password = Hash::make($role['default_email']);
                $user->email_verified_at = now();
                $user->remember_token = Str::random(10);
                $user->save();
            }

            $zohoModelHasRole = new ZohoModelHasRole();
            $zohoModelHasRole->role_id = $key;
            $zohoModelHasRole->model_type = User::class;
            $zohoModelHasRole->model_id = $user->id;
            $zohoModelHasRole->save();
        }

        DB::statement("SET foreign_key_checks=1");
    }
}
