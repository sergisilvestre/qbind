<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatNumber extends Model
{
    use HasFactory;

    protected $fillable = ['vat_number'];
}
