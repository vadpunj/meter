<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->truncate();
      DB::table('users')->insert([
        [
          'name' => 'Phatsirin Srisaengchai',
          'emp_id' => '01000583',
          'type' => 1,
          'center_money' => '1N00203',
          'user_id' => '01000583',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ],
        [
          'name' => 'Dumkerng Muikeaw',
          'emp_id' => '00368195',
          'type' => 1,
          'center_money' => '1N00203',
          'user_id' => '01000583',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ],
        [
          'name' => 'Panicha Saenkhueansi',
          'emp_id' => '01000554',
          'type' => 1,
          'center_money' => '1N00203',
          'user_id' => '01000583',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ],
        [
          'name' => 'Wanida Chomthamai',
          'emp_id' => '01000103',
          'type' => 1,
          'center_money' => '1N00203',
          'user_id' => '01000583',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ],
        [
          'name' => 'Prapatsorn Prechan',
          'emp_id' => '00309374',
          'type' => 1,
          'center_money' => '1N00203',
          'user_id' => '01000583',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ],
        [
          'name' => 'Jariya Eamapichat',
          'emp_id' => '00232739',
          'type' => 1,
          'center_money' => '1N00203',
          'user_id' => '01000583',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ],
        [
          'name' => 'Punyabha Auparikchatpong',
          'emp_id' => '01000363',
          'type' => 1,
          'center_money' => '1N00203',
          'user_id' => '01000583',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ]
      ]);
    }
}
