<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentMaster extends Model
{
    protected $fillable = [
    'id', 'document_name', 'status', 'document_type', 'created_at', 'updated_at'
    ];
}
