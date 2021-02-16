<?php
/**
 * @package	Joomla.Administrator
 * @subpackage	com_dinning_philosophers
 * 
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');

use \Joomla\CMS\Access\Rules;
use \Joomla\CMS\Filter\OutputFilter;
use \Joomla\CMS\Table\Table;
use \Joomla\Registry\Registry;

/**
 * dinning_philosophers table class
 */
class Dinning_philosophersTableDinning_philosophers extends Table
{
	/**
	 * constructor
	 * @param JDatabaseDriver &$db A database connector object
	 */
	function __construct(&$db)
	{
		parent::__construct('#__dinning_philosophers', 'id', $db);
	}

	/**
	 * overloaded bind function
	 *
	 * @param	array	named array
	 * @return	null|string	null is operation was satisfactory,
	 * 		    otherwise returns an error.
	 * @see		JTable:bind
	 */
	public function bind($array, $ignore = '')
	{
		if(isset($array['params']) && is_array($array['params']))
		{
		    $parameter = new Registry;
			$parameter->loadArray($array['params']);
			$array['params'] = (string)$parameter;
		}

		if(isset($array['imageinfo'])&&is_array($array['imageinfo']))
		{
		    $parameter = new Registry;
			$parameter->loadArray($array['imageinfo']);
			$array['image'] = (string)$parameter;
		}

		//bind the rules
		if(isset($array['rules'])&&is_array($array['rules']))
		{
		    $rules = new Rules($array['rules']);
			$this->setRules($rules);
		}
		
		return parent::bind($array, $ignore);
	}

	/**
	 * compute default asset name. default name is of form 'table_name.id'
	 * where id is the value of the primary key of table.
	 * @return	string
	 */
	protected function _getAssetName()
	{
		$k = $this-_tbl_key;
		return 'com_dinning_philosophers.dinning_philosophers.'.(int)$this->$k;
	}

	/**
	 * get asset-parent-id of item
	 * @return	int
	 */
	protected function _getAssetParentId(Table $table=NULL, $id=NULL)
	{
		$assetParent = Table::getInstance('Asset');
		$assetParentId = $assetParent->getRootId();
		
		if(($this->catid)&& !empty($this->catid))
		{
			// if item has category as asset-parent
			$assetParent->loadByName('com_dinning_philosophers.category.'
			    .(int)$this->catId);
		} else {
			// if item has component as asset-parent
			$assetParent->loadByName('com_dinning_philosophers');
		}

		// return the found asset-parent-id
		if($assetParent->id)
		{
			$assetParentId=$assetParent->id;
		}
		return $assetParentId;
	}

	public function check()
	{
		$this->alias = trim($this->alias);
		if(empty($this->alias))
		{
			$this->alias = "cat" . $this->id;
		}
		$this->alias = OutputFilter::stringURLSafe($this->alias);
		return true;
	}
}

