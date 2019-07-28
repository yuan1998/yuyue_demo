<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scheduling extends Model
{
    protected $fillable = ['doctor_id' , 'date' , 'scheduling_status_id'];

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }

    public function schedulingStatus() {
        return $this->hasOne(SchedulingStatus::class,'id','scheduling_status_id');
    }
}
