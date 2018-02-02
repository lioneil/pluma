<?php

namespace Course\Support\Relations;

use Course\Models\Course;

trait BelongsToCourse
{
    /**
     * Get the course that owns the resource.
     *
     * @return  \Illuminate\Database\Eloquent\Model
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
