<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="FieldingStats",
 *     title="FieldingStats",
 *     description="Fielding statistics model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="player_id", type="integer"),
 *     @OA\Property(property="match_id", type="integer"),
 *     @OA\Property(property="asistencias", type="integer"),
 *     @OA\Property(property="putouts", type="integer"),
 *     @OA\Property(property="errores", type="integer"),
 *     @OA\Property(property="dobles_matanzas", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class FieldingStats extends Model
{
    use HasFactory;

    protected $table = 'fielding_stats';

    protected $fillable = [
        'player_id',
        'match_id',
        'asistencias',
        'putouts',
        'errores',
        'dobles_matanzas',
    ];

    /**
     * Relación con jugador
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Relación con partido
     */
    public function match()
    {
        return $this->belongsTo(Match::class);
    }

    /**
     * Obtener total de jugadas defensivas
     */
    public function getTotalPlays()
    {
        return $this->asistencias + $this->putouts;
    }

    /**
     * Obtener porcentaje de efectividad defensiva
     */
    public function getFieldingPercentage()
    {
        $total = $this->getTotalPlays() + $this->errores;
        if ($total == 0) return 0;
        return round(($this->getTotalPlays() / $total) * 100, 2);
    }
}
