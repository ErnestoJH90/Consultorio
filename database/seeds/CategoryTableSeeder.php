<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $data = array(
			[
				'name' => 'Adulto', 
				'slug' => 'Adulto', 
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore, perferendis!', 
			],
			[
				'name' => 'Infantil', 
				'slug' => 'Infantil', 
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore, perferendis!', 
			]
		);
		Category::insert($data);
    }
}
