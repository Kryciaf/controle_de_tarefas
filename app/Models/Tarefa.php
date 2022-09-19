<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = [
        'task',
        'date_limit'
    ];

    public function user() {
        //estabelece o relacionamento com um user
        return $this->belongsTo('App\Models\User');
    }
}
