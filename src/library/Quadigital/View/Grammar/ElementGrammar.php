<?php
namespace Quadigital\View\Grammar;

class ElementGrammar {

    private $_tag = '';
    private $_selfClosing = false;
    private $_contents = '';

    public function setTag($tag) {
        $this->_tag = $tag;

        return $this;
    }

    public function setSelfClosing($selfClosing = true) {
        $this->_selfClosing = $selfClosing;

        return $this;
    }

    public function setContents($contents) {
        $this->_contents = $contents;

        return $this;
    }

    public function get() {
        $tagBase = $this->compileTag();
        $this->compileContents($tagBase);
        $this->finishTag($tagBase);

        return $tagBase;
    }

    private function compileTag() {
        if ($this->_selfClosing) {
            $tagBase = '<%s{tag_modifiers} />';
        } else {
            $tagBase = '<%1$s{tag_modifiers}>{tag_contents}</%1$s>';
        }

        return sprintf($tagBase, $this->_tag);
    }

    private function compileContents(&$element) {
        if (!$this->_selfClosing && $this->_contents !== '') {
            $element = str_replace('{tag_contents}', $this->_contents, $element);
        }
    }

    private function finishTag(&$element) {
        $element = str_replace(array('{tag_contents}', '{tag_modifiers}'), '', $element);
    }

//    $grammar->setTag('title')->setSelfClosing(false)->setContents('Primary Keyword - Secondary Keyword | Brand Name')->get();
}