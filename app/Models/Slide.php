<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    // protected $with=['upload'];
    protected $appends=['image_url'];

    protected $fillable=['upload_id','slider_id'];

    /**
     * Get the upload associated with the Slide
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function upload()
    // {
    //     return $this->hasOne(Upload::class, 'id', 'upload_id');
    // }


    public function getImageUrlAttribute()  {
        return getFileUrl($this->upload_id);
    }


}
