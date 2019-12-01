<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filter
{
    protected $request;
    protected $builder;
    protected $filters = [];

    /**
     * ThreadFilter constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getRequestFilters() as $filter => $value) {
            $funcName = 'By' . ucfirst($filter);
            if (method_exists($this, $funcName)) {
                $this->$funcName($value);
            }
        }

        return $builder;
    }

    public function getRequestFilters()
    {
        return $this->request->only($this->filters);
    }
}
