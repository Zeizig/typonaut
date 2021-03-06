<?php

namespace App;

use App\Events\GameFinished;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Game.
 *
 * @property int id
 * @property int player_one_id
 * @property int player_two_id
 * @property int player_one_score
 * @property int player_two_score
 * @property User playerOne
 * @property User playerTwo
 * @property Collection rounds
 *
 * @package App
 */
class Game extends Model
{
    protected $fillable = [ 'player_one_id', 'player_two_id' ];

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function playerOne()
    {
        return $this->belongsTo(User::class, 'player_one_id', 'id');
    }

    public function playerTwo()
    {
        return $this->belongsTo(User::class, 'player_two_id', 'id');
    }

    public function isCompleted()
    {
        $gameOver = true;
        foreach ($this->rounds as $loopround) {
            if ($loopround->player_one_time === null || $loopround->player_two_time === null) {
                $gameOver = false;
                break;
            }
        }

        return $gameOver;
    }
}
