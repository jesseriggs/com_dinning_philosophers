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

use \Joomla\CMS\Factory;
use \Joomla\CMS\Helper\ContentHelper;
use \Joomla\CMS\Language\Text;

/**
 * Dinning_philosophers component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 */
abstract class Dinning_philosophersHelper extends ContentHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */

	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			Text::_('COM_DINNING_PHILOSOPHERS_SUBMENU_MESSAGES'),
			'index.php?option=com_dinning_philosophers',
			$submenu == 'dinning_philosopherss'
		);

		JHtmlSidebar::addEntry(
			Text::_('COM_DINNING_PHILOSOPHERS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&view=categories&extension=com_dinning_philosophers',
			$submenu == 'categories'
		);

		// Set some global property
		$document = Factory::getDocument();

		if ($submenu == 'categories') 
		{
			$document->setTitle(Text::_('COM_DINNING_PHILOSOPHERS_ADMINISTRATION_CATEGORIES'));
		}
	}
}
