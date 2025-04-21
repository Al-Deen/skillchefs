<?php

namespace Modules\Event\Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EventPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::beginTransaction();
        try {
            // permission add
            $attributes = [
                // Event
                'event_category' => ['read' => 'event_category_read', 'create' => 'event_category_create', 'store' => 'event_category_store', 'update' => 'event_category_update', 'delete' => 'event_category_delete'],
                'event' => ['read' => 'event_read', 'create' => 'event_create', 'store' => 'event_store', 'update' => 'event_update', 'delete' => 'event_delete', 'requested_event_list' => 'requested_event_list',
                'approved_event_list' => 'approved_event_list', 'rejected_event_list' => 'rejected_event_list', 'event_approve' => 'event_approve', 'event_reject' => 'event_reject', 'purchase_booking' => 'purchase_booking',
                'report_event_booking' => 'report_event_booking', 'report_event_booking_export' => 'report_event_booking_export'],
            ];

            foreach ($attributes as $key => $attribute) {
                if(Permission::where('attribute', $key)->exists()){
                    $permission = Permission::where('attribute', $key)->first();
                    $permission->delete();
                }

                $permission = new Permission();
                $permission->attribute = $key;
                $permission->keywords = $attribute;
                $permission->save();
            }

            // super admin permission add
            $permissions = [
                // event
                'event_create',
                'event_store',
                'event_update',
                'event_delete',
                'requested_event_list',
                'approved_event_list',
                'rejected_event_list',
                'event_approve',
                'event_reject',
                'purchase_booking',
                'report_event_booking',
                'report_event_booking_export',
                // event

                // event category
                'event_category_read',
                'event_category_store',
                'event_category_create',
                'event_category_update',
                'event_category_delete',
                // event category
            ];

            // User Permission
            for($role = 1; $role <= 2; $role++){
                $user                   = User::where('role_id', $role)->first();
                $user->permissions      = array_values(array_unique(array_merge($user->permissions, array_values($permissions))));
                $user->update();
            }

            // Role Permission
            for($role = 1; $role <= 2; $role++){
                $userRole                   = Role::where('id', $role)->first();
                $userRole->permissions      = array_values(array_unique(array_merge($userRole->permissions, array_values($permissions))));
                $userRole->update();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
