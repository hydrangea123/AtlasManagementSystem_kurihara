<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        ['over_name'        => '高橋',
        'under_name'       => '一郎',
        'over_name_kana'   => 'タカハシ',
        'under_name_kana'  => 'イチロウ',
        'mail_address'     => 'a@gmail.com',
        'sex'              => '1',
        'birth_day'        => '19910111',
        'role'             => '1',
        'password'         => Hash::make('password'),
        ],
        ]);
    }
}
