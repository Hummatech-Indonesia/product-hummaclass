<?php

namespace App\Observers;

use App\Models\Blog;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

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
        $blog->slug = Str::slug($blog->title);
    }
    public function updating(Blog $blog): void
    {
        $blog->slug = Str::slug($blog->title);
    }
}
