<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class UAMController extends JController
{
	/**
	 * Custom Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Method to display the view
	 * @access public
	 */
	public function display() {
		JRequest::setVar( 'view', 'uam');
		parent::display();
	}
}
?>
