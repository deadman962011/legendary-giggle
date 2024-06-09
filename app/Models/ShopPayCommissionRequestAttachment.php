<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopPayCommissionRequestAttachment extends Model
{
    use HasFactory;


    protected $fillable=['upload_id','request_id'];

/**
 * Get the upload associated with the ShopPayCommissionRequestAttachment
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */
public function upload()
{
    return $this->hasOne(Upload::class, 'id', 'upload_id');
}




}
