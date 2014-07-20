<?php
namespace Home\Controller;
use Think\Controller;
class PrinterController extends Controller {
    public function receive(){
        $this->show("123");
    }
}