<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public const PENDING = 0;
    public const FOR_PANELIST_APPROVAL = 1;
    public const APPROVED = 2;
    public const DECLINED = 3;

    public const STATUS = [
        0 => 'Pending',
        1 => 'For Panelist Approval',
        2 => 'Approved',
        3 => 'Declined'
    ];

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

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
