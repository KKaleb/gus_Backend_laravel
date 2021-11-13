<?php
namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'id' => 1,
                'questions' => 'How many decades would make 5 Scores?',
                'opt_A' => '10 decades',
                'opt_B' => '20 decades',
                'opt_C' => '30 decades',
                'opt_D' => '50 decades',
                'correct_Answer' => '10 decades'
            ],
            [
                'id' => 2,
                'questions' => 'What is the beginning of ETERNITY? The end of TIME and SPACE, the beginning of EVERY END? And the end of EVERY PLACE?',
                'opt_A' => 'The letter E',
                'opt_B' => 'The letter V',
                'opt_C' => 'The letter R',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'The letter E'
            ],
            [
                'id' => 3,
                'questions' => 'Which letter of the English alphabet flies, sings, and stings?',
                'opt_A' => 'T (Tee)',
                'opt_B' => 'B (Bee)',
                'opt_C' => 'S (Sing)',
                'opt_D' => 'F (Fly)',
                'correct_Answer' => 'B (Bee)'
            ],
            [
                'id' => 4,
                'questions' => 'Some months have 31 days. Some have 30. How many have 28?',
                'opt_A' => '16',
                'opt_B' => '1',
                'opt_C' => '24',
                'opt_D' => '12',
                'correct_Answer' => '12'
            ],
            [
                'id' => 5,
                'questions' => 'The day before yesterday, Mary was 17, yesterday she turned 18 and next year she will be 20. What date is Mary\'s birthday?',
                'opt_A' => 'December 31',
                'opt_B' => 'December 13',
                'opt_C' => 'September 31',
                'opt_D' => 'August 31',
                'correct_Answer' => 'December 31'
            ],
            [
                'id' => 6,
                'questions' => 'Even though it belongs to you, usually others use it, what is it?',
                'opt_A' => 'Your Name',
                'opt_B' => 'People',
                'opt_C' => 'Spouse',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Your Name'
            ],
            [
                'id' => 7,
                'questions' => 'What would you have to add to the Roman numeral, IX, to make “six”?',
                'opt_A' => 'Add an S',
                'opt_B' => 'Add an L',
                'opt_C' => 'Add an M',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Add an S'
            ],
            [
                'id' => 8,
                'questions' => 'What two ingredients are used when making Gulder beer',
                'opt_A' => 'Malt and Barley',
                'opt_B' => 'Sorghum and hops',
                'opt_C' => 'Wheat and water',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Wheat and water'
            ],
            [
                'id' => 9,
                'questions' => 'What are two primary colours of Gulder',
                'opt_A' => 'Red and Yellow',
                'opt_B' => 'Gold and red',
                'opt_C' => 'Yellow and black',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Gold and red'
            ],
            [
                'id' => 10,
                'questions' => 'If you have a bowl with five eggs and you take out 3, how many eggs will you have',
                'opt_A' => '2',
                'opt_B' => '3',
                'opt_C' => '4',
                'opt_D' => 'None of the above',
                'correct_Answer' => '3'
            ],
            [
                'id' => 11,
                'questions' => 'Some months have 31 days, others have 30 days, but how many have 28 days?',
                'opt_A' => 'One',
                'opt_B' => 'All',
                'opt_C' => 'Few',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'All'
            ],
            [
                'id' => 12,
                'questions' => 'What goes up and down, but always remains in the same place?',
                'opt_A' => 'Umbrella',
                'opt_B' => 'Stairs',
                'opt_C' => 'Rain',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Stairs'
            ],
            [
                'id' => 13,
                'questions' => 'Divide 30 by half and add ten, what do you get?',
                'opt_A' => '65',
                'opt_B' => '89',
                'opt_C' => '70',
                'opt_D' => 'None of the above',
                'correct_Answer' => '70'
            ],
            [
                'id' => 14,
                'questions' => 'If an electric train is moving north at 100mph and a wind is blowing to the west at 10mph, which way does the smoke blow?',
                'opt_A' => 'East',
                'opt_B' => 'West',
                'opt_C' => 'Not blowing',
                'opt_D' => 'South',
                'correct_Answer' => 'Not Blowing'
            ],
            [
                'id' => 15,
                'questions' => 'What is it that lives if it is fed, and dies if you give it a drink?',
                'opt_A' => 'Fire',
                'opt_B' => 'Well',
                'opt_C' => 'Dam',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Fire'
            ],
            [
                'id' => 16,
                'questions' => 'What is tall, but the longer it stands, the shorter it grows?',
                'opt_A' => 'Tree',
                'opt_B' => 'Candle',
                'opt_C' => 'Wall',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Candle'
            ],
            [
                'id' => 17,
                'questions' => 'I am an odd number. Take away one letter and I become even. What number am I?',
                'opt_A' => 'Eight',
                'opt_B' => 'Even',
                'opt_C' => 'Eleven',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'Even'
            ],
            [
                'id' => 18,
                'questions' => 'What gets sharper the more you use it?',
                'opt_A' => 'A knife',
                'opt_B' => 'A razor',
                'opt_C' => 'The brain',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'The brain'
            ],
            [
                'id' => 19,
                'questions' => 'What goes up as soon as the rain comes down?',
                'opt_A' => 'A cold',
                'opt_B' => 'An Umbrella',
                'opt_C' => 'The Sun',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'An Umbrella'
            ],
            [
                'id' => 20,
                'questions' => 'How many legs does an elephant have if you count his trunk as a leg?',
                'opt_A' => '5',
                'opt_B' => '6',
                'opt_C' => '4',
                'opt_D' => 'None of the above',
                'correct_Answer' => '4'
            ],
            [
                'id' => 21,
                'questions' => 'What has a neck but no head?',
                'opt_A' => 'A Bottle',
                'opt_B' => 'A Tree',
                'opt_C' => 'A Jar',
                'opt_D' => 'None of the above',
                'correct_Answer' => 'A Bottle'
            ],
        ];

        foreach ($questions as $question)
        {
            Question::firstOrCreate($question);
        }

    }
}
