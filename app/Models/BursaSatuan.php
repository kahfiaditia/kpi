<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BursaSatuan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'bursa_satuans';
    protected $guarded = [];
}
