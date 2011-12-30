<?php

/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @author		OpenReviewScript.org
 * @copyright           Copyright (c) 2011, OpenReviewScript.org
 * @license		This file is part of OpenReviewScript - free software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
 * @link		http://OpenReviewScript.org
 */
// ------------------------------------------------------------------------

/**    This file is part of OpenReviewScript.
 *
 *    OpenReviewScript is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    OpenReviewScript is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with OpenReviewScript.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Article controller class
 *
 * Displays an article
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Article extends CI_Controller {

    /*
     * Article controller class constructor
     */

    function Article() {
	parent::__construct();
	$this->load->model('Article_model');
	$this->load->model('Ad_model');
	$this->load->model('Review_model');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * show function
     *
     * display an article
     */

    function show($requested_article_title) {
	// load data for view
	debug('article page | show function');
	$data['article'] = $this->Article_model->getArticleBySeoTitle($requested_article_title);
	$data['featured_count'] = $this->setting['featured_count'];
	$approval_required = $this->setting['review_approval'];
	$data['featured'] = $this->Review_model->getFeaturedReviews($data['featured_count'], 0, $approval_required);
	$data['featured_minimum'] = $this->setting['featured_minimum'];
	$data['featured_reviews'] = $this->setting['featured_section_article'] == 1 ? count($data['featured']) : 0;
	$data['sidebar_ads'] = $this->Ad_model->getAds($this->setting['max_ads_article_sidebar'], 3);
	$data['article_ads'] = $this->Ad_model->getAds(1, 2);
	$data['show_recent'] = $this->setting['recent_review_sidebar'];
	$data['show_search'] = $this->setting['search_sidebar'];
	$approval_required = $this->setting['review_approval'];
	if ($data['show_recent'] == 1) {
	    $data['recent'] = $this->Review_model->getLatestReviews($this->setting['number_of_reviews_sidebar'], 0, $approval_required);
	} else {
	    $data['recent'] = FALSE;
	}
	if ($data['article']) {
	    debug('found article with title "' . $requested_article_title . '"');
	    // article exists
	    // set page_title, meta_keywords and meta_description
	    $data['page_title'] = $this->setting['site_name'] . ' - ' . lang('article_page_title_article') . ' - ' . $data['article']->title;
	    if (trim($data['article']->meta_keywords) !== '') {
		$data['meta_keywords'] = trim($data['article']->meta_keywords);
	    } else {
		$data['meta_keywords'] = str_replace('"', '', $data['article']->title);
	    }
	    if (trim($data['article']->meta_description) !== '') {
		$data['meta_description'] = trim($data['article']->meta_description);
	    } else {
		$data['meta_description'] = str_replace('"', '', character_limiter(strip_tags($data['article']->description, 155)));
	    }
	    // display the article page
	    debug('loading the "article/article_content" view');
	    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/article/article_content', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/article/article_sidebar');
	    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template.tpl', $sections, $data);
	} else {
	    // article does not exist so show 404 not found page
	    debug('article with title "' . $requested_article_title . '" not found');
	    show_404();
	}
    }

}

/* End of file article.php */
/* Location: ./application/controllers/article.php */