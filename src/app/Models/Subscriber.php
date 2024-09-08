<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['phone_number', 'service_body_id'];

    public function serviceBody()
    {
        return $this->belongsTo(ServiceBody::class);
    }
}
