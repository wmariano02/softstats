<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="BattingStats",
 *     title="BattingStats",
 *     description="Batting statistics model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="player_id", type="integer"),
 *     @OA\Property(property="match_id", type="integer"),
 *     @OA\Property(property="turnos_bate", type="integer"),
 *     @OA\Property(property="hits", type="integer"),
 *     @OA\Property(property="dobles", type="integer"),
 *     @OA\Property(property="triples", type="integer"),
 *     @OA\Property(property="jonrones", type="integer"),
 *     @OA\Property(property="carreras", type="integer"),
 *     @OA\Property(property="impulsadas", type="integer"),
 *     @OA\Property(property="boletos", type="integer"),
 *     @OA\Property(property="ponches", type="integer"),
 *     @OA\Property(property="avg", type="number", format="float"),
 *     @OA\Property(property="obp", type="number", format="float"),
 *     @OA\Property(property="slg", type="number", format="float"),
 *     @OA\Property(property="ops", type="number", format="float"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class BattingStats extends Model
{
    use HasFactory;

    protected $table = 'batting_stats';

    protected $fillable = [
        'player_id',
        'match_id',
        'turnos_bate',
        'hits',
        'dobles',
        'triples',
        'jonrones',
        'carreras',
        'impulsadas',
        'boletos',
        'ponches',
    ];

    protected $appends = ['avg', 'obp', 'slg', 'ops'];

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
     * Calcular AVG (Average)
     * AVG = Hits / Turnos al Bate
     */
    public function getAvgAttribute()
    {
        if ($this->turnos_bate == 0) return 0;
        return round($this->hits / $this->turnos_bate, 3);
    }

    /**
     * Calcular OBP (On-Base Percentage)
     * OBP = (Hits + Boletos) / (Turnos al Bate + Boletos)
     */
    public function getObpAttribute()
    {
        $denominator = $this->turnos_bate + $this->boletos;
        if ($denominator == 0) return 0;
        return round(($this->hits + $this->boletos) / $denominator, 3);
    }

    /**
     * Calcular SLG (Slugging Percentage)
     * SLG = (Hits + Dobles + (2*Triples) + (3*Jonrones)) / Turnos al Bate
     */
    public function getSlgAttribute()
    {
        if ($this->turnos_bate == 0) return 0;
        $bases = $this->hits + $this->dobles + (2 * $this->triples) + (3 * $this->jonrones);
        return round($bases / $this->turnos_bate, 3);
    }

    /**
     * Calcular OPS (On-Base Plus Slugging)
     * OPS = OBP + SLG
     */
    public function getOpsAttribute()
    {
        return round($this->obp + $this->slg, 3);
    }

    /**
     * Guardar automáticamente el cálculo de estadísticas
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            // Se calculan automáticamente mediante mutadores
        });
    }
}
