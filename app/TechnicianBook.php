<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianBook extends Model
{
    protected $guarded = [];

    public function scopeTotalBalance($query){

        return $query->selectRaw('technician_id, (sum(sales) - sum(payments)) as total_balance');
    }

    public function scopePeriodBalance($query){

        return $query->selectRaw('technician_id, (sum(sales) - sum(payments)) as period_balance');
    }



}
