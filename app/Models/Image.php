<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function getUrlAttribute()
    {
        return url('storage/' . $this->path);
    }


    public function scopeCleanFromStorage(Builder $builder)
    {
        $builder->where('user_id', auth()->id())
            ->whereNull('message_id')
            ->get()
            ->pluck('path')
            ->each(function ($path) {
                Storage::disk('public')->delete($path);
            });
    }

    public function scopeCleanFromTable(Builder $builder)
    {
        $builder->where('user_id', auth()->id())
            ->whereNull('message_id')->delete();
    }

    public function scopeUpdateMessageId(Builder $builder, $imgIds, $message)
    {
        $builder->whereIn('id', $imgIds)->update([
            'message_id' => $message->id
        ]);
    }
}
