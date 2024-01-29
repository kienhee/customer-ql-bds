<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Thêm dữ liệu cho bảng 'groups'
        $groups = [
            ['name' => 'Developer', 'permissions' => '{"users":["view","add","edit","delete"],"library":["view"],"permission":["view","add","edit","delete"],"settings":["view"],"dashboard":["view"]}', 'created_at' => '2024-01-25 18:07:18', 'updated_at' => '2024-01-26 11:02:21'],
            ['name' => 'Admin', 'permissions' => '{"users":["view","add","edit","delete"],"library":["view"],"permission":["view","add","edit","delete"],"settings":["view"],"dashboard":["view"]}', 'created_at' => '2024-01-24 02:16:42', 'updated_at' => '2024-01-26 11:02:30'],
        ];

        DB::table('groups')->insert($groups);

        // Thêm dữ liệu cho bảng 'modules'
        $modules = [
            ['route' => 'users', 'title' => 'Manage users', 'description' => 'Quản lý người dùng', 'created_at' => '2024-01-26 11:05:37', 'updated_at' => '2024-01-26 11:05:37'],
            ['route' => 'library', 'title' => 'Library', 'description' => 'Quản lý thư viện hình ảnh, video, tệp..v.v', 'created_at' => '2024-01-26 11:06:26', 'updated_at' => '2024-01-26 11:06:26'],
            ['route' => 'permission', 'title' => 'Roles', 'description' => 'Phân quyền ứng dụng', 'created_at' => '2024-01-26 11:07:09', 'updated_at' => '2024-01-26 10:13:34'],
            ['route' => 'settings', 'title' => 'Settings', 'description' => null, 'created_at' => '2024-01-26 16:05:10', 'updated_at' => '2024-01-26 16:05:10'],
            ['route' => 'dashboard', 'title' => 'Dashboard', 'description' => null, 'created_at' => '2024-01-26 16:08:38', 'updated_at' => '2024-01-26 16:08:38'],
        ];

        DB::table('modules')->insert($modules);
    }
}
