<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Task extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title', 
        'description', 
        'priority', 
        'status', 
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'date', // This converts due_date to Carbon instance
    ];

    public $sortable = [
        'id',
        'title',
        'priority',
        'status',
        'due_date',
        'created_at',
        'updated_at'
    ];
}