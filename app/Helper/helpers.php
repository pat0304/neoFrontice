<?php

use App\Models\History;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('add_history')) {
    function add_history($user_id, Model $model, $action)
    {
        $history = new History();
        $history->create([
            'user_id' => $user_id,
            'history_type' => $model->getTable(),
            'history_id' => $model->id,
            'action' => $action,
        ]);
    }
}
