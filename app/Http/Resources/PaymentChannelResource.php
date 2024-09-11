<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'group' => $this->group,
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type,
            'fee_merchant' => $this->fee_merchant,
            'fee_customer' => $this->fee_customer,
            'total_fee' => $this->total_fee,
            'minimum_amount' => $this->minimum_amount,
            'maximum_amount' => $this->maximum_amount,
            'icon_url' => $this->icon_url,
            'active' => $this->active,
        ];
    }
}
