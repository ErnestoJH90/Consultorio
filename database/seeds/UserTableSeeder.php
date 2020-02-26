<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   ;


		 $data = array(
			[
				'name'         => 'Ernesto', 
				'last_name' => 'Jiménez', 
				'email'     => 'ernestojimhui@icloud.com', 
				'username'         => 'ErnestoJh',
				'password'     => \Hash::make('Abril9082'),
				'type'         => 'admin',
				'active'     => 1,
				'address'     => 'Apizaco, Tlaxcala',
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],
			[
				'name'         => 'Diego', 
				'last_name' => 'Jimenez', 
				'email'     => 'diego@gmail.com', 
				'username'         => 'DiegoJ',
				'password'     => \Hash::make('123456789'),
				'type'         => 'user',
				'active'     => 1,
				'address'     => 'Apizaco, Tlaxcala',
				'created_at'=> new DateTime,
				'updated_at'=> new DateTime
			],

		);
		User::insert($data);
    }
}
