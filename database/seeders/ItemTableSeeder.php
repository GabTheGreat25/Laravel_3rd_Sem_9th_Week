<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new \App\Models\Item([
            'imagePath' => 'https://hpmedia.bloomsbury.com/.../9781408855911_309576.jpeg',
            'title' => 'Harry Potter',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'cost_price' => 10, 
            'sell_price' => 10
        ]);
          $product->save();
        $product = new \App\Models\item([
            'imagePath' => 'https://hpmedia.bloomsbury.com/.../9781408855911_309576.jpeg',
            'title' => 'Harry Potter',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
             'cost_price' => 10, 
            'sell_price' => 10
        ]);
          $product->save();
        $product = new \App\Models\item([
            'imagePath' => 'https://hpmedia.bloomsbury.com/.../9781408855911_309576.jpeg',
            'title' => 'Harry Potter',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
             'cost_price' => 10, 
            'sell_price' => 10
        ]);
          $product->save();
        $product = new \App\Models\Item([
            'imagePath' => 'https://hpmedia.bloomsbury.com/.../9781408855911_309576.jpeg',
            'title' => 'Harry Potter',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
             'cost_price' => 10, 
            'sell_price' => 10
        ]);
          $product->save();
        $product = new \App\Models\Item([
            'imagePath' => 'https://hpmedia.bloomsbury.com/.../9781408855911_309576.jpeg',
            'title' => 'Harry Potter',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ',
            'cost_price' => 10, 
            'sell_price' => 10
        ]);
        $product->save();
    }
    
}
