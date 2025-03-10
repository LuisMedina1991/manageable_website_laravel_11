<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarLink extends Model
{
    use HasFactory;

    protected $fillable = ['href', 'text', 'navbar_id'];

    public function navbar()
    {
        return $this->belongsTo(Navbar::class);
    }
}
