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

Encore\Admin\Form::forget(['map', 'editor']);

Encore\Admin\Form::extend('scriptinjecter', Field\Interaction\ScriptInjecter::class);


Admin::js('https://cdn.bootcss.com/vue/2.6.10/vue.min.js');
Admin::js('https://cdn.jsdelivr.net/npm/vue-cal@2.1.0/dist/vuecal.umd.min.js');
Admin::js('/js/app.js');
Admin::css('https://cdn.jsdelivr.net/npm/vue-cal@2.1.0/dist/vuecal.css');
Admin::css('/css/app.css');
