<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Desk;
use App\Models\DeskList;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
                // Card::factory(100)->create();
//                 Desk::factory(100)->create();
//                 DeskList::factory(100)->create();
                 Task::factory(100)->create();
    }
}
