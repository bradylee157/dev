<?php
/** @version $Id: .htusers.php 135 2009-01-27 21:57:15Z ryu_ms $ */
/** ensure this file is being included by a parent file */
if( !defined( '_JEXEC' ) && !defined( '_VALID_MOS' ) ) die( 'Restricted access' );

$GLOBALS["users"]=array(
	array("admin","3b8ccc86e0d1ca75be0d10d289e7936d",empty($_SERVER['DOCUMENT_ROOT'])?realpath(dirname(__FILE__).'/..'):$_SERVER['DOCUMENT_ROOT'],"http://localhost",1,"",7,1),
); ?>
