<?php

namespace App\Model;

use App;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    public $timestamps = true;
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = ['is_read'];

    public function message_contact()
    {
        return $this->belongsTo(Message::class, 'message_id', 'message_id');
    }

}
