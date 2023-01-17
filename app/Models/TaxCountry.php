<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaxCountry extends Pivot
{
    use HasFactory;
    protected $table = 'tax_country';

}
