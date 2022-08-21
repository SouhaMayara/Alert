<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = ['name', 'standby'];

    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function contacts()
    {
        return $this->belongsToMany('App\Models\Contact', 'contacts_groups');
    }
}
