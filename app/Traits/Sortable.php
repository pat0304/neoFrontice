<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait Sortable
{
    public function scopeUsePaginate($query)
    {
        $q = request()->query('q', false);
        if ($q && $this->searchable) {

            if (is_array($this->searchable)) {
                foreach ($this->searchable as $relation => $field) {
                    $query->whereHas($relation, function ($query) use ($field, $q) {
                        $query->where('locale', app()->getLocale())->where($field, 'LIKE', '%' . $q . '%');
                    });
                }
            } elseif (is_string($this->searchable)) {
                $query->where($this->searchable, 'LIKE', '%' . $q . '%');
            }
        }
        $perPage = request()->query('per_page', 10);
        $page = request()->query('page', 1);
        $sortBy = request()->query('sort_by');
        $orderBy = request()->query('order_by', 'asc');
        if (!in_array($orderBy, ['asc', 'desc'])) {
            $orderBy = 'asc';
        }
        if ($sortBy && in_array($sortBy, $this->fillable)) {
            $query->orderBy($sortBy, $orderBy);
        } else {
            $query->orderBy('created_at', $orderBy);
        }

        $total = $query->count();
        $results = $query->skip(($page - 1) * $perPage)->take($perPage)->get();
        $paginator = new LengthAwarePaginator(
            $results,
            $total,
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );
        $paginator->appends(request()->except('page'));
        return $paginator;
    }
    public function scopeUseFilter($query)
    {
        foreach ($this->filterable as $field) {
            $value = request()->query($field, null);
            if (!is_null($value)) {
                $query->where($field, $value);
            }
        }
        return $query->usePaginate();
    }
}
