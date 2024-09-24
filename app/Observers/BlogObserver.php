<?php

namespace App\Observers;

use App\Models\Blog;
use Faker\Provider\Uuid;

class BlogObserver
{    
    /**
     * Method creating
     *
     * @param Blog $blog [explicite description]
     *
     * @return void
     */
    public function creating(Blog $blog): void
    {
        $blog->id = Uuid::uuid();
    }
}
