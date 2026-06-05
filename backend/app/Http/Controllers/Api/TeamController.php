<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Teams",
 *     description="API Endpoints for Teams"
 * )
 */
class TeamController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/teams",
     *     summary="Get all teams",
     *     tags={"Teams"},
     *     @OA\Response(
     *         response=200,
     *         description="List of teams"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function index()
    {
        $teams = Team::with('matches')->get();
        return TeamResource::collection($teams);
    }

    /**
     * @OA\Post(
     *     path="/api/teams",
     *     summary="Create a new team",
     *     tags={"Teams"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Team data"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Team created successfully"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'manager' => 'required|string|max:255',
            'telefono' => 'nullable|string',
            'logo' => 'nullable|string',
        ]);

        $team = Team::create($validated);
        return new TeamResource($team->load('matches'));
    }

    /**
     * @OA\Get(
     *     path="/api/teams/{id}",
     *     summary="Get a specific team",
     *     tags={"Teams"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Team details"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function show(Team $team)
    {
        return new TeamResource($team->load('matches'));
    }

    /**
     * @OA\Put(
     *     path="/api/teams/{id}",
     *     summary="Update a team",
     *     tags={"Teams"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated team data"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Team updated successfully"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'nombre' => 'string|max:255',
            'manager' => 'string|max:255',
            'telefono' => 'nullable|string',
            'logo' => 'nullable|string',
        ]);

        $team->update($validated);
        return new TeamResource($team->load('matches'));
    }

    /**
     * @OA\Delete(
     *     path="/api/teams/{id}",
     *     summary="Delete a team",
     *     tags={"Teams"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Team deleted successfully"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return response()->noContent();
    }
}
