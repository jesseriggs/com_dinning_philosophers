<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_dinning_philosophers
 *
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Component\Router\RouterInterface;
use \Joomla\CMS\Factory;

/**
 * Routing class of com_dinning_philosophers
 */ 
class Dinning_philosophersRouter implements RouterInterface{

	public function build(&$query)
	{
	    $segments = array();
		if(isset($query['id']))
		{
			$db = Factory::getDbo();
			$qry = $db->getQuery(true);
			$qry->select('alias')
      				->from('#__dinning_philosophers')
				->where('id = ' . 
					$db->quote($query['id'])
				);
			$db->setQuery($qry);
			$alias = $db->loadResult();
			$segments[] = $alias;
			unset($query['id']);
		}
		unset($query['view']);
		return $segments;
	}

	public function parse(&$segments)
	{
		$vars = array();

		$db = Factory::getDbo();
		$qry = $db->getQuery(true);
		$qry->select('id')
			->from('#__dinning_philosophers')
			->where('alias = ' . $db->quote($segments[0]));
		$db->setQuery($qry);
		$id = $db->loadResult();

		if(!empty($id))
		{
			$vars['id'] = $id;
			$vars['view'] = 'dinning_philosophers';
		}

		return $vars;
	}

	public function preprocess($query)
	{
		return $query;
	}
}
