<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Task extends Model
{
    use HasFactory, Sortable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'due_date' => 'date',
    ];

    /**
     * Columns that can be sorted.
     */
    public $sortable = [
        'id',
        'title',
        'priority',
        'status',
        'due_date',
        'created_at',
        'updated_at',
    ];
}