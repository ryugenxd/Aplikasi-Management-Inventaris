<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsOut extends Model
{
    use HasFactory;
    protected $table = "goods_out";
    protected $fillable = [
        'item_id',
        'user_id',
        'quantity',
        'invoice_number',
        'date_out',
        'customer_id'
    ];

    public function item(): BelongsTo
    {
        return $this -> belongsTo(Item::class);
    }

    public function user(): BelongsTo
    {
        return $this -> belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this -> belongsTo(Customer::class);
    }

}
