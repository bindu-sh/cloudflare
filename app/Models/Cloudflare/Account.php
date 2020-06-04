<?php

namespace App\Models\Cloudflare;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'cloudflare_accounts';

    protected $fillable = [
        'id', 'account_name', 'notes',
    ];
    public function domains(){
        return $this->hasMany("App\Models\Cloudflare\Domain", "account_id");
    }

}
