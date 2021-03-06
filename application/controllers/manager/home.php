<?php

/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          manager
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
 * Home controller class
 *
 * Displays the manager home page
 *
 * @package		OpenReviewScript
 * @subpackage          manager
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Home extends CI_Controller {

    /*
     * Home controller class constructor
     */

    function Home() {
	parent::__construct();
	$this->load->model('Review_model');
	$this->load->model('Comment_model');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * index function (default)
     *
     * display manager home page
     */

    function index() {
	debug('manager/home page | index function');
	// check user is logged in with manager level permissions
	$this->secure->allowManagers($this->session);
	// load data for information on home page
	$data['reviews_to_approve'] = $this->setting['review_approval'] == 1 ? $this->Review_model->countReviewsPending() : 0;
	$data['comments_to_approve'] = $this->setting['comment_approval'] == 1 ? $this->Comment_model->countCommentsPending() : 0;
	$data['action_required'] = ($data['reviews_to_approve'] OR $data['comments_to_approve']) ? TRUE : FALSE;
	$data['topreviews'] = $this->Review_model->mostViewed();
	$data['topclicks'] = $this->Review_model->mostClicks();
	debug('loaded data for home page');
	// display home page
	debug('loading "manager/home" view');
	$sections = array('content' => 'manager/' . $this->setting['current_manager_theme'] . '/template/home/home', 'sidebar' => 'manager/' . $this->setting['current_manager_theme'] . '/template/sidebar');
	$this->template->load('manager/' . $this->setting['current_manager_theme'] . '/template/manager_template', $sections, $data);
    }

}

/* End of file home.php */
/* Location: ./application/controllers/manager/home.php */