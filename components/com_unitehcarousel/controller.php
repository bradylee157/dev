<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;


class UniteHCarouselController extends JController
{
	
	/**
	 * show some image
	 */
	public function showimage(){
		
		UniteFunctionJoomlaHCar::showImageFromRequest();
		exit();
	}
	
	
	/**
	 * 
	 * get css of some slider
	 */
	public function getcss(){
		
		$output = new UniteHCarOutput();
		$output->outputCss();
		
		exit();
	}
	
	
	/**
	 * 
	 * default display function
	 */
	public function display(){
		echo "nothing here";
		exit();
	}
	
}