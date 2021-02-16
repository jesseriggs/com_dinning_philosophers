<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die;

use \Joomla\CMS\Categories\Categories;

/**
 * Content Component Category Tree
 */
class Dinning_philosophersCategories extends Categories
{
	/**
	 * Class constructor
	 *
	 * @param   array  $options  Array of options
	 */
	public function __construct($options = array())
	{
		$options['table'] = '#__dinning_philosophers';
		$options['extension'] = 'com_dinning_philosophers';

		parent::__construct($options);
	}
}
