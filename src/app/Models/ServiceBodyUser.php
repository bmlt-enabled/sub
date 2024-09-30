<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBodyUser extends Model
{
    use HasFactory;

    protected $table = 'service_body_user';

    protected $fillable = ['service_body_id'];
}
