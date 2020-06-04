<?php

namespace App\Models\Cloudflare;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'cloudflare_domains';

    public function accounts(){
        return $this->hasMany("App\Models\Cloudflare\Account", "account_id");
    }
}
