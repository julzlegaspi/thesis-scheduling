<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public const PENDING = 0;
    public const FOR_PANELIST_APPROVAL = 1;
    public const APPROVED = 2;
    public const DECLINED = 3;
    public const RE_DEFENSE = 4;

    public const STATUS = [
        0 => 'Pending',
        1 => 'For Panelist Approval',
        2 => 'Approved',
        3 => 'Declined',
        4 => 'Re-Defense'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
