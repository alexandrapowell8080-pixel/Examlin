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
        // TEAS® Exam (Nursing) - EXISTING CONTENT
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

        $this->createTeasMathQuestions($teasMathTest1);

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
        // GMAT® Exam (Graduate) - EXPANDED CONTENT
        // ===========================
        $gmat = Exam::create([
            'title' => 'GMAT®',
            'slug' => 'gmat',
            'category_label' => 'Graduate Exams',
            'description' => 'Prepare for the Graduate Management Admission Test with practice questions covering quantitative, verbal, and integrated reasoning.',
            'is_active' => true,
            'order' => 2,
        ]);

        // --- 1. Quantitative Reasoning (5 tests × 5 questions) ---
        $gmatQuant = Subject::create([
            'exam_id' => $gmat->id,
            'name' => 'Quantitative Reasoning',
            'slug' => 'quantitative',
            'order' => 1,
        ]);

        $this->createGmatSubjectTests($gmatQuant, 'Quantitative Reasoning', [
            'Algebra & Linear Equations',
            'Percentages & Ratios',
            'Geometry & Measurement',
            'Probability & Statistics',
            'Number Properties',
        ]);

        // --- 2. Verbal Reasoning (5 tests × 5 questions) ---
        $gmatVerbal = Subject::create([
            'exam_id' => $gmat->id,
            'name' => 'Verbal Reasoning',
            'slug' => 'verbal',
            'order' => 2,
        ]);

        $this->createGmatSubjectTests($gmatVerbal, 'Verbal Reasoning', [
            'Reading Comprehension',
            'Critical Reasoning',
            'Sentence Correction',
            'Argument Analysis',
            'Inference & Assumption',
        ]);

        // --- 3. Integrated Reasoning (5 tests × 5 questions) ---
        $gmatIntegrated = Subject::create([
            'exam_id' => $gmat->id,
            'name' => 'Integrated Reasoning',
            'slug' => 'integrated',
            'order' => 3,
        ]);

        $this->createGmatSubjectTests($gmatIntegrated, 'Integrated Reasoning', [
            'Multi-Source Reasoning',
            'Table Analysis',
            'Graphics Interpretation',
            'Two-Part Analysis',
            'Data Interpretation',
        ]);

        // --- 4. Analytical Writing (5 tests × 5 questions) ---
        $gmatWriting = Subject::create([
            'exam_id' => $gmat->id,
            'name' => 'Analytical Writing',
            'slug' => 'analytical',
            'order' => 4,
        ]);

        $this->createGmatSubjectTests($gmatWriting, 'Analytical Writing', [
            'Argument Evaluation',
            'Issue Analysis',
            'Critical Thinking',
            'Essay Structure',
            'Evidence Assessment',
        ]);
    }

    // ===========================
    // HELPER METHODS
    // ===========================

    private function createTeasMathQuestions($test): void
    {
        $questions = [
            [
                'order' => 1,
                'text' => 'What is the value of x in the equation: 3x + 7 = 22?',
                'choices' => [
                    ['letter' => 'A', 'text' => 'x = 3', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'x = 5', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'x = 7', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'x = 15', 'is_correct' => false],
                ],
                'rationale_heading' => 'Solving Linear Equations',
                'rationale_content' => 'Subtract 7 from both sides: 3x = 15. Then divide by 3: x = 5. Always isolate the variable by performing inverse operations.',
            ],
            [
                'order' => 2,
                'text' => 'Convert 0.75 to a fraction in simplest form.',
                'choices' => [
                    ['letter' => 'A', 'text' => '1/2', 'is_correct' => false],
                    ['letter' => 'B', 'text' => '2/3', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '3/4', 'is_correct' => true],
                    ['letter' => 'D', 'text' => '4/5', 'is_correct' => false],
                ],
                'rationale_heading' => 'Decimal to Fraction Conversion',
                'rationale_content' => '0.75 means 75/100. Simplify by dividing numerator and denominator by 25: 75÷25=3, 100÷25=4. Result: 3/4.',
            ],
            [
                'order' => 3,
                'text' => 'A rectangle has a length of 8 cm and a width of 5 cm. What is its area?',
                'choices' => [
                    ['letter' => 'A', 'text' => '13 cm²', 'is_correct' => false],
                    ['letter' => 'B', 'text' => '26 cm²', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '40 cm²', 'is_correct' => true],
                    ['letter' => 'D', 'text' => '80 cm²', 'is_correct' => false],
                ],
                'rationale_heading' => 'Area of a Rectangle',
                'rationale_content' => 'Area = length × width. So 8 cm × 5 cm = 40 cm². Remember: area is always in square units.',
            ],
            [
                'order' => 4,
                'text' => 'What is 20% of 150?',
                'choices' => [
                    ['letter' => 'A', 'text' => '15', 'is_correct' => false],
                    ['letter' => 'B', 'text' => '20', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '30', 'is_correct' => true],
                    ['letter' => 'D', 'text' => '45', 'is_correct' => false],
                ],
                'rationale_heading' => 'Percentage Calculation',
                'rationale_content' => '20% = 0.20. Multiply: 0.20 × 150 = 30. Tip: Move the decimal two places left to convert % to decimal.',
            ],
            [
                'order' => 5,
                'text' => 'Simplify: 2³ × 2⁴',
                'choices' => [
                    ['letter' => 'A', 'text' => '2⁷', 'is_correct' => true],
                    ['letter' => 'B', 'text' => '2¹²', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '4⁷', 'is_correct' => false],
                    ['letter' => 'D', 'text' => '8⁷', 'is_correct' => false],
                ],
                'rationale_heading' => 'Exponent Rules',
                'rationale_content' => 'When multiplying powers with the same base, add the exponents: 2³ × 2⁴ = 2^(3+4) = 2⁷. This is the product rule for exponents.',
            ],
        ];

        foreach ($questions as $q) {
            Question::create([
                'test_id' => $test->id,
                'order' => $q['order'],
                'question_text' => $q['text'],
                'choices' => json_encode($q['choices']),
                'rationale_heading' => $q['rationale_heading'],
                'rationale_content' => $q['rationale_content'],
                'is_active' => true,
            ]);
        }
    }

    private function createGmatSubjectTests($subject, string $subjectName, array $topics): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $test = Test::create([
                'subject_id' => $subject->id,
                'title' => "Practice Test {$i}",
                'slug' => "practice-test-{$i}",
                'question_count' => 5,
                'duration_minutes' => 15,
                'is_free' => true,
                'is_active' => true,
                'order' => $i,
            ]);

            $this->createGmatQuestions($test, $subjectName, $topics[$i - 1] ?? 'General Practice');
        }
    }

    private function createGmatQuestions($test, string $subjectName, string $topic): void
    {
        $questions = $this->getGmatQuestionsBySubject($subjectName, $topic);

        foreach ($questions as $index => $q) {
            Question::create([
                'test_id' => $test->id,
                'order' => $index + 1,
                'question_text' => $q['text'],
                'choices' => json_encode($q['choices']),
                'rationale_heading' => $q['rationale_heading'],
                'rationale_content' => $q['rationale_content'],
                'is_active' => true,
            ]);
        }
    }

    private function getGmatQuestionsBySubject(string $subjectName, string $topic): array
    {
        return match ($subjectName) {
            'Quantitative Reasoning' => $this->getQuantQuestions($topic),
            'Verbal Reasoning' => $this->getVerbalQuestions($topic),
            'Integrated Reasoning' => $this->getIntegratedQuestions($topic),
            'Analytical Writing' => $this->getWritingQuestions($topic),
            default => $this->getGenericQuestions(),
        };
    }

    private function getQuantQuestions(string $topic): array
    {
        return [
            [
                'text' => "GMAT® {$topic} question: What is the value of x in the equation: 3x + 7 = 22?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'x = 3', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'x = 5', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'x = 7', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'x = 15', 'is_correct' => false],
                ],
                'rationale_heading' => 'Solving Linear Equations',
                'rationale_content' => 'Subtract 7 from both sides: 3x = 15. Then divide by 3: x = 5. Always isolate the variable by performing inverse operations. This is a fundamental algebra concept tested on the GMAT.',
            ],
            [
                'text' => "GMAT® {$topic} question: If a store offers a 20% discount followed by an additional 10% off, what is the total percent discount from the original price?",
                'choices' => [
                    ['letter' => 'A', 'text' => '28%', 'is_correct' => true],
                    ['letter' => 'B', 'text' => '30%', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '32%', 'is_correct' => false],
                    ['letter' => 'D', 'text' => '72%', 'is_correct' => false],
                ],
                'rationale_heading' => 'Successive Percentages',
                'rationale_content' => 'After 20% off, price is 80% of original. Then 10% off that: 0.90 × 0.80 = 0.72 (72% of original). Total discount: 100% - 72% = 28%. Note: successive discounts are multiplicative, not additive.',
            ],
            [
                'text' => "GMAT® {$topic} question: A rectangle has a length of 8 cm and a width of 5 cm. What is its area?",
                'choices' => [
                    ['letter' => 'A', 'text' => '13 cm²', 'is_correct' => false],
                    ['letter' => 'B', 'text' => '26 cm²', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '40 cm²', 'is_correct' => true],
                    ['letter' => 'D', 'text' => '80 cm²', 'is_correct' => false],
                ],
                'rationale_heading' => 'Area of a Rectangle',
                'rationale_content' => 'Area = length × width. So 8 cm × 5 cm = 40 cm². Remember: area is always in square units. This is a basic geometry concept frequently tested on the GMAT Quantitative section.',
            ],
            [
                'text' => "GMAT® {$topic} question: What is 20% of 150?",
                'choices' => [
                    ['letter' => 'A', 'text' => '15', 'is_correct' => false],
                    ['letter' => 'B', 'text' => '20', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '30', 'is_correct' => true],
                    ['letter' => 'D', 'text' => '45', 'is_correct' => false],
                ],
                'rationale_heading' => 'Percentage Calculation',
                'rationale_content' => '20% = 0.20. Multiply: 0.20 × 150 = 30. Tip: Move the decimal two places left to convert % to decimal, then multiply by the base number. This is essential for GMAT problem-solving questions.',
            ],
            [
                'text' => "GMAT® {$topic} question: Simplify: 2³ × 2⁴",
                'choices' => [
                    ['letter' => 'A', 'text' => '2⁷', 'is_correct' => true],
                    ['letter' => 'B', 'text' => '2¹²', 'is_correct' => false],
                    ['letter' => 'C', 'text' => '4⁷', 'is_correct' => false],
                    ['letter' => 'D', 'text' => '8⁷', 'is_correct' => false],
                ],
                'rationale_heading' => 'Exponent Rules',
                'rationale_content' => 'When multiplying powers with the same base, add the exponents: 2³ × 2⁴ = 2^(3+4) = 2⁷. This is the product rule for exponents. Common GMAT exponent rules include product, quotient, and power rules.',
            ],
        ];
    }

    private function getVerbalQuestions(string $topic): array
    {
        return [
            [
                'text' => "GMAT® {$topic} question: Choose the sentence that is grammatically correct:",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Neither the manager nor the employees was aware of the change.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Neither the manager nor the employees were aware of the change.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Neither the manager or the employees were aware of the change.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Neither the manager nor the employees is aware of the change.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Subject-Verb Agreement with "Neither/Nor"',
                'rationale_content' => 'With "neither/nor", the verb agrees with the subject closest to it. Here, "employees" (plural) is closest, so use "were". Also, "neither" pairs with "nor", not "or". This is a common GMAT sentence correction pattern.',
            ],
            [
                'text' => "GMAT® {$topic} question: Which of the following best strengthens the argument: \"All birds can fly. Penguins are birds. Therefore, penguins can fly.\"?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Penguins have wings.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'The premise "All birds can fly" is false.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Penguins live in Antarctica.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Some birds cannot fly.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Argument Analysis',
                'rationale_content' => 'The argument\'s weakness lies in the false premise that "All birds can fly." Identifying false premises is key to critical reasoning. Penguins, ostriches, and emus are birds that cannot fly, making the premise incorrect.',
            ],
            [
                'text' => "GMAT® {$topic} question: Read the passage and answer: What is the author\'s primary purpose?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'To entertain with a fictional story', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'To persuade readers to change their behavior', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'To describe a historical event', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'To explain a scientific process', 'is_correct' => false],
                ],
                'rationale_heading' => 'Reading Comprehension Strategy',
                'rationale_content' => 'The author uses persuasive language and calls to action throughout the passage. When identifying author\'s purpose, look for tone words, rhetorical questions, and direct appeals to the reader. This is a key GMAT reading comprehension skill.',
            ],
            [
                'text' => "GMAT® {$topic} question: Which statement is an assumption underlying the argument: \"We should ban plastic bags because they harm marine life.\"?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Marine life is important to preserve.', 'is_correct' => true],
                    ['letter' => 'B', 'text' => 'Plastic bags are the only pollutant.', 'is_correct' => false],
                    ['letter' => 'C', 'text' => 'All marine animals eat plastic.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Banning bags will increase taxes.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Identifying Assumptions',
                'rationale_content' => 'An assumption is an unstated premise that must be true for the conclusion to hold. The argument assumes that preserving marine life is valuable. Without this assumption, the conclusion doesn\'t follow. This is a classic GMAT critical reasoning question type.',
            ],
            [
                'text' => "GMAT® {$topic} question: Which of the following best completes the analogy: Teacher is to classroom as doctor is to ____?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Medicine', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Hospital', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Patient', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Stethoscope', 'is_correct' => false],
                ],
                'rationale_heading' => 'Analogical Reasoning',
                'rationale_content' => 'The relationship is "professional is to workplace." A teacher works in a classroom, and a doctor works in a hospital. When solving analogy questions, first identify the relationship type, then find the pair with the same relationship.',
            ],
        ];
    }

    private function getIntegratedQuestions(string $topic): array
    {
        return [
            [
                'text' => "GMAT® {$topic} question: Based on the data table, if Company A\'s revenue increased by 15% in 2024, what was the new revenue? (Original: $200M)",
                'choices' => [
                    ['letter' => 'A', 'text' => '$215 million', 'is_correct' => false],
                    ['letter' => 'B', 'text' => '$230 million', 'is_correct' => true],
                    ['letter' => 'C', 'text' => '$245 million', 'is_correct' => false],
                    ['letter' => 'D', 'text' => '$250 million', 'is_correct' => false],
                ],
                'rationale_heading' => 'Data Interpretation',
                'rationale_content' => '15% of $200M = $30M. New revenue = $200M + $30M = $230M. When interpreting data tables, always identify the base value first, then apply the percentage change. This type of multi-step calculation is common in GMAT Integrated Reasoning.',
            ],
            [
                'text' => "GMAT® {$topic} question: From the graph shown, during which quarter did sales increase the most?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Q1 to Q2', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Q2 to Q3', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Q3 to Q4', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'All quarters were equal', 'is_correct' => false],
                ],
                'rationale_heading' => 'Graph Analysis',
                'rationale_content' => 'The steepest upward slope on the graph indicates the greatest increase. Q2 to Q3 shows the largest positive change. When analyzing graphs on the GMAT, look for the steepest slope (greatest rate of change) and compare absolute differences between data points.',
            ],
            [
                'text' => "GMAT® {$topic} question: If 3 out of 5 sources confirm that sales increased, but 2 sources contradict, what is the most logical conclusion?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Sales definitely increased.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'The evidence is inconclusive and requires further investigation.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Sales definitely decreased.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Ignore the contradicting sources.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Multi-Source Reasoning',
                'rationale_content' => 'When sources conflict, the logical conclusion is that more information is needed. The GMAT tests your ability to recognize when data is insufficient. Never jump to conclusions when evidence is contradictory; instead, identify what additional information would resolve the conflict.',
            ],
            [
                'text' => "GMAT® {$topic} question: In a two-part analysis, if Column A requires selecting the correct formula and Column B requires the calculated result, which pair is correct? (Formula: P = 2(l + w), l=10, w=5)",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Column A: P = l × w, Column B: 50', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Column A: P = 2(l + w), Column B: 30', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Column A: P = l + w, Column B: 15', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Column A: P = 2l + w, Column B: 25', 'is_correct' => false],
                ],
                'rationale_heading' => 'Two-Part Analysis',
                'rationale_content' => 'P = 2(10 + 5) = 2(15) = 30. In two-part analysis questions, both parts must be correct. First, identify the correct formula (perimeter of rectangle = 2(length + width)), then calculate. Both selections are scored together.',
            ],
            [
                'text' => "GMAT® {$topic} question: Based on the table below, which statement is definitely true? (Table shows: Product X: 2023=$50K, 2024=$55K; Product Y: 2023=$80K, 2024=$75K)",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Product X will outsell Product Y in 2025.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Product X increased while Product Y decreased from 2023 to 2024.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Product Y is more popular than Product X.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Both products will continue their trends.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Table Analysis',
                'rationale_content' => 'Only option B states what is directly observable from the data. Product X went from $50K to $55K (increase), Product Y went from $80K to $75K (decrease). On the GMAT, always choose statements that are directly supported by the data, not predictions or assumptions.',
            ],
        ];
    }

    private function getWritingQuestions(string $topic): array
    {
        return [
            [
                'text' => "GMAT® {$topic} question: What is the most important element of a strong argumentative essay?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Using complex vocabulary and long sentences.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'A clear thesis statement supported by logical evidence.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Including as many examples as possible.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Writing in the first person throughout.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Essay Structure Fundamentals',
                'rationale_content' => 'A clear thesis statement is the foundation of any strong argumentative essay. It tells the reader exactly what you will argue, and every paragraph should support it. While vocabulary and examples matter, they are secondary to a well-defined thesis. The GMAT rewards clear, logical structure over stylistic complexity.',
            ],
            [
                'text' => "GMAT® {$topic} question: Which of the following is the best way to address a counterargument in an essay?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Ignore it completely to strengthen your position.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Acknowledge it, then refute it with evidence.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Agree with it to show you are fair-minded.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Mention it briefly in the conclusion.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Counterargument Strategy',
                'rationale_content' => 'The strongest essays acknowledge opposing views and then refute them with evidence. This demonstrates critical thinking and strengthens your position by showing you\'ve considered multiple perspectives. Ignoring counterarguments makes your essay appear one-sided and weak.',
            ],
            [
                'text' => "GMAT® {$topic} question: In the introduction paragraph of an analytical essay, what should come last?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'A hook to grab the reader\'s attention.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Background information on the topic.', 'is_correct' => false],
                    ['letter' => 'C', 'text' => 'The thesis statement.', 'is_correct' => true],
                    ['letter' => 'D', 'text' => 'A summary of the conclusion.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Introduction Structure',
                'rationale_content' => 'The standard introduction structure is: Hook → Background → Thesis. The thesis statement should come last in the introduction as it serves as the transition to the body paragraphs. This structure guides the reader from general interest to your specific argument.',
            ],
            [
                'text' => "GMAT® {$topic} question: What is the primary purpose of the body paragraphs in an analytical essay?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'To introduce new topics not mentioned in the thesis.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'To provide evidence and analysis that supports the thesis.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'To repeat the thesis in different words.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'To list all possible counterarguments.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Body Paragraph Function',
                'rationale_content' => 'Each body paragraph should present one main idea that supports the thesis, followed by evidence and analysis. The structure is typically: Topic sentence → Evidence → Analysis → Transition. This ensures every paragraph directly contributes to proving your argument.',
            ],
            [
                'text' => "GMAT® {$topic} question: Which transition word best shows contrast between two ideas?",
                'choices' => [
                    ['letter' => 'A', 'text' => 'Furthermore', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'However', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Therefore', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Similarly', 'is_correct' => false],
                ],
                'rationale_heading' => 'Transition Words',
                'rationale_content' => '"However" is the standard transition word for contrast. "Furthermore" adds information, "therefore" shows cause/effect, and "similarly" shows comparison. Using appropriate transition words is crucial for essay coherence and is specifically scored on the GMAT Analytical Writing Assessment.',
            ],
        ];
    }

    private function getGenericQuestions(): array
    {
        return [
            [
                'text' => 'GMAT® practice question: Which of the following is the correct answer?',
                'choices' => [
                    ['letter' => 'A', 'text' => 'Option A', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Option B', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Option C', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Option D', 'is_correct' => false],
                ],
                'rationale_heading' => 'Answer Explanation',
                'rationale_content' => 'Option B is correct because it is the most logically sound answer. This question tests your ability to evaluate options critically, a key skill on the GMAT.',
            ],
            [
                'text' => 'GMAT® practice question: Based on the information provided, which conclusion is most reasonable?',
                'choices' => [
                    ['letter' => 'A', 'text' => 'The first option is definitely true.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'The second option is most supported by the data.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'All options are equally valid.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'No conclusion can be drawn.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Logical Reasoning',
                'rationale_content' => 'The second option is most supported by the available evidence. On the GMAT, always choose the answer that is most directly supported by the information given, rather than making assumptions beyond what is stated.',
            ],
            [
                'text' => 'GMAT® practice question: What is the next step in solving this problem?',
                'choices' => [
                    ['letter' => 'A', 'text' => 'Skip to the final answer.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Identify the relevant formula or concept.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Guess randomly.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Re-read the question from the beginning.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Problem-Solving Strategy',
                'rationale_content' => 'The first step in any GMAT problem is to identify what concept or formula applies. This ensures you approach the problem systematically rather than randomly. Always start by understanding what the question is asking.',
            ],
            [
                'text' => 'GMAT® practice question: Which approach is most efficient for this type of question?',
                'choices' => [
                    ['letter' => 'A', 'text' => 'Try all possible answers.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Use elimination and logical deduction.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Spend maximum time on each option.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Choose the longest answer.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Test-Taking Strategy',
                'rationale_content' => 'Elimination and logical deduction are the most efficient approaches on the GMAT. By eliminating clearly wrong answers first, you increase your odds significantly. Time management is critical on the GMAT, so efficient strategies are essential.',
            ],
            [
                'text' => 'GMAT® practice question: What should you do if you encounter a question you\'re unsure about?',
                'choices' => [
                    ['letter' => 'A', 'text' => 'Leave it blank.', 'is_correct' => false],
                    ['letter' => 'B', 'text' => 'Use the process of elimination and make an educated guess.', 'is_correct' => true],
                    ['letter' => 'C', 'text' => 'Spend all remaining time on it.', 'is_correct' => false],
                    ['letter' => 'D', 'text' => 'Ask the test administrator for help.', 'is_correct' => false],
                ],
                'rationale_heading' => 'Handling Difficult Questions',
                'rationale_content' => 'On the GMAT, there is no penalty for wrong answers, so always make an educated guess. Eliminate obviously wrong choices first, then select from the remaining options. Never leave a question blank, and don\'t spend excessive time on any single question.',
            ],
        ];
    }
}