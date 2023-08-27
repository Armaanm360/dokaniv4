<?php

namespace App\Http\Resources\ClientLedger;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientLedgerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
