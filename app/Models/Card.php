<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'title',
        'sort'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
