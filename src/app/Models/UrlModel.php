<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlModel extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'domain_id'];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
