<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Team",
 *     title="Team",
 *     description="Rival team model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="nombre", type="string"),
 *     @OA\Property(property="manager", type="string"),
 *     @OA\Property(property="telefono", type="string", nullable=true),
 *     @OA\Property(property="logo", type="string", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'manager',
        'telefono',
        'logo',
    ];

    /**
     * Relación con partidos
     */
    public function matches()
    {
        return $this->hasMany(Match::class, 'rival_team_id');
    }

    /**
     * Obtener cantidad de partidos contra este equipo
     */
    public function getMatchCount()
    {
        return $this->matches()->count();
    }
}
