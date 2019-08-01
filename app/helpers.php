<?php

function admin_write_script($string) {
    session()->flash('self-script' , $string);
}
