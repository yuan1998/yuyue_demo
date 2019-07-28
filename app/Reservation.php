<?php
namespace App;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['name', 'project_name', 'begin_time', 'end_time', 'doctor_id', 'admin_id', 'description' , 'sex'];


    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }

    public function admin() {
        return $this->belongsTo(Administrator::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

}
