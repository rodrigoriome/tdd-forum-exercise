<?php

namespace App\Filters;

class ThreadFilter extends Filter
{
    protected $filters = ['userId'];

    public function byUserId($id)
    {
        return $this->builder->where('user_id', $id);
    }
}
