<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $unread_noti_count = $this->unreadNotifications()->count();
        return [
            'name' => $this->name,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'account_number' => $this->wallet ? $this->wallet->account_number : '',
            'balance' => $this->wallet ? number_format($this->wallet->amount) : 0,
            'profile' => asset('img/profile.png'),
            'receive_qr_value' => $this->phone,
            'unread_noti_count' => $unread_noti_count,
        ];
    }
}
