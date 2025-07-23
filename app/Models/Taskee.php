<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Taskee extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'bio'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
