<?php
namespace Quadigital\View;

use Quadigital\View\Grammar\ElementGrammar;

class Element {

    private $_name = null;
    private $_tag = null;
    private $_selfClosing = false;
    private $_contents = null;
    private $_class = null;
    private $_id = null;

    /**
     * @param null $contents
     */
    public function setContents($contents)
    {
        $this->_contents = $contents;

        return $this;
    }
    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * @param boolean $selfClosing
     */
    public function setSelfClosing($selfClosing)
    {
        $this->_selfClosing = $selfClosing;

        return $this;
    }

    /**
     * @param null $tag
     */
    public function setTag($tag)
    {
        $this->_tag = $tag;

        return $this;
    }

    /**
     * @param null $class
     */
    public function setClass($class)
    {
        $this->_class = $class;

        return $this;
    }

    public function __construct($name) {
        $this->_name = $name;
    }

    public function render() {
        call_filter('render_element_' . $this->_name, $this);
        $grammar = new ElementGrammar();

        if ($this->_tag === null) {
            //TODO throw exception
        }
        $grammar->setTag($this->_tag);
        $grammar->setSelfClosing($this->_selfClosing);
        $grammar->setContents($this->_contents);

        return $grammar->get();
    }
}