<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Http\Traits\ApiResponse;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $tickets = Ticket::paginate($perPage);

        return $this->apiResponse(200, __("messages.tickets"), null, [
            'tickets' => TicketResource::collection($tickets),
            'meta' => [
                'current_page' => $tickets->currentPage(),
                'last_page' => $tickets->lastPage(),
                'per_page' => $tickets->perPage(),
                'total' => $tickets->total(),
                'next_page_url' => $tickets->nextPageUrl(),
                'prev_page_url' => $tickets->previousPageUrl(),
            ],
        ]);
    }
}
