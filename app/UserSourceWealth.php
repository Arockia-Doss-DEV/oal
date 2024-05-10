<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSourceWealth extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'doc_nos', 'source_list_type'
    ];

    public function UserSourceWealthDocuments(){
        return $this->hasMany('App\UserSourceWealthDocument', 'source_wealth_id');
    }
}
