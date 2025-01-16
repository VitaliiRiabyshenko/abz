<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Position;
use App\Http\Controllers\Controller;
use App\Http\Resources\Position\PositionCollection;

class PositionController extends Controller
{
    public function __invoke()
    {
        return new PositionCollection(Position::all());
    }
}
