<?php

namespace App\Services;

class AssesmentFormService
{
    public function totalAssesment(object $attitudes, object $skills)
    {
        $countIndicator = $attitudes->count() + $skills->count();
        $number = 100 / $countIndicator / 5;
        $attitudeGrade = 0;
        $skillGrade = 0;
        foreach ($attitudes as $attitude) {
            $attitudeGrade += $attitude->value;
        }
        foreach ($skills as $skill) {
            $skillGrade += $skill->value;
        }

        $totalAssesment = ($attitudeGrade + $skillGrade)*$number;
        return $totalAssesment;
    }
}
