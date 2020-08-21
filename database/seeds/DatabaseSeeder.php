<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::transaction(function () {
            DB::table('admin_users')->truncate();
            DB::table('admin_users')->insert([
                'name' => 'zhubaiming',
            ]);
            DB::table('admin_menus')->truncate();
            DB::table('admin_menus')->insert([
                'name' => '首页'
            ]);
        });
    }
}
