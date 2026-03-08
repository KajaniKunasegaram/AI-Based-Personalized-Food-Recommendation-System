<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class WebsiteStatusModel extends Model
{
    protected $table = 'tbl_website_status';
    protected $fillable = ['status', 'reopen_date', 'message'];
}
