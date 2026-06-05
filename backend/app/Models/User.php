<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="role", type="string", enum={"admin", "anotador", "jugador", "publico"}),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class User extends Model
{
    use HasFactory;

    const ROLE_ADMIN = 'admin';
    const ROLE_ANOTADOR = 'anotador';
    const ROLE_JUGADOR = 'jugador';
    const ROLE_PUBLICO = 'publico';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Verificar si el usuario es anotador
     */
    public function isAnotador(): bool
    {
        return $this->role === self::ROLE_ANOTADOR;
    }

    /**
     * Verificar si el usuario es jugador
     */
    public function isJugador(): bool
    {
        return $this->role === self::ROLE_JUGADOR;
    }

    /**
     * Relación con jugadores (si el usuario es un jugador)
     */
    public function player()
    {
        return $this->hasOne(Player::class);
    }
}
