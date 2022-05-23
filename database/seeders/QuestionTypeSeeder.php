<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_types')->truncate();

        $types = ['Single Choice', 'Multiple Choice', 'True/False'];

        foreach ($types as $key => $type) {
            QuestionType::create([
                'id' => $key+1,
                'type' => $type
            ]);
        }
    }
}
