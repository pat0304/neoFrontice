<?php

namespace App\Models;

use App\Traits\Historiable;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPayment
 */
class Payment extends Model
{
    use Historiable;
    protected $fillable = ['user_id', 'amount', 'currency', 'status', 'payment_method', 'transaction_id', 'metadata'];
    protected $casts = [
        'amount' => 'float',
        'metadata' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
