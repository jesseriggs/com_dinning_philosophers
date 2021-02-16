<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\MVC\View\HtmlView;

class Dinning_philosophersViewCategory extends HtmlView
{
	public function display($tpl=null)
	{
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		parent::display($tpl);
	}
}

