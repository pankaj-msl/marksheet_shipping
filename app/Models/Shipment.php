<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'id', 
        'student_id', 
        'tracking_id', 
        'shipping_agent', 
        'shipping_address', 
        'dispatched_at', 
        'amount', 
        'delivery_status', 
        'delivered_at', 
        'created_at', 
        'updated_at'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }
}
