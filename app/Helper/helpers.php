<?php

use App\Models\History;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('add_history')) {
    function add_history(Model $model, $action)
    {
        $history = new History();
        $old = $model->getOriginal();
        $new = $model->getChanges();
        $meta = [];
        foreach ($new as $key => $value) {
            if (in_array($key, $model->getFillable())) {
                $meta[$key]['old'] = $old[$key] ?? null;
                $meta[$key]['new'] = $value;
            }
        }
        $history->create([
            'user_id' => auth()->guard()->id(),
            'history_type' => $model->getTable(),
            'history_id' => $model->id,
            'action' => $action,
            'meta' => $meta
        ]);
    }
}
if (!function_exists('add_notification')) {
    function add_notification(Model $modelTrigger, $title, $body)
    {
        $notification = new \App\Models\Notification();
        $notification->create([
            'user_id' => auth()->guard()->id(),
            'title' => $title,
            'body' => $body,
            'trigger_type' => $modelTrigger->getTable(),
            'trigger_id' => $modelTrigger->id,
        ]);
    }
}
