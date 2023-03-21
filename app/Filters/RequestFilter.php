<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class RequestFilter extends QueryFilter
{
    public function q($q): Builder
    {
        return $this->builder->where('name', 'like', '%' . $q . '%');
    }

    public function query($query
    ): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array|null {
        return $this->builder->find($query);
    }
}
