<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextColor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'class'];

    public function headers()
    {
        return $this->hasMany(Header::class);
    }

    public function navbars()
    {
        return $this->hasMany(Navbar::class);
    }

    public function firstSections()
    {
        return $this->hasMany(FirstSection::class);
    }

    public function secondSections()
    {
        return $this->hasMany(SecondSection::class);
    }
}
