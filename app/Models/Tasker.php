<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTasker
 */
class Tasker extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'company_name',
        'tax_code'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
