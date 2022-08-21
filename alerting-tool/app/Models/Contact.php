<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = ['phone', 'name', 'type'];

    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function groups()
    {
        return $this->belongsToMany('App\Models\Group', 'contacts_groups');
    }
}
