<?php

namespace App\Models\Traits;

trait Paginationable
{
    public function scopePagination($query, $page, $count)
    {
        $page = $page ?? 1;
        $count = $count ?? 10;

        if ($count == -1) {
            return $query->get();
        } else {
            return $query->paginate($count, ['*'], 'page', $page)
                ->appends(['count' => $count])
                ->withQueryString();
        }
    }
}
