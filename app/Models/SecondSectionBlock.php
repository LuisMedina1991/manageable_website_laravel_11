<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondSectionBlock extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'text', 'second_section_id'];

    public function secondSection()
    {
        return $this->belongsTo(SecondSection::class);
    }

    // accessor to transform the "image" attribute value
    public function getImageAttribute($image)
    {

        if (file_exists($image)) {    // it checks if the file physically exists

            return $image;  // in this case the accessor will return the full path of the file

        } else {    // otherwise we understand that the file does not physically exist or that it could not be found

            return null;    // so the accessor will return null

        }
    }
}
