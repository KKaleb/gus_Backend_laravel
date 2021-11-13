<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{

    protected $table = "barcodes";

    protected $fillable = ['audition_location', 'barcode_url', 'user_id', 'is_assigned', 'time', 'batch'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

}
