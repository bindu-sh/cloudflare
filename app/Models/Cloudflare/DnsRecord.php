<?php

namespace App\Models\Cloudflare;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DnsRecord extends Model
{
    use SoftDeletes;
    protected $table = 'cloudflare_records';
}
