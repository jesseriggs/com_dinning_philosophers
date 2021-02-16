<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_dinning_philosophers
 *
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die("Restricted");

use \Joomla\CMS\Factory;
use \Joomla\CMS\MVC\Model\ListModel;

class Dinning_philosophersModelCategory extends ListModel
{
	public function __construct($config = array())
	{
		if(empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'alias',
			);
		}
		parent::__construct($config);
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$app = Factory::getApplication('site');
		$catid = $app->input->getInit('id');
		$this->setState('category.id', $catid);
	}

	protected function getListQuery()
	{
		$db	= Factory::getDbo();
		$query	= $db->getQuery(true);
		$catid	= $this->getState('category.id');
		$query->select('id, alias')
			->from($db->quoteName('#__dinning_philosophers'))
			->where('catid = '.$catid);
		$orderCol	= $this->state->get('list.ordering', 'alias');
		$orderDirn	= $this->state->get('list.direction', 'asc');

		$query->order($db->escape($orderCol).' '.
			$db->escape($orderDirn));
		return $query;
	}
}
