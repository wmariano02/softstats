<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Season",
 *     title="Season",
 *     description="Season model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="nombre", type="string"),
 *     @OA\Property(property="fecha_inicio", type="string", format="date"),
 *     @OA\Property(property="fecha_fin", type="string", format="date"),
 *     @OA\Property(property="estado", type="string", enum={"activa", "finalizada"}),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Relación con partidos
     */
    public function matches()
    {
        return $this->hasMany(Match::class, 'season_id');
    }

    /**
     * Obtener cantidad de partidos
     */
    public function getMatchCount()
    {
        return $this->matches()->count();
    }

    /**
     * Obtener partidos ganados
     */
    public function getWinsCount()
    {
        return $this->matches()
            ->where('estado', 'finalizado')
            ->where('resultado', 'ganado')
            ->count();
    }

    /**
     * Obtener partidos perdidos
     */
    public function getLossesCount()
    {
        return $this->matches()
            ->where('estado', 'finalizado')
            ->where('resultado', 'perdido')
            ->count();
    }
}
