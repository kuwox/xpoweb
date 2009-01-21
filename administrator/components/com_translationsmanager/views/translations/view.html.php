<?php
/**
* @version 1.5
* @package com_translationsmanager
* @author Ifan Evans
* @copyright Copyright (C) 2007 Ifan Evans. All rights reserved.
* @license GNU/GPL
* @bugs - please report to post@ffenest.co.uk
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import controller parent class
jimport( 'joomla.application.component.view' );

/**
* View class for the translationsmanager component
*
*/
class TranslationsViewTranslations extends JView
{

	/**
	* Writes credits for the component
	*/
	function credits () {
		?>
		<p class="copyright">
			<?php echo JText::_( 'Translation Manager By' ); ?> <a href="index.php?option=com_translationsmanager&task=credits">Ifan Evans [credits]</a> <br>
			<?php echo sprintf( JText::_('Translation Manager Donate'), 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=ifan%40rhiannon%2eco%2euk&item_name=Donate - Joomla Translation Manager - Thank You&no_shipping=2&no_note=1&tax=0&currency_code=GBP&lc=GB&bn=PP%2dDonationsBF&charset=UTF%2d8' ); ?>
		</p>
		<?php
	}

	function display()
	{
		// output the view
		parent::display();
		// output credits
		$this->credits();
	}

	/**
	* Lookup and return a tooltip, using JText
	*
	* The default behaviour when using JText is
	* 1: if $caption is not set, set it to match $html
	* 2: if $tip is not set, lookup a JText key in the format '$caption DESC' and use it ONLY IF DEFINED
	*
	* @param 	string 	The HTML over which the tooltip will appear
	* @param 	string 	The tooltip
	* @param 	string 	The tooltip caption
	* @param 	string  A string including characters H T C to trigger JText of Html Tip Caption
	* @return 	string 	The HTML output
	*/
	function getTooltip ( $html, $tip=null, $caption=null, $jtext = 'HTC' )
	{
        // behaviour flag
        $behavior = false;

        // prepare JText config
        $jtext = ' ' . strtoupper($jtext);

		// 1: lookup an Automatic JText tip and caption
		// 2: lookup an Automatic JText caption
		// 3: lookup JText $tip and $caption
		if ($jtext) {
			if (is_null($tip)) {
				$caption_key = ($caption) ? $caption : $html;
				$tip_key = $caption_key . ' DESC';
				$caption = strpos($jtext,'C') ? JText::_($caption_key) : $caption_key;
				$tip = strpos($jtext,'T') ? JText::_($tip_key) : $tip_key;
				$tip = ($tip==$tip_key) ? '' : $tip;
			} else if (is_null($caption)) {
				$caption = strpos($jtext,'C') ? JText::_($html) : $html;
			} else {
				$caption = strpos($jtext,'C') ? JText::_($caption) : $caption;
				$tip = strpos($jtext,'T') ? JText::_($tip) : $tip;
			}
			// lookup JText $html
			$html = strpos($jtext,'H') ? JText::_($html) : $html;
		}
		// add the tooltip to the html
		if (($tip) || ($caption!=$html)) {
			// apply title to tip
			if (!$tip) {
				$tip = $caption;
				$caption = '';
			}
			if (!$behavior) {
				JHTML::_('behavior.tooltip');
				$behavior = true;
			}
			// build tooltip span
			$html = '<span class="editlinktip hasTip" title="' . ( $caption ? htmlspecialchars($caption) . '::' : '' ) . htmlspecialchars($tip) . '">' . $html . '</span>';
		}
		// return
		return $html;
	}
}
?>
