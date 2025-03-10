<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'icon', 'is_selected', 'position'];
}
