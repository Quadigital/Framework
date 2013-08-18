<?php
/**
 * File Description
 *
 * @author    Adam Rivers <riversa@quadigital.co.uk>
 * @copyright 2012-2013 Quadigital <contact@quadigital.co.uk>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * PHP version 5
 */

namespace Quadigital\Core;

use Quadigital\Service\ServiceManager;
use Quadigital\View\Element;
use Quadigital\View\Grammar\ElementGrammar;
use Quadigital\View\SEO\Components\TitleView;
use Quadigital\View\View;

class Application {

    public function run() {
        $title = new Element('title');

        $title->setTag('title');
        $title->setSelfClosing(false);
        $title->setContents('Primary Keyword - Secondary Keyword | Brand Name');
        echo $title->render();
        die();
        $title = new TitleView('Primary Keyword - Secondary Keyword | Brand Name');
        echo $title->isValid() ? 'yes' : 'no';

        include ('tmp/TestView.php');
        $testView = new \TestView();
        echo $testView->render();
    }
}