<?php

namespace App\Admin\Controllers;

use App\SchedulingStatus;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Field\Interaction\FieldSubscriberTrait;
use Field\Interaction\FieldTriggerTrait;

class SchedulingStatusController extends AdminController
{
    use FieldTriggerTrait , FieldSubscriberTrait;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '排班状态管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SchedulingStatus);

        $grid->column('id', __('Id'));
        $grid->column('name', __('名称'));
        $grid->column('scheduling' , __('休息时段'))->display(function () {
            return $this->all_day ? '全天休息' : $this->begin_time .' - ' . $this->end_time;
        });
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
        $show = new Show(SchedulingStatus::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('名称'));
        $show->field('all_day', __('休息时段'))->as(function () {
            return $this->all_day ? '全天休息' : $this->begin_time .' - ' . $this->end_time;
        });
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SchedulingStatus);

        $form->text('name', __('名称'))->rules('required');
        $form->switch('all_day' , '全天时段')->default(0);
        $form->timeRange('begin_time', 'end_time', '休息时段');

        $triggerScript = $this->createTriggerScript($form);

        // 在定义完控件后。。。
// 弄一个触发事件的Script对象。
        $triggerScript = $this->createTriggerScript($form);

// 弄-个接收并处理事件的Script对象。
        $subscribeScript = $this->createSubscriberScript($form, function($builder){
            // 添加事件响应函数
            $builder->subscribe('all_day', 'switchchange', function($event){

                // 这里填写处理事件的javascript脚本，注意：一定要返回一个完整的 javascript function ，否则报错！！！！
                return <<< EOT
function(data) {
    $('[for=begin_time]').parent()[data==='on'? 'hide' : 'show']()
}

EOT;
            });
        });

// 最后把 $triggerScript 和 $subscribeScript 注入到Form中去。
        $form->scriptinjecter('name_no_care', $triggerScript, $subscribeScript);

        $form->editing(function (Form $form) {
            if ($form->model()->id) {
                $allDay = $form->model()->all_day;
                Admin::script(<<<EOT
    $('[for=begin_time]').parent()[{$allDay}? 'hide' : 'show']()
EOT
);
            }

        });

        $form->saving(function (Form $form) {
            $allDay =  $form->input('all_day');
            $begin = $form->input('begin_time');
            $end = $form->input('end_time');

            if ((!$allDay || $allDay === 'off') && (!$begin || !$end)) {
                return back()->withInput(admin_info( '警告提示' , '请选择正确的休息时间！！'));
            }

            if ($allDay === 'on') {
                $form->__set('begin_time' , null);
                $form->__set('end_time' , null);
            }


        });
        return $form;
    }
}
