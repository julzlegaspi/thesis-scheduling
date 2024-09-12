<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rsc extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public const MANUSCRIPT = 0;
    public const SYSTEM = 1;

    public const TYPE = [
        0 => 'Manuscript',
        1 => 'System',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CommentRsc::class);
    }
}
