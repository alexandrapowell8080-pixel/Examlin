<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CSVSeeder extends Seeder
{
    protected $directoryPath;
    
    protected $classificationCache = [];
    protected $categoryCache = [];
    protected $examCache = [];
    protected $examNameCache = [];
    
    protected $questionsBatch = [];
    protected $batchSize = 2500; // Increased for faster bulk inserts

    public function __construct()
    {
      
        $this->directoryPath = database_path('seeders/Data');
    }

    public function run(): void
    {
        $csvFiles = glob($this->directoryPath . '/*.csv');

        if (empty($csvFiles)) {
            $this->command->error("No CSV files found in: {$this->directoryPath}");
            return;
        }

        $this->command->info("Starting highly efficient CSV import for " . count($csvFiles) . " file(s).");
        
        DB::disableQueryLog(); 
        DB::beginTransaction();
        
        try {
            foreach ($csvFiles as $filePath) {
                $this->processFile($filePath);
            }
         
            $this->insertQuestionsBatch();
            
            DB::commit();
            
            $this->command->info("✓ Import complete for all files.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Import failed entirely: " . $e->getMessage());
            throw $e;
        }
    }

    protected function processFile(string $filePath): void
    {
        $this->command->info("Processing: " . basename($filePath));
        $handle = fopen($filePath, 'r');
        
        $headers = fgetcsv($handle);
        if (!$headers) {
            throw new \Exception("Failed to read CSV headers in " . basename($filePath));
        }
        
        $headers[0] = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $headers[0]);
        $headers = array_map('trim', $headers);
        
        $rowCount = 0;
        $importedCount = 0;
        $skippedCount = 0;
        
        while (($row = fgetcsv($handle)) !== false) {
            $rowCount++;
            
            if (empty(array_filter($row))) {
                continue; 
            }

            if (count($headers) !== count($row)) {
                $row = array_pad($row, count($headers), null);
            }

            $cleanRow = array_map(function ($value) {
                $value = trim((string) $value);
                if ($value === '') {
                    return null;
                }
                
                // Speed Optimization: Bypass heavy detection if already valid UTF-8
                if (mb_check_encoding($value, 'UTF-8')) {
                    return $value;
                }
                
                $encoding = mb_detect_encoding($value, 'UTF-8, ISO-8859-1, Windows-1252', true) ?: 'UTF-8';
                return mb_convert_encoding($value, 'UTF-8', $encoding);
            }, $row);

            $data = array_combine($headers, $cleanRow);
            
            try {
                if ($this->processRow($data)) {
                    $importedCount++;
                } else {
                    $skippedCount++;
                }
            } catch (\Exception $e) {
                $skippedCount++;
                $this->command->warn("Row {$rowCount} skipped in " . basename($filePath) . ": " . $e->getMessage());
            }
            
            if ($rowCount % 1000 === 0) {
                $this->command->info("Processed {$rowCount} rows from " . basename($filePath) . "...");
            }
        }
        
        fclose($handle);
        $this->command->info("✓ Finished file: " . basename($filePath) . " ({$importedCount} queued, {$skippedCount} skipped from {$rowCount} total rows).");
    }

    protected function processRow(array $data): bool
    {
        if (empty($data['Question Text'])) {
            return false;
        }

        $classificationName = $data['classification'] ?? '';
        $categoryName       = $data['category'] ?? '';
        $examName           = $data['Exams'] ?? '';
        $examNameName       = $data['Exam Name'] ?? '';
        
        if (empty($classificationName) || empty($categoryName) || empty($examName) || empty($examNameName)) {
            return false;
        }

        $classificationId = $this->getOrCreateClassification($classificationName);
        $categoryId       = $this->getOrCreateCategory($classificationId, $categoryName);
        $examId           = $this->getOrCreateExam($categoryId, $examName);
        $examNameId       = $this->getOrCreateExamName($examId, $examNameName);

        $this->queueQuestion($examNameId, $data);
        
        return true;
    }

    protected function getOrCreateClassification(string $name): int
    {
        $slug = Str::slug($name);
        
        if (isset($this->classificationCache[$slug])) {
            return $this->classificationCache[$slug];
        }

        $record = DB::table('classifications')->where('slug', $slug)->first();

        if ($record) {
            $this->classificationCache[$slug] = $record->id;
            return $record->id;
        }

        $id = DB::table('classifications')->insertGetId([
            'name'       => $name,
            'slug'       => $slug,
            'created_at' => now(),
        ]);

        $this->classificationCache[$slug] = $id;
        return $id;
    }

    protected function getOrCreateCategory(int $classificationId, string $name): int
    {
        $slug = Str::slug($name);
        $cacheKey = "{$classificationId}:{$slug}";
        
        if (isset($this->categoryCache[$cacheKey])) {
            return $this->categoryCache[$cacheKey];
        }

        $record = DB::table('categories')->where('slug', $slug)->first();

        if ($record) {
            $this->categoryCache[$cacheKey] = $record->id;
            return $record->id;
        }

        $id = DB::table('categories')->insertGetId([
            'classification_id' => $classificationId,
            'name'              => $name,
            'slug'              => $slug,
            'created_at'        => now(),
        ]);

        $this->categoryCache[$cacheKey] = $id;
        return $id;
    }

    protected function getOrCreateExam(int $categoryId, string $name): int
    {
        $slug = Str::slug($name);
        $cacheKey = "{$categoryId}:{$slug}";
        
        if (isset($this->examCache[$cacheKey])) {
            return $this->examCache[$cacheKey];
        }

        $record = DB::table('exams')->where('slug', $slug)->first();

        if ($record) {
            $this->examCache[$cacheKey] = $record->id;
            return $record->id;
        }

        $id = DB::table('exams')->insertGetId([
            'category_id' => $categoryId,
            'name'        => $name,
            'slug'        => $slug,
            'created_at'  => now(),
        ]);

        $this->examCache[$cacheKey] = $id;
        return $id;
    }

    protected function getOrCreateExamName(int $examId, string $name): int
    {
        $slug = Str::slug($name);
        $cacheKey = "{$examId}:{$slug}";
        
        if (isset($this->examNameCache[$cacheKey])) {
            return $this->examNameCache[$cacheKey];
        }

        $record = DB::table('exam_names')->where('slug', $slug)->first();

        if ($record) {
            $this->examNameCache[$cacheKey] = $record->id;
            return $record->id;
        }

        $id = DB::table('exam_names')->insertGetId([
            'exam_id'    => $examId,
            'name'       => $name,
            'slug'       => $slug,
            'created_at' => now(),
        ]);

        $this->examNameCache[$cacheKey] = $id;
        return $id;
    }

    protected function queueQuestion(int $examNameId, array $data): void
    {
        $baseText = substr($data['Question Text'] ?? 'question', 0, 50);
        $cleanSlug = Str::slug($baseText);
        $uniqueSlug = $cleanSlug . '-' . uniqid();
        
        $this->questionsBatch[] = [
            'exam_name_id'  => $examNameId,
            'extract'       => $data['Extract Text'] ?? null,
            'question'      => $data['Question Text'],
            'slug'          => $uniqueSlug,
            'choiceA'       => $data['Choice A'] ?? null,
            'choiceB'       => $data['Choice B'] ?? null,
            'choiceC'       => $data['Choice C'] ?? null,
            'choiceD'       => $data['Choice D'] ?? null,
            'choiceE'       => $data['Choice E'] ?? null,
            'choiceF'       => $data['Choice F'] ?? null,
            'choiceG'       => $data['Choice G'] ?? null,
            'correctAnswer' => $data['Correct Answer'] ?? '',
            'rationale'     => $data['Rationale'] ?? null,
            'image'         => $data['Image URL'] ?? null,
            'qtype'         => $data['Question Type'] ?? 'Regular',
            'heading'       => $data['Heading'] ?? null,
            'resource_url'  => '/questions/' . $cleanSlug,
            'added_by'      => 'admin',
            'date_added'    => now(),
        ];

        if (count($this->questionsBatch) >= $this->batchSize) {
            $this->insertQuestionsBatch();
        }
    }

    protected function insertQuestionsBatch(): void
    {
        if (count($this->questionsBatch) > 0) {
            DB::table('questions')->insert($this->questionsBatch);
            $this->questionsBatch = []; 
        }
    }
}