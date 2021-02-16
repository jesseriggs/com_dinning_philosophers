<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_dinning_philosophers
 *
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Router\Route;


/**
 * dinning_philosophers Component Helper file for generating the URL routes
 */
class Dinning_philosophersHelperRoute
{
	/**
	 * This function will generate a URL that Ajax will use.
	 */
	public static function getAjaxURL()
	{
		$app = Factory::getApplication();
		$siteMenu = $app->getMenu();
		$thisMenuItem = $siteMenu->getActive();

		// if we havent' got an active menuitem, or we're
		// curently on menuitem, just stay there.
		if(!$thisMenuItem || $thisMenuItem->alias == "messages")
		{
			return null;
		}

		$mainMenuItems = $siteMenu->getItems('menutype', 
			'mainmenu');
		foreach($mainMenuItems as $menuItem)
		{
			if($menuitem->alias == "messages")
			{
				$itemid = $menuItem->id;
				$url = Route::_(
					"index.php?Itemid=$itemid&".
					"view=dinning_philosophers&".
					"format=json");
				return $url;
			}
		}
		return null;
	}
}
