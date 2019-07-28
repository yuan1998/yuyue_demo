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
        $data = Doctor::with([
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
        $date = json_encode($today);

        return $content
            ->title('今日份预约')
            ->description('治疗病患,我们刻不容缓!')
            ->row($this->reservationForm())
            ->row("<home :doctors='{$data->toJson()}' :today='$date'></home>");
    }

    public function homeJs()
    {
        Admin::script('initHome();');
    }

    public function reservationForm()
    {

        $reservationController = new ReservationController();

        return $reservationController->form(function (Form $form) {

            $form->tools(function (Form\Tools $tools) {

                // 去掉`列表`按钮
                $tools->disableList();
                // 去掉`删除`按钮
                $tools->disableDelete();
                // 去掉`查看`按钮
                $tools->disableView();

            });
            $form->footer(function ($footer) {

                // 去掉`重置`按钮
                $footer->disableReset();
                // 去掉`提交`按钮
                // $footer->disableSubmit();
                // 去掉`查看`checkbox
                $footer->disableViewCheck();
                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();
                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();

            });
        });

    }
}
