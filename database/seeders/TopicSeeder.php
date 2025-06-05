<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slug' => 'general',
                'name' => 'General',                
                'description' => 'this is a general topic you can use.',                
            ],
            [
                'slug' => 'reviews',
                'name' => 'Reviews',                
                'description' => 'You can post here reviews of any movies.',                
            ],
           [
                'slug' => 'questions',
                'name' => 'Quetions',                
                'description' => 'post about the conspiracies in the world.',                
           ] 
        ];

        Topic::upsert($data,['slug']);
    }
}
