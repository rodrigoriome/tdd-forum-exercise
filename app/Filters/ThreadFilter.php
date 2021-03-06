<?php

namespace App\Filters;

class ThreadFilter extends Filter
{
    protected $filters = ['userId', 'popular'];

    public function userId($id)
    {
        return $this->builder->where('user_id', $id);
    }

    public function popular()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
