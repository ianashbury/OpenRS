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
 * Category model class
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            model
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Category_model extends CI_Model {

    /*
     * Category model class constructor
     */

    function Category_model() {
	parent::__construct();
	$this->load->database();
    }

    /*
     * addCategory function
     */

    function addCategory($name) {
	// add the category
	$seo_name = url_title(trim($name), '-', TRUE);
	$data = array(
	    'name' => $name,
	    'seo_name' => $seo_name
	);
	$this->db->insert('category', $data);
    }

    /*
     * updateCategory function
     */

    function updateCategory($id, $name) {
	// update the category
	$seo_name = url_title(trim($name), '-', TRUE);
	$data = array(
	    'name' => $name,
	    'seo_name' => $seo_name
	);
	$this->db->where('id', $id);
	$this->db->update('category', $data);
    }

    /*
     * deleteCategory function
     */

    function deleteCategory($id) {
	// delete the category
	$this->db->where('id', $id);
	$this->db->delete('category');
    }

    /*
     * getAllCategories function
     */

    function getAllCategories($limit = 0, $offset = 0, $return_array = 0) {
	// return all categories
	// offset is used in pagination
	if (!$offset) {
	    $offset = 0;
	}
	$this->db->order_by('name');
	// if a limit more than zero is provided, limit the results
	if ($limit > 0) {
	    $this->db->limit($limit, $offset);
	}
	$query = $this->db->get('category');
	// return the categories
	if ($query->num_rows() > 0) {
	    if ($return_array == 1) {
		return $query->result_array();
	    } else {
		return $query->result();
	    }
	}
	// no result
	return FALSE;
    }

    /*
     * getCategoryById function
     */

    function getCategoryById($id) {
	// return the category
	$this->db->where('id', $id);
	$this->db->limit(1);
	$query = $this->db->get('category');
	if ($query->num_rows() > 0) {
	    return $query->row();
	}
	// no result
	return FALSE;
    }

    /*
     * getCategoriesDropDown function
     */

    function getCategoriesDropDown($id=0) {
	// get data for categories drop down list
	$this->db->select('id,name');
	$this->db->order_by('name');
	if ($id > 0) {
	    $this->db->where('id !=', $id);
	}
	$query = $this->db->get('category');
	if ($query->num_rows() > 0) {
	    $categories[0] = '--------';
	    foreach ($query->result() as $category_row) {
		$categories[$category_row->id] = $category_row->name;
	    }
	    // return the categories list
	    return $categories;
	}
	// no results
	return FALSE;
    }

    /*
     * countCategories function
     */

    function countCategories() {
	// return total number of all categories
	return $this->db->count_all_results('category');
    }

    /*
     * getNameFromSeoName function
     */

    function getNameFromSeoName($category_seo_name) {
	// get the category name based on the seo name
	$this->db->where('seo_name', $category_seo_name);
	$query = $this->db->get('category');
	// return the category
	if ($query->num_rows() > 0) {
	    $result = $query->row();
	    $category_name = $result->name;
	    return $category_name;
	}
	// no result
	return FALSE;
    }

}

/* End of file category_model.php */
/* Location: ./application/models/category_model.php */