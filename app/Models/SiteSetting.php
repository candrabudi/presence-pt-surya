<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'company_name',
        'company_logo',
        'address',
        'phone',
        'email',
        'default_check_in',
        'default_check_out',
        'footer_text',
    ];
}
