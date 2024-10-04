<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_body_id',
        'name',
        'subscribe_keyword',
        'unsubscribe_keyword',
    ];

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
