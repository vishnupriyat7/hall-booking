<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'person_create',
            ],
            [
                'id'    => 18,
                'title' => 'person_edit',
            ],
            [
                'id'    => 19,
                'title' => 'person_show',
            ],
            [
                'id'    => 20,
                'title' => 'person_delete',
            ],
            [
                'id'    => 21,
                'title' => 'person_access',
            ],
            [
                'id'    => 22,
                'title' => 'visitor_mangement_access',
            ],
            [
                'id'    => 23,
                'title' => 'database_access',
            ],
            [
                'id'    => 24,
                'title' => 'id_type_create',
            ],
            [
                'id'    => 25,
                'title' => 'id_type_edit',
            ],
            [
                'id'    => 26,
                'title' => 'id_type_delete',
            ],
            [
                'id'    => 27,
                'title' => 'id_type_access',
            ],
            [
                'id'    => 28,
                'title' => 'visitor_pass_create',
            ],
            [
                'id'    => 29,
                'title' => 'visitor_pass_edit',
            ],
            [
                'id'    => 30,
                'title' => 'visitor_pass_show',
            ],
            [
                'id'    => 31,
                'title' => 'visitor_pass_access',
            ],
            [
                'id'    => 32,
                'title' => 'visiting_office_category_create',
            ],
            [
                'id'    => 33,
                'title' => 'visiting_office_category_edit',
            ],
            [
                'id'    => 34,
                'title' => 'visiting_office_category_show',
            ],
            [
                'id'    => 35,
                'title' => 'visiting_office_category_delete',
            ],
            [
                'id'    => 36,
                'title' => 'visiting_office_category_access',
            ],
            [
                'id'    => 37,
                'title' => 'recommending_office_category_create',
            ],
            [
                'id'    => 38,
                'title' => 'recommending_office_category_edit',
            ],
            [
                'id'    => 39,
                'title' => 'recommending_office_category_show',
            ],
            [
                'id'    => 40,
                'title' => 'recommending_office_category_delete',
            ],
            [
                'id'    => 41,
                'title' => 'recommending_office_category_access',
            ],
            [
                'id'    => 42,
                'title' => 'member_create',
            ],
            [
                'id'    => 43,
                'title' => 'member_edit',
            ],
            [
                'id'    => 44,
                'title' => 'member_show',
            ],
            [
                'id'    => 45,
                'title' => 'member_delete',
            ],
            [
                'id'    => 46,
                'title' => 'member_access',
            ],
            [
                'id'    => 47,
                'title' => 'self_registration_create',
            ],
            [
                'id'    => 48,
                'title' => 'self_registration_edit',
            ],
            [
                'id'    => 49,
                'title' => 'self_registration_show',
            ],
            [
                'id'    => 50,
                'title' => 'self_registration_delete',
            ],
            [
                'id'    => 51,
                'title' => 'self_registration_access',
            ],
            [
                'id'    => 52,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
