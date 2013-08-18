<?php
namespace Quadigital\View\SEO\Components;

use Quadigital\View\SEO;
use Quadigital\View\View;

class TitleView extends View implements SEO\SeoValidationInterface {

    const SEO_FRIENDLY_TITLE_LENGTH = 70;

    function __construct($page_title) {
        $this->setTemplate(__DIR__ . DS . 'includes' . DS . 'Title');
        $this->title = htmlspecialchars($page_title);
    }

    public function isValid() {
        return $this->isValid_length() && $this->isValid_format();
    }

    private function isValid_length() {
        return count($this->title) < self::SEO_FRIENDLY_TITLE_LENGTH;
    }

    private function isValid_format() {
        // Primary Keyword - Secondary Keyword | Brand Name
        $format1 = '/^.*?' . // Primary Keyword
            '(\\s+)(-)(\\s+)' . // ' - '
            '.*?' . // Secondary Keyword
            '(\\s+)(\\|)(\\s+)' . // ' | '
            '.*?/'; // Brand Name

        // Brand Name | Primary Keyword and Secondary Keyword
        $format2 = '/^.*?' . // Primary Keyword
            '(\\s+)(\\|)(\\s+)' . // ' | '
            '.*?/'; // Brand Name

        return preg_match($format2, $this->title) === 1 ||
            preg_match($format1, $this->title) === 1;
    }
}

/*
 * ------------------------------------------------------
 *   SEO Friendly hints for <title> tag
 * ------------------------------------------------------
 */

/**
 * Optimal Format
 *     Primary Keyword - Secondary Keyword | Brand Name
 * or
 *     Brand Name | Primary Keyword and Secondary Keyword
 */

/**
 * Be Mindful of Length
 *
 *   A maximum amount of 70 characters will display in the search results. The engines will show an ellipsis, "..." to
 *   indicate that a title tag has been cut off.
 *
 * Place Important Keywords Close to the Front of the Title Tag
 *
 *   According to Moz's testing and experience, the closer to the start of the title tag a keyword is, the more helpful
 *   it will be for ranking—and the more likely a user will be to click them in search results.
 *
 * Leverage Branding
 *
 *   Many SEO firms recommend using the brand name at the end of a title tag instead, and there are times when this can
 *   be a better approach. The differentiating factor is the strength and awareness of the brand in the target market.
 *   If a brand is well–known enough to make a difference in click–through rates in search results, the brand name
 *   should be first. If the brand is less known or relevant than the keyword, the keyword should be first.
 *
 * Consider Readability and Emotional Impact
 *
 *   Creating a compelling title tag will pull in more visits from the search results. It's vital to think about the
 *   entire user experience when you're creating your title tags, in addition to optimization and keyword usage. The
 *   title tag is a new visitor's first interaction with your brand when they find it in a search result; it should
 *   convey the most positive message possible.
 */