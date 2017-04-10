<?php
/**
 * @Library - teweb library
 * @author Paul Kosciecha http://www.truthengaged.org.uk
 * @copyright Copyright (C) Paul Kosciecha
 * @license GNU/GPL
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class Tewebadminjs
{

/**
     * Method to get javascript for selector lists to highlight all when all selected
     *
     * $param string $select id for the all/choose select switch
     * $param string $selector id for the list
     *
     * @return    string
     */
     
function selectorjs($select, $selector)
{
$js = "
        window.addEvent('domready', function(){
            var filter0 = $('".$select."0');
            if (!filter0) return;
            filter0.addEvent('click', function(){
                $('".$selector."').setProperty('disabled', 'disabled');
                $$('#".$selector." option').each(function(el) {
                    el.setProperty('selected', 'selected');
                });
            })
            
            $('".$select."1').addEvent('click', function(){
                $('".$selector."').removeProperty('disabled');
                $$('#".$selector." option').each(function(el) {
                    el.removeProperty('selected');
                });

            })
            
            if ($('".$select."0').checked) {
                $('".$selector."').setProperty('disabled', 'disabled');
                $$('#".$selector." option').each(function(el) {
                    el.setProperty('selected', 'selected');
                });
            }
            
            if ($('".$select."1').checked) {
                $('".$selector."').removeProperty('disabled');
            }
            
        });
        ";
return $js;
}

}
