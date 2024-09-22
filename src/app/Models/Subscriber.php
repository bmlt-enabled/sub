<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['phone_number', 'feed_id'];

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }
}
