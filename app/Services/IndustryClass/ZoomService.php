<?php

namespace App\Services\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\ZoomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ZoomRequest;
use Carbon\Carbon;

class ZoomService 
{
    private ZoomInterface $zoom;

    public function __construct(ZoomInterface $zoom)
    {   
        $this->zoom = $zoom;
    }

    private function getDatesByDayInCurrentMonth($dayOfWeek) {

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $dates = collect();
        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            if ($date->isDayOfWeek($dayOfWeek)) {
                $dates->push($date->toDateString());
            }
        }

        return $dates;
    }

    public function store(ZoomRequest $request)
    {
        $data = $request->validated();
        $dateResults = $this->getDatesByDayInCurrentMonth($data['day']);

        
        foreach ($dateResults as $dateResult) {  
            $date_now = Carbon::now()->format('Y-m-d');
            if ($dateResult > $date_now) {

                $condition = $this->zoom->getWhere(['date' => $dateResult . ' ' . $data['time'], 'classroom_id' => $data['classroom_id']]);

                if ($condition) {
                    return ResponseHelper::error(null, 'Zoom sudah tersedia');
                }

                $result = [
                    'title' => $data['title'],
                    'school_id' => $data['school_id'],
                    'classroom_id' => $data['classroom_id'],
                    'user_id' => $data['user_id'],
                    'link' => $data['link'],
                    'date' => $dateResult . ' ' . $data['time'], 
                ];
                $this->zoom->store($result);
            }
        }
    }
}
