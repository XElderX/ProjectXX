<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchSchedule extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_POSTPONED = 'postponed';
    public const STATUS_FINISHED = 'finished';

    public const TYPE_FRIENDLY = 'friendly';
    public const TYPE_LEAGUE = 'league';
    public const TYPE_CUP = 'cup';
    public const TYPE_INTERNATIONAL = 'international';

    public const MATCH_TYPES = [self::TYPE_FRIENDLY, self::TYPE_LEAGUE, self::TYPE_CUP, self::TYPE_INTERNATIONAL];
    public const MATCH_STATUSES = [self::STATUS_PENDING, self::STATUS_ACCEPTED, self::STATUS_POSTPONED, self::STATUS_FINISHED];

    public const TABLE_NAME = 'match_schedules';

    protected $fillable = [
        'home_team_id', 'away_team_id', 'attendance',
        'weather', 'report', 'home_tactic', 'away_tactic',
        'report', 'home_lineup', 'away_lineup',
        'status', 'complete', 'type', 'match_date', 'time'
    ];

    protected $attributes = [
        'status'   => self::STATUS_PENDING,
        'type'     => self::TYPE_FRIENDLY,
        'complete' => 0,
    ];

    protected $casts = [
        'report' => 'array'
    ];

    public function clubs()
    {
        return $this->hasMany(Club::class);
    }

    public function homeTeam()
    {
        return $this->hasMany(Club::class, 'id', 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->hasMany(Club::class, 'id', 'away_team_id');
    }

    public function fillMatchData($invitation): self
    {
        $homeTeam = $invitation->host_team_id;
        $awayTeam = $invitation->opponent_team_id;

        if (!$invitation->host_vanue) {
            $homeTeam = $invitation->opponent_team_id;
            $awayTeam = $invitation->host_team_id;
        }
        $this->home_team_id = $homeTeam;
        $this->away_team_id = $awayTeam;
        $this->attendance = null;
        $this->weather = null;
        $this->report = null;
        $this->home_tactic = null;
        $this->away_tactic = null;
        $this->report = null;
        $this->home_lineup = null;
        $this->away_lineup = null;
        $this->status = MatchSchedule::STATUS_PENDING;
        $this->complete = false;
        $this->type = $invitation->type;
        $this->match_date = $invitation->match_date;
        // Set the timezone
        $timeZone = Country::findOrFail(Club::findOrFail($homeTeam)->country_id)->timezone; // Replace with your desired timezone, e.g., 'America/New_York'
        // Create a Carbon instance with the desired time and timezone
        $time = $this->setTime($timeZone);
        $this->time = $time;

        return $this;
    }


    private function setTime($time)
    {
        // Set the server timezone
        $serverTimeZone = 'Europe/London'; // Replace with your server's timezone

        // Set the desired timezone
        $desiredTimeZone = $time; // Replace with your desired timezone

        // Create a Carbon instance with the current server time
        $serverTime = Carbon::createFromTime(19, 0, 0, $serverTimeZone);

        // Convert the server time to the desired timezone
        $desiredTime = $serverTime->setTimezone($desiredTimeZone);

        // Extract the desired time components
        $hour = $desiredTime->format('H');
        $minute = $desiredTime->format('i');
        $second = $desiredTime->format('s');

        return "$hour:$minute:$second";
    }

    public function setTactic(string $data, string $subject = 'home'): self
    {
        if ($subject === 'away') {
            $this->away_tactic = $data;
            return $this;
        }
        $this->home_tactic = $data;
        return $this;
    }

    public function setLineup(string $data, string $subject = 'home'): self
    {
        if ($subject === 'away') {
            $this->away_lineup = $data;
            return $this;
        }
        $this->home_lineup = $data;
        return $this;
    }
}
