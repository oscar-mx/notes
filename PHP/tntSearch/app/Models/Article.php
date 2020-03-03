<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;
    
    public function toSearchableArray()
    {
        return $this->only('id', 'title', 'content');
    }
}
