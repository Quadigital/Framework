<?php
namespace Quadigital\View;

class CompositeView implements ViewInterface
{
    private $_views = array();

    protected function attachView($viewName, ViewInterface $view) {
        call_hook('attach_view_' . $viewName);
        $this->_views[$viewName] = $view;

        return $this;
    }

    protected function detachView($viewName) {
        if (isset($viewName)) {
            unset($this->_views[$viewName]);
        }

        return $this;
    }

    public function render() {
        $output = "";
        foreach ($this->_views as $viewName => $view) {
            $output .= call_hook('render_view_' . $viewName);
            $output .= $view->render();
        }
        return $output;
    }
}