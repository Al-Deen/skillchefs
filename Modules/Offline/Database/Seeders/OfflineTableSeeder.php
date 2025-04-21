<?php

namespace Modules\Offline\Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OfflineTableSeeder extends Seeder
{
    public function run()
    {
        if (@Session()->get('temp_data') || env('APP_TEST')) {
            try {
                // permission add
                $attributes = [
                    'offline_payment' => [
                        'course_enroll_approval' => 'course_enroll_approval',
                        'course_enroll_approval_update' => 'course_enroll_approval_update',
                        'course_enroll_approval_delete' => 'course_enroll_approval_delete',
                        'event_enroll_approval' => 'event_enroll_approval',
                        'event_enroll_approval_update' => 'event_enroll_approval_update',
                        'event_enroll_approval_delete' => 'event_enroll_approval_delete',
                        'package_enroll_approval' => 'package_enroll_approval',
                        'package_enroll_approval_update' => 'package_enroll_approval_update',
                        'package_enroll_approval_delete' => 'package_enroll_approval_delete',
                    ],
                ];
                foreach ($attributes as $key => $attribute) {
                    $permission = new Permission();
                    $permission->attribute = $key;
                    $permission->keywords = $attribute;
                    $permission->save();
                }

                // super admin permission add
                $permission = ['course_enroll_approval', 'course_enroll_approval_update', 'course_enroll_approval_delete', 'event_enroll_approval', 'event_enroll_approval_update',
                    'event_enroll_approval_delete', 'package_enroll_approval', 'package_enroll_approval_update', 'package_enroll_approval_delete'];

                foreach (\App\Models\User::where('role_id', 1)->get() as $user) {
                    $user->permissions = array_merge($user->permissions, array_values($permission));
                    $user->save();
                }

                $paymentMethods = [
                    [
                        'title' => 'Offline',
                        'name' => 'offline',
                        'status_id' => 1,
                        'credentials' => null,
                    ],
                ];

                foreach ($paymentMethods as $paymentMethod) {
                    \Modules\Payment\Entities\PaymentMethod::create($paymentMethod);
                }
            }
            catch (\Exception $e) {
                dd($e);
            }
        }
    }
}
