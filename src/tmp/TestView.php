<?php

class TestView extends \Quadigital\View\CompositeView {
    function __construct() {
        $header = new \Quadigital\View\View('tmp' . DS . 'composite' . DS . 'header');
        $header->content = 'This is my fancy header section';
        $header->ip = function () {
            return $_SERVER['REMOTE_ADDR'];
        };

        $body = new \Quadigital\View\View('tmp' . DS . 'composite' . DS . 'body');
        $body->content = 'This is my fancy body section';

        $footer = new \Quadigital\View\View('tmp' . DS . 'composite' . DS . 'footer');
        $footer->content = 'This is my fancy footer section';

        $this->attachView('header', $header)
            ->attachView('body', $body)
            ->attachView('footer', $footer);
    }
}