<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentClass extends Model
{
    protected $table = 'investment_classes';
    
    protected $fillable = [
        'name', 'company_name', 'setdefault', 'active', 'total_limit', 'occupied', 'balance', 'supplementary'
    ];
}
