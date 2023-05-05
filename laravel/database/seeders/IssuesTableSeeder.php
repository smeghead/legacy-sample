<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IssuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('issues')->insert(
            [
                [
                    'summary' => 'test',
                    'status' => 'created',
                    'description' => 'issue',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
