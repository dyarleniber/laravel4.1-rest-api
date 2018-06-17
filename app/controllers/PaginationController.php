<?php

use Illuminate\Pagination\Presenter;

class PaginationController extends Presenter
{
	/**
	 * Get HTML wrapper for a page link.
	 *
	 * @param  string  $url
	 * @param  int  $page
	 * @return string
	 */
	public function getPageLinkWrapper($url, $page)
	{
		return '<li class="page-item"><a class="page-link" href="'.$url.'">'.$page.'</a></li>';
	}

	/**
	 * Get HTML wrapper for disabled text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getDisabledTextWrapper($text)
	{
		return '<li class="page-item disabled"><a class="page-link">'.$text.'</a></li>';
	}

	/**
	 * Get HTML wrapper for active text.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getActivePageWrapper($text)
	{
		return '<li class="page-item active"><a class="page-link">'.$text.'</a></li>';
	}
}