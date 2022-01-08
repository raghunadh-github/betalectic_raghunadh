<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class blog extends Model
{
    use HasFactory;

    //restricts columns from modifying
    protected $guarded = [];
        
    // returns the instance of the user who is author of that post
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
