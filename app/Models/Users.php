<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $guarded = [];

    /**
     * get user brokerage
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function brokerage()
    {
        return $this->hasOne('Models\Brokerages', 'id', 'brokerage_id');
    }

    /**
     * update message status
     * @param $status
     */
    function changeMessageStatus($status)
    {
        $this->message_status = $status;
        $this->save();
    }
}
