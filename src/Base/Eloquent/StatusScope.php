<?php

namespace Garavel\Eloquent;

use Illuminate\Database\Eloquent\Builder;

trait  StatusScope {

    /**
     * Scope a query to only include popular users.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeStatus($query, int $status): Builder
    {
        return $query->where('status', '=', $status);

    }

}
