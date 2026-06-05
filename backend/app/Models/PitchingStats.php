<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="PitchingStats",
 *     title="PitchingStats",
 *     description="Pitching statistics model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="player_id", type="integer"),
 *     @OA\Property(property="match_id", type="integer"),
 *     @OA\Property(property="entradas_lanzadas", type="number", format="float"),
 *     @OA\Property(property="hits_permitidos", type="integer"),
 *     @OA\Property(property="carreras_limpias", type="integer"),
 *     @OA\Property(property="boletos", type="integer"),
 *     @OA\Property(property="ponches", type="integer"),
 *     @OA\Property(property="victoria", type="boolean"),
 *     @OA\Property(property="derrota", type="boolean"),
 *     @OA\Property(property="salvamento", type="boolean"),
 *     @OA\Property(property="era", type="number", format="float"),
 *     @OA\Property(property="whip", type="number", format="float"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class PitchingStats extends Model
{
    use HasFactory;

    protected $table = 'pitching_stats';

    protected $fillable = [
        'player_id',
        'match_id',
        'entradas_lanzadas',
        'hits_permitidos',
        'carreras_limpias',
        'boletos',
        'ponches',
        'victoria',
        'derrota',
        'salvamento',
    ];

    protected $casts = [
        'victoria' => 'boolean',
        'derrota' => 'boolean',
        'salvamento' => 'boolean',
    ];

    protected $appends = ['era', 'whip'];

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
     * Calcular ERA (Earned Run Average)
     * ERA = (Carreras Limpias * 9) / Entradas Lanzadas
     */
    public function getEraAttribute()
    {
        if ($this->entradas_lanzadas == 0) return 0;
        return round(($this->carreras_limpias * 9) / $this->entradas_lanzadas, 2);
    }

    /**
     * Calcular WHIP (Walks + Hits per Innings Pitched)
     * WHIP = (Boletos + Hits Permitidos) / Entradas Lanzadas
     */
    public function getWhipAttribute()
    {
        if ($this->entradas_lanzadas == 0) return 0;
        return round(($this->boletos + $this->hits_permitidos) / $this->entradas_lanzadas, 2);
    }
}
