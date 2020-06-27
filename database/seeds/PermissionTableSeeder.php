<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['id' => 1, 'name' => 'Workshop Training', 'ref_id' => null],
            ['id' => 2, 'name' => 'coursecalendar-list', 'ref_id' => 1],
            ['id' => 3, 'name' => 'coursecalendar-create', 'ref_id' => 1],
            ['id' => 4, 'name' => 'coursecalendar-edit', 'ref_id' => 1],
            ['id' => 5, 'name' => 'coursecalendar-delete', 'ref_id' => 1],
            ['id' => 6, 'name' => 'coursecalendar-checkpayment', 'ref_id' => 1],
            ['id' => 7, 'name' => 'Media Library', 'ref_id' => null],
            ['id' => 8, 'name' => 'Media', 'ref_id' => 7],
            ['id' => 9, 'name' => 'Media-delete', 'ref_id' => 7],
            ['id' => 10, 'name' => 'generalsetting', 'ref_id' => null],
            ['id' => 11, 'name' => 'Users and Role', 'ref_id' => null],
            ['id' => 12, 'name' => 'Users Management', 'ref_id' => 11],
            ['id' => 13, 'name' => 'user-list', 'ref_id' => 12],
            ['id' => 14, 'name' => 'user-create', 'ref_id' => 12],
            ['id' => 15, 'name' => 'user-edit', 'ref_id' => 12],
            ['id' => 16, 'name' => 'user-delete', 'ref_id' => 12],
            ['id' => 17, 'name' => 'Role Management', 'ref_id' => 11],
            ['id' => 18, 'name' => 'role-list', 'ref_id' => 17],
            ['id' => 19, 'name' => 'role-create', 'ref_id' => 17],
            ['id' => 20, 'name' => 'role-edit', 'ref_id' => 17],
            ['id' => 21, 'name' => 'role-delete', 'ref_id' => 17],
            ['id' => 22, 'name' => 'Permision Management', 'ref_id' => 12],
            ['id' => 23, 'name' => 'perm-list', 'ref_id' => 22],
            ['id' => 24, 'name' => 'perm-create', 'ref_id' => 22],
            ['id' => 25, 'name' => 'perm-edit', 'ref_id' => 22],
            ['id' => 26, 'name' => 'perm-delete', 'ref_id' => 22],
         ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
