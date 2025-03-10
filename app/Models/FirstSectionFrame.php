<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstSectionFrame extends Model
{
    use HasFactory;

    protected $fillable = ['subtitle', 'text', 'first_section_id'];

    public function firstSection()
    {
        return $this->belongsTo(FirstSection::class);
    }
}
