<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['name', 'description'];

    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scheduling() {
        return $this->hasMany(Scheduling::class);
    }

}
