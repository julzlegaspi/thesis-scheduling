<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'member_team', 'team_id', 'user_id');
    }

    public function panelists(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'panelist_team', 'team_id', 'user_id');
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function manuscripts(): HasMany
    {
        return $this->hasMany(Manuscript::class, 'team_id');
    }

    public function rscs(): HasMany
    {
        return $this->hasMany(Rsc::class, 'team_id');
    }
}
