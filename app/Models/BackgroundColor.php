<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundColor extends Model
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

    public function secondSections()
    {
        return $this->hasMany(SecondSection::class);
    }

    public function thirdSections()
    {
        return $this->hasMany(ThirdSection::class);
    }
}
