<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{
    use HasFactory;

    /**
    * table name in database
    *
    * @var string
    */
    protected $table = 'books';
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'price',
        'active',
        'role',
    ];
}
