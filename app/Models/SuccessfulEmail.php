<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuccessfulEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'successful_emails';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected array $dates = ['deleted_at'];
}
