<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    protected $table = 'carousels';

    protected $fillable = [
        'name',
        'image',
        'status',
        'is_popup',
        'show_from',
        'show_until',
    ];

    public function getShowDateAttribute(){
        return Carbon::parse($this->show_from)->format('D, d-M-Y H:i:s').' s/d '.Carbon::parse($this->show_until)->format('D, d-M-Y H:i:s');
    }

    public function getIsShowAttribute(){
        $now = Carbon::now();
        
        return $now->between($this->show_from, $this->show_until);
    }
    public function scopeByActive($query)
    {
        return $query->where('show_from', '<=', Carbon::now())
                     ->where('show_until', '>=', Carbon::now())
                     ->where('status','active');
    }
}
