<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
use Encore\Admin\Admin;
use \Encore\Admin\Form;
Form::forget(['map', 'editor']);
Form::extend('scriptinjecter', Field\Interaction\ScriptInjecter::class);

app('view')->prependNamespace('admin', resource_path('views/admin'));
app('view')->prependNamespace('admin', resource_path('views/admin/views'));



Admin::js('/js/app.js');
Admin::css('/css/app.css');

Form::init(function (Form $form) {

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
