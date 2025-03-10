<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstSection extends Model
{
    use HasFactory;

    protected $fillable = ['identifier', 'name', 'title', 'is_selected', 'text_color_id'];

    public function textColor()
    {
        return $this->belongsTo(TextColor::class);
    }

    public function firstSectionFrames()
    {
        return $this->hasMany(FirstSectionFrame::class);
    }
}
