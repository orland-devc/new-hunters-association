<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hunter extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural of the model name
    protected $table = 'hunters';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'rank',
        'level',
    ];

    // Optional: Define the possible ranks to maintain consistency
    public const RANKS = ['A', 'B', 'C', 'D', 'E'];

    // Optional: Cast rank to an enum (if using PHP 8.1+)
    // protected $casts = [
    //     'rank' => RankEnum::class,
    // ];
}
