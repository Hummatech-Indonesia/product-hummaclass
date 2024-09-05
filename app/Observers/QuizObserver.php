<?php

namespace App\Observers;

use App\Models\Quiz;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class QuizObserver
{
    /**
     * Method creating
     *
     * @param Quiz $quiz [explicite description]
     *
     * @return void
     */
    public function creating(Quiz $quiz): void
    {
        $quiz->id = Uuid::uuid();
        $quiz->slug = Str::slug($quiz->title);
    }
    /**
     * Method updating
     *
     * @param Quiz $quiz [explicite description]
     *
     * @return void
     */
    public function updating(Quiz $quiz): void
    {
        $quiz->slug = Str::slug($quiz->title);
    }
}
