<?php

use App\Models\RideType;
use Illuminate\Database\Seeder;

class RideTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeItems = [
            [
                'title' => 'Shared',
                'slug' => 'shared',
                'description' => 'Shared Car',
                'level' => 1
            ],
            [
                'title' => 'Full',
                'slug' => 'full',
                'description' => 'Full Car',
                'level' => 2
            ],
            [
                'title' => 'Premium',
                'slug' => 'premium',
                'description' => 'Premium Car',
                'level' => 3
            ],
        ];

        foreach ($typeItems as $item) {
            $newItem = RideType::query()->where('slug', '=', $item['slug'])->first();
            if ($newItem === null) {
                $newItem = RideType::query()->create([
                    'title'          => $item['title'],
                    'slug'          => $item['slug'],
                    'description'   => $item['description'],
                    'level'         => $item['level'],
                ]);
            }
        }
    }
}
