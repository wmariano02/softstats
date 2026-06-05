<?php

namespace App\Http\Controllers\Api;

use App\Models\Match;
use App\Http\Controllers\Controller;
use App\Http\Resources\MatchResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Matches",
 *     description="API Endpoints for Matches"
 * )
 */
class MatchController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/matches",
     *     summary="Get all matches",
     *     tags={"Matches"},
     *     @OA\Response(
     *         response=200,
     *         description="List of matches"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function index()
    {
        $matches = Match::with(['season', 'rivalTeam', 'battingStats', 'pitchingStats', 'fieldingStats'])->get();
        return MatchResource::collection($matches);
    }

    /**
     * @OA\Post(
     *     path="/api/matches",
     *     summary="Create a new match",
     *     tags={"Matches"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Match data"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Match created successfully"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'season_id' => 'required|exists:seasons,id',
            'rival_team_id' => 'required|exists:teams,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'lugar' => 'required|string|max:255',
            'estado' => 'required|in:programado,en_juego,finalizado',
            'resultado' => 'nullable|in:ganado,perdido,empate',
            'carreras_equipo' => 'nullable|integer|min:0',
            'carreras_rival' => 'nullable|integer|min:0',
        ]);

        $match = Match::create($validated);
        return new MatchResource($match->load(['season', 'rivalTeam', 'battingStats', 'pitchingStats', 'fieldingStats']));
    }

    /**
     * @OA\Get(
     *     path="/api/matches/{id}",
     *     summary="Get a specific match",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Match details"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function show(Match $match)
    {
        return new MatchResource($match->load(['season', 'rivalTeam', 'battingStats', 'pitchingStats', 'fieldingStats']));
    }

    /**
     * @OA\Put(
     *     path="/api/matches/{id}",
     *     summary="Update a match",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated match data"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Match updated successfully"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function update(Request $request, Match $match)
    {
        $validated = $request->validate([
            'season_id' => 'exists:seasons,id',
            'rival_team_id' => 'exists:teams,id',
            'fecha' => 'date',
            'hora' => 'date_format:H:i',
            'lugar' => 'string|max:255',
            'estado' => 'in:programado,en_juego,finalizado',
            'resultado' => 'nullable|in:ganado,perdido,empate',
            'carreras_equipo' => 'nullable|integer|min:0',
            'carreras_rival' => 'nullable|integer|min:0',
        ]);

        $match->update($validated);
        return new MatchResource($match->load(['season', 'rivalTeam', 'battingStats', 'pitchingStats', 'fieldingStats']));
    }

    /**
     * @OA\Delete(
     *     path="/api/matches/{id}",
     *     summary="Delete a match",
     *     tags={"Matches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Match deleted successfully"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function destroy(Match $match)
    {
        $match->delete();
        return response()->noContent();
    }
}
