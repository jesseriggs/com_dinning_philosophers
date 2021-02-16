<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\Form\FormHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\HTML\HTMLHelper;

FormHelper::loadFieldClass('list');

/**
 * Dinning_philosophers Form Field class for the Dinning_philosophers component
 *
 * @since  0.0.1
 */
class JFormFieldDinning_philosophers extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Dinning_philosophers';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
	    $db    = Factory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__dinning_philosophers.id as id,#__categories.title as category,catid');
		$query->from('#__dinning_philosophers');
		$query->leftJoin('#__categories on catid=#__categories.id');
		// Retrieve only published items
		$query->where('#__dinning_philosophers.published = 1');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();

		if ($messages)
		{
			foreach ($messages as $message)
			{
			    $options[] = HTMLHelper::_('select.option', $message->id,
					($message->catid ? ' (' . 
					$message->category . ')' : ''));
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
