<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteService extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = "note_service";

    /**
     * Fields
     *
     * @var array
     */
    protected $fillable = [
        'note',
        'order_id',
        'user_id'
    ];
}
