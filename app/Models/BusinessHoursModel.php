<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessHoursModel extends Model
{
    protected $table ='tbl_business_hours';

    protected $fillable =[
        'day_of_week',
        'service_type',
        'open_time',
        'close_time',
        'is_open',
    ];

    protected $casts =[
        'is_open'=> 'boolean',
    ];

     // ---------- ACCESSORS ----------
    public function getFormattedOpenTimeAttribute()
    {
        return $this->open_time ? date('g:i A', strtotime($this->open_time)) : null;
    }

    public function getFormattedCloseTimeAttribute()
    {
        return $this->close_time ? date('g:i A', strtotime($this->close_time)) : null;
    }

    public function getTimeRangeAttribute()
    {        
        return $this->formatted_open_time . " - " . $this->formatted_close_time;
    }
}
