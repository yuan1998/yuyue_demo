<?php
namespace App\Admin\Controllers;

use App\Doctor;
use App\Http\Requests\SchedulingStoreRequest;
use App\Scheduling;
use App\SchedulingStatus;
use Carbon\Carbon;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SchedulingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Scheduling';

    public function table(Content $content)
    {
        $date = Carbon::parse(request()->get('date', date('Y-m-d')));
        $month      = $date->month;
        $year       = $date->year;
        $doctors    = Doctor::with([
            'scheduling' => function ($query) use ($month, $year) {
                $query->whereMonth('date', $month)->whereYear('date', $year);
            }
        ])->get();
        $statusList = SchedulingStatus::all();
        Admin::script(<<<EOT
new Vue({
    el: '#app',
});
EOT
        );

        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->row("<scheduling :doctors='{$doctors->toJson()}' :status-list='{$statusList->toJson()}'></scheduling>");
    }

    public function apiStore(SchedulingStoreRequest $request) {
        $data = $request->only(['doctor_id' , 'date' ]);
        $scheduling_status_id = $request->get('scheduling_status_id');

        if ($scheduling_status_id) {
            Scheduling::updateOrCreate($data , ['scheduling_status_id' => $scheduling_status_id]);
        } else {
            Scheduling::where('doctor_id' , $data['doctor_id'])->whereDate('date' , $data['date'])->delete();
        }
        return response(null , 204);
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Scheduling);
        $grid->column('doctor.name', __('医生'));
        $grid->column('date', __('日期'))->display(function ($val) {
            return Carbon::parse($val)->toDateString();
        });
        $grid->column('schedulingStatus.name', __('休息状态'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Scheduling::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('date', __('Date'));
        $show->field('doctor_id', __('Doctor id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('scheduling_status_id', __('Scheduling status id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Scheduling);
        $form->date('date', __('日期'))->default(date('Y-m-d'))->rules('required');
        $doctorArr = [];
        Doctor::all(['id', 'name'])->each(function ($item) use (&$doctorArr) {
            $doctorArr[$item->id] = $item->name;
        });
        $form->select('doctor_id', '医生')->options($doctorArr)->rules('required');
        $statusArr = [];
        SchedulingStatus::all(['id', 'name'])->each(function ($item) use (&$statusArr) {
            $statusArr[$item->id] = $item->name;
        });
        $form->select('scheduling_status_id', '状态')->options($statusArr)->rules('required');
        $form->saving(function (Form $form) {
            $date      = $form->input('date');
            $doctor_id = $form->input('doctor_id');
            if (Scheduling::where('doctor_id', $doctor_id)->whereDate('date', $date)->exists()) {
                return back()->withInput(admin_info('警告提示', '当天医生已经有另外的排班'));
            }

        });

        return $form;
    }
}
