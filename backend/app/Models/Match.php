<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Match",
 *     title="Match",
 *     description="Match model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="season_id", type="integer"),
 *     @OA\Property(property="rival_team_id", type="integer"),
 *     @OA\Property(property="fecha", type="string", format="date"),
 *     @OA\Property(property="hora", type="string", format="time"),
 *     @OA\Property(property="lugar", type="string"),
 *     @OA\Property(property="estado", type="string", enum={"programado", "en_juego", "finalizado"}),
 *     @OA\Property(property="resultado", type="string", enum={"ganado", "perdido", "empate"}, nullable=true),
 *     @OA\Property(property="carreras_equipo", type="integer", nullable=true),
 *     @OA\Property(property="carreras_rival", type="integer", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Match extends Model
{
    use HasFactory;

    const STATUS_SCHEDULED = 'programado';
    const STATUS_IN_PROGRESS = 'en_juego';
    const STATUS_FINISHED = 'finalizado';

    const RESULT_WON = 'ganado';
    const RESULT_LOST = 'perdido';
    const RESULT_DRAW = 'empate';

    protected $fillable = [
        'season_id',
        'rival_team_id',
        'fecha',
        'hora',
        'lugar',
        'estado',
        'resultado',
        'carreras_equipo',
        'carreras_rival',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Relación con temporada
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Relación con equipo rival
     */
    public function rivalTeam()
    {
        return $this->belongsTo(Team::class, 'rival_team_id');
    }

    /**
     * Relación con estadísticas de bateo
     */
    public function battingStats()
    {
        return $this->hasMany(BattingStats::class);
    }

    /**
     * Relación con estadísticas de picheo
     */
    public function pitchingStats()
    {
        return $this->hasMany(PitchingStats::class);
    }

    /**
     * Relación con estadísticas defensivas
     */
    public function fieldingStats()
    {
        return $this->hasMany(FieldingStats::class);
    }

    /**
     * Verificar si el partido está finalizado
     */
    public function isFinished()
    {
        return $this->estado === self::STATUS_FINISHED;
    }

    /**
     * Obtener resultado en texto
     */
    public function getResultText()
    {
        if (!$this->isFinished()) {
            return 'No finalizado';
        }

        return match ($this->resultado) {
            self::RESULT_WON => 'Victoria',
            self::RESULT_LOST => 'Derrota',
            self::RESULT_DRAW => 'Empate',
            default => 'Sin definir',
        };
    }
}
