<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Test;
use App\Models\Question;

class ExamlinSampleSeeder extends Seeder
{
    public function run(): void
    {
        // ===========================
        // TEAS® Exam (Nursing)
        // ===========================
        $teas = Exam::create([
            'title' => 'TEAS®',
            'slug' => 'teas',
            'category_label' => 'Nursing Exams',
            'description' => 'Prepare for the Test of Essential Academic Skills with practice questions covering reading, math, science, and English.',
            'is_active' => true,
            'order' => 1,
        ]);

        // --- Math Subject ---
        $teasMath = Subject::create([
            'exam_id' => $teas->id,
            'name' => 'Math',
            'slug' => 'math',
            'order' => 1,
        ]);

        $teasMathTest1 = Test::create([
            'subject_id' => $teasMath->id,
            'title' => 'Practice Test 1',
            'slug' => 'practice-test-1',
            'question_count' => 5,
            'duration_minutes' => 15,
            'is_free' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        // Sample TEAS Math Questions (with JSON choices)
        Question::create([
            'test_id' => $teasMathTest1->id,
            'order' => 1,
            'question_text' => 'What is the value of x in the equation: 3x + 7 = 22?',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => 'x = 3', 'is_correct' => false],
                ['letter' => 'B', 'text' => 'x = 5', 'is_correct' => true],
                ['letter' => 'C', 'text' => 'x = 7', 'is_correct' => false],
                ['letter' => 'D', 'text' => 'x = 15', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Solving Linear Equations',
            'rationale_content' => 'Subtract 7 from both sides: 3x = 15. Then divide by 3: x = 5. Always isolate the variable by performing inverse operations.',
            'is_active' => true,
        ]);

        Question::create([
            'test_id' => $teasMathTest1->id,
            'order' => 2,
            'question_text' => 'Convert 0.75 to a fraction in simplest form.',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => '1/2', 'is_correct' => false],
                ['letter' => 'B', 'text' => '2/3', 'is_correct' => false],
                ['letter' => 'C', 'text' => '3/4', 'is_correct' => true],
                ['letter' => 'D', 'text' => '4/5', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Decimal to Fraction Conversion',
            'rationale_content' => '0.75 means 75/100. Simplify by dividing numerator and denominator by 25: 75÷25=3, 100÷25=4. Result: 3/4.',
            'is_active' => true,
        ]);

        Question::create([
            'test_id' => $teasMathTest1->id,
            'order' => 3,
            'question_text' => 'A rectangle has a length of 8 cm and a width of 5 cm. What is its area?',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => '13 cm²', 'is_correct' => false],
                ['letter' => 'B', 'text' => '26 cm²', 'is_correct' => false],
                ['letter' => 'C', 'text' => '40 cm²', 'is_correct' => true],
                ['letter' => 'D', 'text' => '80 cm²', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Area of a Rectangle',
            'rationale_content' => 'Area = length × width. So 8 cm × 5 cm = 40 cm². Remember: area is always in square units.',
            'is_active' => true,
        ]);

        Question::create([
            'test_id' => $teasMathTest1->id,
            'order' => 4,
            'question_text' => 'What is 20% of 150?',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => '15', 'is_correct' => false],
                ['letter' => 'B', 'text' => '20', 'is_correct' => false],
                ['letter' => 'C', 'text' => '30', 'is_correct' => true],
                ['letter' => 'D', 'text' => '45', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Percentage Calculation',
            'rationale_content' => '20% = 0.20. Multiply: 0.20 × 150 = 30. Tip: Move the decimal two places left to convert % to decimal.',
            'is_active' => true,
        ]);

        Question::create([
            'test_id' => $teasMathTest1->id,
            'order' => 5,
            'question_text' => 'Simplify: 2³ × 2⁴',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => '2⁷', 'is_correct' => true],
                ['letter' => 'B', 'text' => '2¹²', 'is_correct' => false],
                ['letter' => 'C', 'text' => '4⁷', 'is_correct' => false],
                ['letter' => 'D', 'text' => '8⁷', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Exponent Rules',
            'rationale_content' => 'When multiplying powers with the same base, add the exponents: 2³ × 2⁴ = 2^(3+4) = 2⁷. This is the product rule for exponents.',
            'is_active' => true,
        ]);

        // --- Science Subject ---
        $teasScience = Subject::create([
            'exam_id' => $teas->id,
            'name' => 'Science',
            'slug' => 'science',
            'order' => 2,
        ]);

        $teasScienceTest1 = Test::create([
            'subject_id' => $teasScience->id,
            'title' => 'Practice Test 1',
            'slug' => 'practice-test-1',
            'question_count' => 3,
            'duration_minutes' => 10,
            'is_free' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        Question::create([
            'test_id' => $teasScienceTest1->id,
            'order' => 1,
            'question_text' => 'Which organelle is known as the "powerhouse of the cell"?',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => 'Nucleus', 'is_correct' => false],
                ['letter' => 'B', 'text' => 'Ribosome', 'is_correct' => false],
                ['letter' => 'C', 'text' => 'Mitochondria', 'is_correct' => true],
                ['letter' => 'D', 'text' => 'Endoplasmic Reticulum', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Cell Biology Fundamentals',
            'rationale_content' => 'Mitochondria produce ATP through cellular respiration, providing energy for cellular processes. This is a core concept in biology.',
            'is_active' => true,
        ]);

        // ===========================
        // GMAT® Exam (Graduate)
        // ===========================
        $gmat = Exam::create([
            'title' => 'GMAT®',
            'slug' => 'gmat',
            'category_label' => 'Graduate Exams',
            'description' => 'Prepare for the Graduate Management Admission Test with practice questions covering quantitative, verbal, and integrated reasoning.',
            'is_active' => true,
            'order' => 2,
        ]);

        // --- Quantitative Reasoning Subject ---
        $gmatQuant = Subject::create([
            'exam_id' => $gmat->id,
            'name' => 'Quantitative Reasoning',
            'slug' => 'quantitative',
            'order' => 1,
        ]);

        $gmatQuantTest1 = Test::create([
            'subject_id' => $gmatQuant->id,
            'title' => 'Practice Test 1',
            'slug' => 'practice-test-1',
            'question_count' => 3,
            'duration_minutes' => 20,
            'is_free' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        Question::create([
            'test_id' => $gmatQuantTest1->id,
            'order' => 1,
            'question_text' => 'If x + y = 10 and x - y = 4, what is the value of x?',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => '3', 'is_correct' => false],
                ['letter' => 'B', 'text' => '5', 'is_correct' => false],
                ['letter' => 'C', 'text' => '7', 'is_correct' => true],
                ['letter' => 'D', 'text' => '9', 'is_correct' => false],
            ]),
            'rationale_heading' => 'System of Equations',
            'rationale_content' => 'Add the two equations: (x+y) + (x-y) = 10+4 → 2x = 14 → x = 7. Then substitute back to find y = 3. This elimination method is efficient for linear systems.',
            'is_active' => true,
        ]);

        Question::create([
            'test_id' => $gmatQuantTest1->id,
            'order' => 2,
            'question_text' => 'A store offers a 20% discount followed by an additional 10% off the reduced price. What is the total percent discount from the original price?',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => '28%', 'is_correct' => true],
                ['letter' => 'B', 'text' => '30%', 'is_correct' => false],
                ['letter' => 'C', 'text' => '32%', 'is_correct' => false],
                ['letter' => 'D', 'text' => '72%', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Successive Percentages',
            'rationale_content' => 'After 20% off, price is 80% of original. Then 10% off that: 0.90 × 0.80 = 0.72 (72% of original). Total discount: 100% - 72% = 28%. Note: successive discounts are multiplicative, not additive.',
            'is_active' => true,
        ]);

        // --- Verbal Reasoning Subject ---
        $gmatVerbal = Subject::create([
            'exam_id' => $gmat->id,
            'name' => 'Verbal Reasoning',
            'slug' => 'verbal',
            'order' => 2,
        ]);

        $gmatVerbalTest1 = Test::create([
            'subject_id' => $gmatVerbal->id,
            'title' => 'Practice Test 1',
            'slug' => 'practice-test-1',
            'question_count' => 2,
            'duration_minutes' => 15,
            'is_free' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        Question::create([
            'test_id' => $gmatVerbalTest1->id,
            'order' => 1,
            'question_text' => 'Choose the sentence that is grammatically correct:',
            'choices' => json_encode([
                ['letter' => 'A', 'text' => 'Neither the manager nor the employees was aware of the change.', 'is_correct' => false],
                ['letter' => 'B', 'text' => 'Neither the manager nor the employees were aware of the change.', 'is_correct' => true],
                ['letter' => 'C', 'text' => 'Neither the manager or the employees were aware of the change.', 'is_correct' => false],
                ['letter' => 'D', 'text' => 'Neither the manager nor the employees is aware of the change.', 'is_correct' => false],
            ]),
            'rationale_heading' => 'Subject-Verb Agreement with "Neither/Nor"',
            'rationale_content' => 'With "neither/nor", the verb agrees with the subject closest to it. Here, "employees" (plural) is closest, so use "were". Also, "neither" pairs with "nor", not "or".',
            'is_active' => true,
        ]);
    }
}