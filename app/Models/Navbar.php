<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
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

    public function navbarBrand()
    {
        return $this->hasOne(NavbarBrand::class);
    }

    public function navbarLinks()
    {
        return $this->hasMany(NavbarLink::class);
    }
}
