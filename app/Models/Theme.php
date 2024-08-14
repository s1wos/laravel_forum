<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    public function messages()
    {
        return $this->hasMany(Message::class, 'theme_id', 'id');
    }
}
