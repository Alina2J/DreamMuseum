<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('roles')->insert([
            'role' => 'admin'
        ]);

        DB::table('roles')->insert([
            'role' => 'user'
        ]);

        DB::table('users')->insert([
             'login' => 'admin',
             'email' => 'admin@mail.ru',
             'email_verified_at' => \Carbon\Carbon::createFromDate(2023,04,01)->toDateTimeString(),
             'password' => bcrypt('admin'),
             'description' => 'admin',
             'photo_url' => 'uploads/none-img.jpg',
             'role_id' => '1',
        ]);

         $categories = ['Персонажи', 'Мебель', 'Игры', 'Оружие', 'Еда', 'Обувь', 'Автомобили', 'Органика' ];

         foreach ($categories as $category) {
             DB::table('categories')->insert([
                 'title' => $category
             ]);
         }

    }
}
