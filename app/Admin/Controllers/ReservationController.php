<?php
namespace App\Admin\Controllers;

use App\Doctor;
use App\Project;
use App\Reservation;
use App\Scheduling;
use Carbon\Carbon;
use Closure;
use Encore\Admin\Admin;
use Encore\Admin\Facades\Admin as Ad;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\MessageBag;

class ReservationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '预约管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Reservation);
        $grid->column('id', __('Id'));
        $grid->column('doctor.name', __('手术医生'));
        $grid->column('name', __('顾客姓名'));
        $grid->column('description', __('描述'));
        $grid->column('project.name', __('手术项目'));
        $grid->column('begin_time', __('手术开始时间'));
        $grid->column('end_time', __('手术结束时间'));
        $grid->column('admin.name', __('预约创建者'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('修改时间'));

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
        $show = new Show(Reservation::findOrFail($id));
        $show->field('id', __('Id'));
        $show->field('doctor_id', __('Doctor id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('project.name', __('Project name'));
        $show->field('begin_time', __('Begin time'));
        $show->field('end_time', __('End time'));
        $show->field('admin_id', __('Admin id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     * @param $closure Closure
     * @return Form
     */
    public function form(Closure $closure = null)
    {
        $form = new Form(new Reservation);
        $arr  = [];
        Doctor::all()->each(function ($item) use (&$arr) {
            $arr[$item->id] = $item->name;
        });
        $form->select('doctor_id', __('医生'))->options($arr)->placeholder('请选择手术医生')->rules('required');
        $form->text('name', __('顾客姓名'))->rules('required');
        $form->radio('sex', __('性别'))->options(['未知' => '未知', '女' => '女', '男' => '男'])->default('未知')->rules('required');
        $projectArr = [];
        Project::all()->each(function ($item) use (&$projectArr) {
            $projectArr[$item->id] = $item->name;
        });
        $form->select('project_id', __('手术项目'))->options($projectArr)->placeholder('请选择手术项目')->rules('required');
        $form->timeRange('begin_time', 'end_time', '手术时间')
            ->rules('required');
        $form->text('description', __('描述(可选)'));
        $form->editing(function (Form $form) {
            $model             = $form->model();
            $model->begin_time = Carbon::parse($model->begin_time)->toTimeString();
            $model->end_time   = Carbon::parse($model->end_time)->toTimeString();
        });
        $form->hidden('admin_id');

        // 在表单提交前调用
        $form->saving(function (Form $form) {
            $begin = $form->input('begin_time');
            $end = $form->input('end_time');
            $beginTime = Carbon::parse($begin);
            $endTime   = Carbon::parse($end);
            if ($endTime->lt($beginTime)) {
                return back()->withInput(admin_error('错误', '选择了时间错误,结束时间在开始时间之前！！'));
            }


            $beginTime = $beginTime->toDateTimeString();
            $endTime   = $endTime->toDateTimeString();
            $date = Carbon::now()->toDateString();
            $doctorId = $form->input('doctor_id');

            $rest = Scheduling::query()
                ->where('doctor_id',$doctorId)
                ->whereDate('date', $date)
                ->whereHas('schedulingStatus',function ($query) use ($begin ,  $end) {
                    $query->where("all_day" , 1)
                        // A a b B
                        ->orWhere(function ($query) use ($begin, $end) {
                            $query->where('begin_time', '<=', $begin)->where('end_time', '>=', $end);
                        })
                        // a A B b
                        ->orWhere(function ($query) use ($begin, $end) {
                            $query->where('begin_time', '>=', $begin)->where('end_time', '<=', $end);
                        })
                        // A < a < B < b
                        ->orWhere(function ($query) use ($begin, $end) {
                            $query->where('begin_time', '<=', $begin)
                                ->where('end_time' , '>=' , $begin)
                                ->where('end_time', '<=', $end);
                        })
                        // a A b B   =>   ab  AB
                        ->orWhere(function ($query) use ($begin, $end) {
                            $query->where('begin_time' , '<=' , $end)->where('begin_time', '>=', $begin)->where('end_time', '>=', $end);
                        })
                    ;
                })
                ->exists();

            if ( $rest ) {
                return back()->withInput(admin_info('泰拳警告', '选择时间错误,当前医生正在三亚度假！！'));
            }



            $query    = Reservation::query();
            if ($id = $form->model()->id) {
                $query->where('id', '<>', $id);
            } else {
                $form->input('admin_id', Ad::user()->id);
            }
            $timeArr = [$beginTime, $endTime];
            $result  = $query->where('doctor_id', $doctorId)
                ->where(function ($query) use ($beginTime, $endTime) {
                    $query
                        //   A  a  b  B
                        ->where(function ($query) use ($beginTime, $endTime) {
                            $query->where('begin_time', '<=', $beginTime)->where('end_time', '>=', $endTime);
                        })
                        // a A B b
                        ->orWhere(function ($query) use ($beginTime, $endTime) {
                            $query->where('begin_time', '>=', $beginTime)->where('end_time', '<=', $endTime);
                        })
                        // A < a < B < b  , exclude AB ab
                        ->orWhere(function ($query) use ($beginTime, $endTime) {
                            $query->where('begin_time', '<=', $beginTime)->where('end_time' , '>=' , $beginTime)->where('end_time', '<=', $endTime);
                        })
                        // a < A < b < B  , exclude  ab AB
                        ->orWhere(function ($query) use ($beginTime, $endTime) {
                            $query->where('begin_time', '>=', $beginTime)->where('begin_time' , '<=' , $endTime)->where('end_time', '>=', $endTime);
                        });
                })->exists();
            if ($result) {
                session()->flash('self-script' , <<<EOT
alert(123);
EOT
);
                return back()->withInput();
            }
            $form->input('begin_time', $beginTime);
            $form->input('end_time', $endTime);
        });

        if (is_callable($closure)) {
            $closure($form);
        }

        return $form;
    }

    ///
    public function formSaving(Form $form)
    {

    }
}
