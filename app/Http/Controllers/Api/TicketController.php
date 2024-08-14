<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tickets\AddTicketRequest;
use App\Http\Requests\Api\Tickets\DeleteTicketRequest;
use App\Http\Requests\Api\Tickets\UpdateTicketRequest;
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

        $tickets = Ticket::select("id", "title", "created_at")->paginate($perPage);

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

    /*----------------------------------------------------------------------------------------------------*/

    public function show($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);

        if (!$ticket) {
            return $this->apiResponse(404, __('messages.ticket_not_founded'));
        }

        return $this->apiResponse(200, __("messages.ticket"), null, new TicketResource($ticket));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function store(AddTicketRequest $request)
    {
        Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return $this->apiResponse(201, __("messages.ticket_created"));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function update(UpdateTicketRequest $request)
    {
        $ticket = Ticket::find($request->ticket_id);

        if (!$ticket) {
            return $this->apiResponse(404, __('messages.ticket_not_founded'));
        }

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return $this->apiResponse(200, __("messages.ticket_updated"));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function destroy(DeleteTicketRequest $request)
    {
        $ticket = Ticket::find($request->ticket_id);

        if (!$ticket) {
            return $this->apiResponse(404, __('messages.ticket_not_founded'));
        }

        $ticket->delete();

        return $this->apiResponse(200, __("messages.ticket_deleted"));
    }
}
