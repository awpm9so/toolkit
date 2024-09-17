<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'statement_id',
        'path'
    ];

    /**
     * Связь один ко многим с {@see Statement}
     *
     * @return BelongsToMany
     */
    public function statement(): BelongsTo
    {
        return $this->belongsTo(Statement::class);
    }
}
