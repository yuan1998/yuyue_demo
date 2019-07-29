<?php

namespace App\Admin\Controllers;

use App\Doctor;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DoctorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '医生管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Doctor);

        $grid->column('id', __('Id'));
        $grid->column('name', '医生姓名');
        $grid->column('description', '医生描述');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

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
        $show = new Show(Doctor::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', '医生姓名');
        $show->field('description', '医生描述');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '修改时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Doctor);

        $form->text('name', '医生姓名')->rules('required');
        $form->text('description', '医生描述(可选)');

        return $form;
    }
}
