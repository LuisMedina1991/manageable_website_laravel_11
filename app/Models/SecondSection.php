<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondSection extends Model
{
    use HasFactory;

    protected $fillable = ['identifier', 'name', 'is_selected', 'background_color_id', 'text_color_id'];

    public function backgroundColor()
    {
        return $this->belongsTo(BackgroundColor::class);
    }

    public function textColor()
    {
        return $this->belongsTo(TextColor::class);
    }

    public function secondSectionBlocks()
    {
        return $this->hasMany(SecondSectionBlock::class);
    }
}
