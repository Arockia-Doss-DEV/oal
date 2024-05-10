<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSourceWealthDocument extends Model
{
    protected $fillable = [
        'source_wealth_id', 'document_name', 'description', 'attr_sub_type'
    ];
}
