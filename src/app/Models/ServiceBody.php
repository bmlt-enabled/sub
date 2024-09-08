<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBody extends Model
{
    use HasFactory;

    protected $fillable = ['keyword'];

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

    public function getKeywordAttribute($value)
    {
        // Use default keyword if none is set
        return $value ?? config('sms.default_keyword', 'join');
    }
}
