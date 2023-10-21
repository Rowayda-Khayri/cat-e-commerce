<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('items')->insert([
          [
              'name' => 'Item 1',
              'description' => 'This is a sample item description.',
              'price' => 19.99,
              'created_at' => now(),
              'updated_at' => now(),
          ],
          [
              'name' => 'Item 2',
              'description' => 'Another sample item description.',
              'price' => 300,
              'created_at' => now(),
              'updated_at' => now(),
          ],
          [
              'name' => 'Item 3',
              'description' => 'Yet another sample item description.',
              'price' => 50.50,
              'created_at' => now(),
              'updated_at' => now(),
          ],
      ]);
    }
}
