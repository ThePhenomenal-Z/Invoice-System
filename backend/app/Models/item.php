<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;
    protected $fillable=[
        "name","price"
    ];
    public function invoice_items(){
        return $this->belongsToMany(invoice_item::class);
    }
}
