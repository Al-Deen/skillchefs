<?php

declare(strict_types=1);

namespace Modules\Organization\Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //role add
        Role::create([
            'id' => 6,
            'name' => 'Organization',
        ]);

        //permission add
        $attributes = [
            'organization' => ['read' => ' organization_read', 'create' => 'organization_create', 'store' => 'organization_store', 'organization_suspend' => 'organization_suspend', 'organization_re_activate' => 'organization_re_activate', 'organization_request_list' => 'organization_request_list', 'organization_suspend_list' => 'organization_suspend_list', 'organization_approve' => 'organization_approve', 'organization_update' => 'organization_update', 'organization_delete' => 'organization_delete', 'organization_login' => 'organization_login'],
        ];
        foreach ($attributes as $key => $attribute) {
            $permission = new Permission();
            $permission->attribute = $key;
            $permission->keywords = $attribute;
            $permission->save();
        }

        //super admin permission add
        $permission = ['organization_request_list', 'organization_suspend_list', 'organization_read', 'organization_create', 'organization_store', 'organization_approve', 'organization_suspend', 'organization_re_activate', 'organization_update', 'organization_delete', 'organization_login'];
        foreach (User::where('role_id', 1)->get() as $user) {
            $user->permissions = array_merge($user->permissions, array_values($permission));
            $user->save();
        }

        if (Session()->get('temp_data') || env('APP_TEST')) {
            try {

                $organization_user = User::create([
                    'name' => 'organization',
                    'username' => 'organization',
                    'phone' => '13457897866',
                    'email' => 'organization@onest.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('123456'),
                    'remember_token' => Str::random(10),
                    'role_id' => 6,
                    'date_of_birth' => '2022-10-07',
                    'status_id' => 4,
                    'designation_id' => 6,
                ]);
                $organization_user->organization()->create([
                    "about_me" => "Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry's Standard Dummy Text Ever Since The 1500s, When An Unknown Printer Took A Galley Of Type And Scrambled It To Make A Type Specimen Book. It Has Survived Not Only Five Centuries, But Also The Leap Into Electronic Typesetting, Remaining Essentially Unchanged.

                It Was Popularised In The 1960s With The Release Of Letraset Sheets Containing Lorem Ipsum Passages, And More Recently With Desktop Publishing Software Like Aldus PageMaker Including Versions Of Lorem Ipsum.",
                    "designation" => "Chief Executive Officer",
                    "address" => "Dhaka, Bangladesh",
                    "country_id" => 19,
                    "skills" => json_decode('[{ "value": "Instructor Training"}, { "value": "Business Development"}, {"value": "Digital Marketing"} ]'),
                ]);
                return true;

            } catch (\Exception $e) {
                dd($e);
                return false;
            }
        }
    }
}
