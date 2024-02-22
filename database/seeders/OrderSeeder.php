<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'id' => Str::uuid()->toString(),
            'user_id' => 'Iv7auohPKpgcfjyvXVbZmWbbcan2',
            'total_topup' => 200000,
            'status' => 'Paid',
        ]);
    }
}

// $table->string('user_id');
// $table->bigInteger('total_topup');
// $table->enum('status', ['Unpaid', 'Paid']);
// $table->timestamps();