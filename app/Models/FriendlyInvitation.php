<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendlyInvitation extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'friendly_invitations';

    protected $table = self::TABLE_NAME;

    public const TYPE_FRIENDLY = 'friendly';
    public const TYPE_CUP_FRIENDLY = 'cup_friendly';
    public const TYPE_TRAINING = 'training';

    public const STATUS_HOST = 'host';
    public const STATUS_INVITED = 'invited';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_PENDING = 'pending';

    public const TYPES = [
        self::TYPE_FRIENDLY, self::TYPE_CUP_FRIENDLY, self::TYPE_TRAINING, 
    ];

    public const STATUSES = [
        self::STATUS_HOST, self::STATUS_INVITED, self::STATUS_ACCEPTED, self::STATUS_CANCELED, self::STATUS_PENDING
    ];

    protected $fillable = [
        'type',
        'public',
        'host_vanue',
        'status',
        'host_id',
        'host_team_id',
        'opponent_team_id',
        "match_date",
    ];

    protected $casts = [
        'public'     => 'boolean',
        'host_vanue' => 'boolean',
    ];

    protected $attributes = [
        'type'              => self::TYPE_FRIENDLY,
        'public'            => true,
        'host_vanue'        => true,
        'status'            => self::STATUS_HOST,
        'opponent_team_id'  => null,
    ];

    // 'host_uuid'         => auth()->user()->uuid,
    // 'host_team_id'      => auth()->user()->club_id,
    // "match_date"        => $this->pickWednesday()

    public function pickWednesday()
    {
        $today = Carbon::now();  // Get the current date and time
        $wednesday = $today->copy()->startOfWeek()->next(Carbon::WEDNESDAY);  // Get the next Wednesday of the current week

        if ($today->isMonday() || $today->isTuesday()) {
            $date = $wednesday;  // If today is Monday or Tuesday, use the next Wednesday of the current week
        } else {
            $date = $wednesday->addWeek();  // Otherwise, add a week to get the Wednesday of the following week
        }

        // Format the date as desired
        $formattedDate = $date->format('Y-m-d');

        // Output the result
        return $formattedDate;
    }

    public function scopeStatusHost($query)
    {
        $query->where('status', self::STATUS_HOST);
    }

    public function scopeStatusInvited($query)
    {
        $query->where('status', self::STATUS_INVITED);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'host_id', 'id');
    }

    public function hostTeam()
    {
        return $this->belongsTo(Club::class, 'host_team_id', 'id');
    }

    public function opponentTeam()
    {
        return $this->belongsTo(Club::class, 'opponent_team_id', 'id');
    }
}
