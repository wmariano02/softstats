<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'season_id' => $this->season_id,
            'rival_team_id' => $this->rival_team_id,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'lugar' => $this->lugar,
            'estado' => $this->estado,
            'resultado' => $this->resultado,
            'resultado_texto' => $this->getResultText(),
            'carreras_equipo' => $this->carreras_equipo,
            'carreras_rival' => $this->carreras_rival,
            'rival_team' => new TeamResource($this->whenLoaded('rivalTeam')),
            'season' => new SeasonResource($this->whenLoaded('season')),
            'batting_stats' => BattingStatsResource::collection($this->whenLoaded('battingStats')),
            'pitching_stats' => PitchingStatsResource::collection($this->whenLoaded('pitchingStats')),
            'fielding_stats' => FieldingStatsResource::collection($this->whenLoaded('fieldingStats')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
