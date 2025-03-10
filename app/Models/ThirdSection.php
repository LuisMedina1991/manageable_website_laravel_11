<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdSection extends Model
{
    use HasFactory;

    protected $fillable = ['identifier', 'name', 'is_selected', 'background_color_id'];

    public function backgroundColor()
    {
        return $this->belongsTo(BackgroundColor::class);
    }

    public function thirdSectionContactForm()
    {
        return $this->hasOne(ThirdSectionContactForm::class);
    }
}
