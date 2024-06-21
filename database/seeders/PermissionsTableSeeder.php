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
                'title' => 'gallery_pass_create',
            ],
            [
                'id'    => 53,
                'title' => 'gallery_pass_edit',
            ],
            [
                'id'    => 54,
                'title' => 'gallery_pass_show',
            ],
            [
                'id'    => 55,
                'title' => 'gallery_pass_access',
            ],
            [
                'id'    => 56,
                'title' => 'group_person_create',
            ],
            [
                'id'    => 57,
                'title' => 'group_person_edit',
            ],
            [
                'id'    => 58,
                'title' => 'group_person_show',
            ],
            [
                'id'    => 59,
                'title' => 'group_person_delete',
            ],
            [
                'id'    => 60,
                'title' => 'group_person_access',
            ],
            [
                'id'    => 61,
                'title' => 'country_create',
            ],
            [
                'id'    => 62,
                'title' => 'country_edit',
            ],
            [
                'id'    => 63,
                'title' => 'country_show',
            ],
            [
                'id'    => 64,
                'title' => 'country_delete',
            ],
            [
                'id'    => 65,
                'title' => 'country_access',
            ],
            [
                'id'    => 66,
                'title' => 'guiding_officer_create',
            ],
            [
                'id'    => 67,
                'title' => 'guiding_officer_edit',
            ],
            [
                'id'    => 68,
                'title' => 'guiding_officer_show',
            ],
            [
                'id'    => 69,
                'title' => 'guiding_officer_delete',
            ],
            [
                'id'    => 70,
                'title' => 'guiding_officer_access',
            ],
            [
                'id'    => 71,
                'title' => 'locker_create',
            ],
            [
                'id'    => 72,
                'title' => 'locker_edit',
            ],
            [
                'id'    => 73,
                'title' => 'locker_show',
            ],
            [
                'id'    => 74,
                'title' => 'locker_delete',
            ],
            [
                'id'    => 75,
                'title' => 'locker_access',
            ],
            [
                'id'    => 76,
                'title' => 'locker_item_create',
            ],
            [
                'id'    => 77,
                'title' => 'locker_item_edit',
            ],
            [
                'id'    => 78,
                'title' => 'locker_item_show',
            ],
            [
                'id'    => 79,
                'title' => 'locker_item_delete',
            ],
            [
                'id'    => 80,
                'title' => 'locker_item_access',
            ],
            [
                'id'    => 81,
                'title' => 'locker_token_create',
            ],
            [
                'id'    => 82,
                'title' => 'locker_token_edit',
            ],
            [
                'id'    => 83,
                'title' => 'locker_token_show',
            ],
            [
                'id'    => 84,
                'title' => 'locker_token_delete',
            ],
            [
                'id'    => 85,
                'title' => 'locker_token_access',
            ],
            [
                'id'    => 86,
                'title' => 'state_create',
            ],
            [
                'id'    => 87,
                'title' => 'state_edit',
            ],
            [
                'id'    => 88,
                'title' => 'state_show',
            ],
            [
                'id'    => 89,
                'title' => 'state_delete',
            ],
            [
                'id'    => 90,
                'title' => 'state_access',
            ],
            [
                'id'    => 91,
                'title' => 'district_create',
            ],
            [
                'id'    => 92,
                'title' => 'district_edit',
            ],
            [
                'id'    => 93,
                'title' => 'district_show',
            ],
            [
                'id'    => 94,
                'title' => 'district_delete',
            ],
            [
                'id'    => 95,
                'title' => 'district_access',
            ],
            [
                'id'    => 96,
                'title' => 'post_office_detail_create',
            ],
            [
                'id'    => 97,
                'title' => 'post_office_detail_edit',
            ],
            [
                'id'    => 98,
                'title' => 'post_office_detail_show',
            ],
            [
                'id'    => 99,
                'title' => 'post_office_detail_delete',
            ],
            [
                'id'    => 100,
                'title' => 'post_office_detail_access',
            ],
            [
                'id'    => 101,
                'title' => 'session_create',
            ],
            [
                'id'    => 102,
                'title' => 'session_edit',
            ],
            [
                'id'    => 103,
                'title' => 'session_show',
            ],
            [
                'id'    => 104,
                'title' => 'session_delete',
            ],
            [
                'id'    => 105,
                'title' => 'session_access',
            ],
            [
                'id'    => 106,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
