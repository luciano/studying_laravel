<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // to change the fields and table name but not needed
    // it's just need to specify here the new name
    // table name
    protected $table = 'posts';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user() {
        // a sigle post belongs to an user
        return $this->belongsTo('App\User');
    }
}
