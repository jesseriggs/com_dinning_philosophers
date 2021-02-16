<?php
/**
 * @package     Joomla.site
 * @subpackage  com_dinning_philosophers
 *
 * @copyright   Copyright (C) 2021 Jesse Riggs. All rights reserved.
 * @license     GNU General Public License version 2 or later;see LICENSE.txt
 */

defined('_JEXEC') or die('restricted access');

use \Joomla\CMS\MVC\View\HtmlView;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;

class Dinning_philosophersViewDinning_philosophers extends HtmlView
{

    protected $item;
    
    protected $params;
    
    protected $state;
    
    public function display($tpl = null){
        $author = 'administrator';
        $description = '';
        
        $this->item  = $this->get('Item');
        $this->state = $this->get('State');
        
        $this->params = $this->state->get('params');
        
        if(!isset($app)){
            $app = Factory::getApplication();
        }

        $item = $this->item;
        if(isset($item)){
            if ($app->get('MetaAuthor') == '1')
            {
                $author = $item->created_by_alias ?: $author;
            }
            
            if(isset($item->metadesc))
            {
                $description = $item->metadesc;
            }
        }
        
        $this->document->setDescription($description);
        $this->document->setMetaData('author', $author, 'name');
        $this->document->addScript(Uri::root(true).
            "/media/com_dinning_philosophers/js/dinning_philosophers.js");
        parent::display($tpl);
    }
}
