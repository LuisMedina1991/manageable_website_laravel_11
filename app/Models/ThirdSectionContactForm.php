<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdSectionContactForm extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'name_label', 'email_label', 'phone_label', 'message_label', 'third_section_id'];

    public function thirdSection()
    {
        return $this->belongsTo(ThirdSection::class);
    }
}
