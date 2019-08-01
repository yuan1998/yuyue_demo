<?php
namespace App\Admin\Controllers;

use App\Doctor;
use App\Http\Controllers\Controller;
use App\Reservation;
use Carbon\Carbon;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Admin;
use Encore\Admin\Widgets\Collapse;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $today = request()->get('date', Carbon::today()->toDateString());
        $data  = Doctor::with([
            'reservation'   => function ($query) use ($today) {
                $query->with(['project'])->whereDate('begin_time', $today)->orderBy('begin_time', 'asc');
            }, 'scheduling' => function ($query) use ($today) {
                $query->with('schedulingStatus')->whereDate('date', $today);
            }
        ])->get();
        Admin::script(<<<EOT
new Vue({
    el: '#app',
});
EOT
        );

        $content->title('今日份预约')->description('治疗病患,我们刻不容缓!');
        if (\Encore\Admin\Facades\Admin::user()->can('reservation.store')) {
            $content->row($this->reservationForm());
        }

        $date = json_encode($today);
        $content->row("<home :doctors='{$data->toJson()}' :today='$date'></home>");

        return $content;
    }

    public function reservationForm()
    {

        $reservationController = new ReservationController();

        return $reservationController->form(function (Form $form) {
            $form->setAction('/');
        });

    }
}
