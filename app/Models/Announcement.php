<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;
    protected $table = 'announcements';
    protected $guarded = [];

    protected $appends = ['new'];

    public function getNewAttribute(){
        $expired = Carbon::parse($this->created_at)->addDays(14);
        if($expired < Carbon::now('Asia/Jakarta')){
            return false;
        }
        return true;
    }
}
