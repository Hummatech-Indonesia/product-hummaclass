<?php

namespace App\Observers;

use App\Models\Reward;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;


class RewardObserver
{
    /**
     * Method creating
     *
     * @param Reward $reward [explicite description]
     *
     * @return void
     */
    public function creating(Reward $reward)
    {
        $reward->id = Uuid::uuid();
        $reward->slug = Str::slug($reward->name);
    }
    /**
     * Method updating
     *
     * @param Reward $reward [explicite description]
     *
     * @return void
     */
    public function updating(Reward $reward)
    {
        $reward->slug = Str::slug($reward->name);
    }
}
