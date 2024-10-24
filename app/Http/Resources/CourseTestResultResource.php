<?php

namespace App\Http\Resources;

use App\Models\ModuleQuestion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseTestResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $questions = explode(',', $this->module_question_id);
        $userAnswers = explode(',', $this->answer);

        $transformedQuestions = $this->transformQuestions($questions, $userAnswers);
        $totalCorrect = collect($transformedQuestions)->where('correct', true)->count();
        $totalFault = collect($transformedQuestions)->where('correct', false)->count();

        return [
            'id' => $this->id,
            'score' => $this->score,
            'total_fault' => $totalFault,
            'total_correct' => $totalCorrect,
            'total_question' => $totalFault + $totalCorrect,
            'questions' => $transformedQuestions,
            'course_slug' => $this->courseTest->course->slug,
        ];
    }

    /**
     * Method to transform questions and append user answers
     */
    private function transformQuestions(array $questionIds, array $userAnswers): array
    {
        // $questions = ModuleQuestion::query()->whereIn('id', $questionIds)->get();

        $questions = ModuleQuestion::query()
            // ->where('module_id', $quiz->module_id)
            ->whereIn('id', $questionIds)
            ->get()
            ->sortBy(callback: fn($question) => array_search($question->id, $questionIds))
            ->values();
        return $questions->map(function ($question, $key) use ($userAnswers) {
            $userAnswer = $userAnswers[$key] ?? null;
            $correct = $userAnswer == $question->answer;

            return [
                'question' => $question->question,
                'option_a' => $question->option_a,
                'option_b' => $question->option_b,
                'option_c' => $question->option_c,
                'option_d' => $question->option_d,
                'option_e' => $question->option_e,
                'correct_answer' => $question->answer,
                'user_answer' => $userAnswer,
                'correct' => $correct,
            ];
        })->toArray();
    }
}
