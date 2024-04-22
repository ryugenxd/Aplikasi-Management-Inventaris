<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodsIn extends Model
{
    use HasFactory;
    protected $table = "goods_in";
    protected $fillable = [
        'item_id',
        'user_id',
        'quantity',
        'date_received',
        'invoice_number',
        'supplier_id',
    ];

    public function item(): BelongsTo
    {
        return $this -> belongsTo(Item::class);
    }

    public function user(): BelongsTo
    {
        return $this -> belongsTo(User::class);
    }

    public function supplier(): BelongsTo
    {
        return $this -> belongsTo(Supplier::class);
    }
}
