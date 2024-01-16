<?php

namespace Database\Seeders;

use App\Enums\QuestionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $questions = [
            [
                'question' => 'Who said “I have a dream”?',
                'question_type' => QuestionType::MultipleChoice,
                'choices' => [
                    [
                        'choice' => 'Martin Luther King Jr.',
                        'is_correct' => true
                    ],

                    [
                        'choice' => 'Barrack Obama',
                        'is_correct' => false
                    ],
                    [
                        'choice' => 'Nelson Mandela',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “Be the change you wish to see in the world”?',
                'question_type' => QuestionType::MultipleChoice,
                'choices' => [
                    [
                        'choice' => 'Winston Churchill',
                        'is_correct' => false
                    ],
                    [
                        'choice' => 'Mahatma Gandhi',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'Abraham Lincoln',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “The only thing we have to fear is fear itself”?',
                'question_type' => QuestionType::MultipleChoice,
                'choices' => [
                    [
                        'choice' => 'Franklin D. Roosevelt',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'John F. Kennedy',
                        'is_correct' => false
                    ],
                    [
                        'choice' => 'Ronald Reagan',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “Ask not what your country can do for you, ask what you can do for your country”?',
                'question_type' => QuestionType::MultipleChoice,
                'choices' => [
                    [
                        'choice' => 'John F. Kennedy',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'George Washington',
                        'is_correct' => false
                    ],
                    [
                        'choice' => 'Abraham Lincoln',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “I am the greatest”?',
                'question_type' => QuestionType::MultipleChoice,
                'choices' => [
                    [
                        'choice' => 'Muhammad Ali',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'Mike Tyson',
                        'is_correct' => false
                    ],
                    [
                        'choice' => 'Sugar Ray Leonard',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “Float like a butterfly, sting like a bee”?',
                'question_type' => QuestionType::MultipleChoice,
                'choices' => [
                    [
                        'choice' => 'Muhammad Ali',
                        'is_correct' => true

                    ],
                    [
                        'choice' => 'Mike Tyson',
                        'is_correct' => false
                    ],
                    [
                        'choice' => 'Sugar Ray Leonard',
                        'is_correct' => false
                    ]
                ]
            ]
        ];

        $binary = [
            [
                'question' => 'Who said “I have a dream”?',
                'question_type' => QuestionType::Binary,
                'choices' => [
                    [
                        'choice' => 'Martin Luther King Jr.',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'Nelson Mandela',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “Be the change you wish to see in the world”?',
                'question_type' => QuestionType::Binary,
                'choices' => [
                    [
                        'choice' => 'Winston Churchill',
                        'is_correct' => false
                    ],
                    [
                        'choice' => 'Mahatma Gandhi',
                        'is_correct' => true
                    ],
                ]
            ],
            [
                'question' => 'Who said “The only thing we have to fear is fear itself”?',
                'question_type' => QuestionType::Binary,
                'choices' => [
                    [
                        'choice' => 'Franklin D. Roosevelt',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'Ronald Reagan',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “Ask not what your country can do for you, ask what you can do for your country”?',
                'question_type' => QuestionType::Binary,
                'choices' => [
                    [
                        'choice' => 'John F. Kennedy',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'George Washington',
                        'is_correct' => false
                    ],
                ]
            ],
            [
                'question' => 'Who said “I am the greatest”?',
                'question_type' => QuestionType::Binary,
                'choices' => [
                    [
                        'choice' => 'Muhammad Ali',
                        'is_correct' => true
                    ],
                    [
                        'choice' => 'Sugar Ray Leonard',
                        'is_correct' => false
                    ]
                ]
            ],
            [
                'question' => 'Who said “Float like a butterfly, sting like a bee”?',
                'question_type' => QuestionType::Binary,
                'choices' => [
                    [
                        'choice' => 'Muhammad Ali',
                        'is_correct' => true

                    ],
                    [
                        'choice' => 'Mike Tyson',
                        'is_correct' => false
                    ],
                ]
            ]
        ];

        foreach ($questions as $question) {
            $questionId = DB::table('questions')->insertGetId([
                'question' => $question['question'],
                'question_type' => $question['question_type'],
            ]);

            foreach ($question['choices'] as $choice) {
                DB::table('question_choices')->insert([
                    'question_id' => $questionId,
                    'choice' => $choice['choice'],
                    'is_correct' => $choice['is_correct'],
                ]);
            }
        }
        foreach ($binary as $question) {
            $questionId = DB::table('questions')->insertGetId([
                'question' => $question['question'],
                'question_type' => $question['question_type'],
            ]);

            foreach ($question['choices'] as $choice) {
                DB::table('question_choices')->insert([
                    'question_id' => $questionId,
                    'choice' => $choice['choice'],
                    'is_correct' => $choice['is_correct'],
                ]);
            }
        }

    }
}
