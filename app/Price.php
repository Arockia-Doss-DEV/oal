<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Price extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'latest_price', 'dealing_date', 'quarterly_return', 'ytd_return', 'active', 'class_type'
    ];

    public function InvestmentClassAs(){
        return $this->belongsTo('App\InvestmentClass', 'class_type');
    }
}