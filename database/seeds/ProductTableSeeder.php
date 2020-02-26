<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductTableSeeder extends Seeder
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
				'name' => 'Tempra Infantil',
				'slug' => 'tempra Infantil',
				'description' => 'Tomar paracetamol o acetaminofén (Tylenol) puede ayudar a los niños con resfriados y fiebre a sentirse mejor ',
				'stract' => 'Tratamiento sintomático de dolor leve a moderado y fiebre.',
				'price' => 109.00,
				'image' => 'images/Tempra Inf.JFIF',
				'visible' => 1,
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				'category_id' => 1
			],
			[
				'name' => 'Aspirina',
				'slug' => 'Aspirina',
				'description' => 'Este producto es así',
				'stract' => 'Ayuda a que la fiebre disminuya, previene y trata los trombos sanguíneos y alivia el dolor moderado.',
				'price' => 50.00,
				'image' => 'images/Aspirina.JPG',
				'visible' => 1,
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
				'category_id' => 1
			],
				
		);
		Product::insert($data);
    }
}
