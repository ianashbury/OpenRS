{{
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
//
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

 }}
<div id="content">
      <div class="header_row">{{= lang('manager_features_title') }}</div  >
      <p class="nav_links"><b>{{= anchor('manager/feature/add', lang('manager_features_add_feature')) }}</b></p>
      <div class="pagenav">{{= lang('manager_page') }}{{= $pagination }}</div>
      <div class="break"></div>
      {{ foreach ($allfeatures as $result): }}
            <div class="manager_row">
                  <p class="manager_left">
                        {{= character_limiter($result->name, 50) }}
            </p>
            <p class="manager_narrow">{{= anchor('manager/feature/edit/'.$result->id, lang('manager_features_list_edit')) }}</p>
            <p class="manager_narrow">{{= anchor('manager/feature/delete/'.$result->id, lang('manager_features_list_delete'),' id="darkblue"') }}</p>
      </div>
      {{ endforeach }}
      <div class="pagenav">{{= lang('manager_page') }}{{= $pagination }}</div>
</div>