<?php namespace Mlm\Libs\Pagination;

use Illuminate\Pagination\Presenter;

class MlmPresenter extends Presenter {

    /**
     * Get HTML wrapper for a page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string  $rel
     * @return string
     */
    public function getPageLinkWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

        return '<li><a href="'.$url.'"'.$rel.'>'.$page.'</a></li>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    public function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><a>'.$text.'</a></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    public function getActivePageWrapper($text)
    {
        return '<li class="active"><a>'.$text.'</a></li>';
    }

}
