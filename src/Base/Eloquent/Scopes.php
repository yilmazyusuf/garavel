<?php

namespace Garavel\Eloquent;

use Illuminate\Database\Eloquent\Builder;
trait  Scopes {

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @param int     $status
     *
     * @return Builder
     */
    public function scopeStatus($query, int $status): Builder
    {
        return $query->where('status', '=', $status);

    }

}
