<?php

namespace App\Traits;

use App\Models\History;

trait Historiable
{
    public static function bootHistoriable()
    {
        static::created(function ($model) {
            $model->storeHistory('created');
        });

        static::updated(function ($model) {
            $model->storeHistory('updated');
        });

        static::deleted(function ($model) {
            $model->storeHistory('deleted');
        });
    }

    public function histories()
    {
        return $this->morphMany(History::class, 'historiable');
    }

    protected function storeHistory($action)
    {
        if (!auth()->check()) {
            return;
        } else {
            $this->histories()->create([
                'user_id' => auth()->id(),
                'action'  => $action,
                'meta'    => [
                    'old' => $this->getOriginal() ?? null,
                    'new' => $this->getAttributes(),
                ],
            ]);
        }
    }
}
