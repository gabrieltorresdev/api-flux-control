<?php

namespace App\Http\Controllers;

use App\Core\Application\Dashboard\Action\GetInsightsAction;
use App\Core\Application\Dashboard\DTO\GetInsights\InGetInsights;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getInsights(Request $request, GetInsightsAction $action): JsonResponse
    {
        $startDate = $request->get('start_date') ? Carbon::parse($request->get('start_date')) : null;
        $endDate = $request->get('end_date') ? Carbon::parse($request->get('end_date')) : null;

        $result = $action->execute(InGetInsights::from([
            'userId' => Auth::id(),
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]));

        return $this->ok('Insights retrieved successfully!', $result);
    }
} 