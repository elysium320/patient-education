<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['English', 'Spanish', 'Cardiovascular','Respiratory', 'Digestive', 'Endocrine', 'Rheumatology','Nephrology', 'Infectious Disease', 'Mental Health', 'General','Pulmonary'];

        foreach ($categories as $key => $category) {
            $categoryExists = Category::whereName($category)->exists();

            if (!$categoryExists) {
                Category::create(['name' => $category]);
            }

        }
    }
}
