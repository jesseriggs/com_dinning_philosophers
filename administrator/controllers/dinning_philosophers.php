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

use \Joomla\CMS\MVC\Controller\FormController;
use \Joomla\CMS\Factory;

class Dinning_philosophersControllerDinning_philosophers extends FormController
{
	/**
	 * Workaround for pluralization bug. Joomla doesn't pluralize nouns
	 * that end in the letter 's'. 
	 */
	protected $view_list = "dinning_philosopherss";

	/**
	* Implement to allowAdd or not
	*
	* Not used at this time (but you can look at how other components
	* use it....)
	* 
	* Overwrites: JControllerForm::allowAdd
	*
	* @param array $data
	* @return bool
	*/
	protected function allowAdd($data = array())
	{
		return parent::allowAdd($data);
	}
	/**
	* Implement to allow edit or not
	* Overwrites: JControllerForm::allowEdit
	*
	* @param array $data
	* @param string $key
	* @return bool
	*/
	protected function allowEdit($data = array(), $key = 'id')
	{
		$id = isset( $data[ $key ] ) ? $data[ $key ] : 0;
		if( !empty( $id ) )
		{
		    return Factory::getUser()->authorise( 
				"core.edit", 
				"com_dinning_philosophers.dinning_philosophers." . $id );
		}
	}
}
