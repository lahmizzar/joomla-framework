<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Image
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Image\Filter;

defined('JPATH_PLATFORM') or die;

use Joomla\Image\Filter;
use InvalidArgumentException;

/**
 * Image Filter class adjust the brightness of an image.
 *
 * @package     Joomla.Platform
 * @subpackage  Image
 * @since       11.3
 */
class Brightness extends Filter
{
	/**
	 * Method to apply a filter to an image resource.
	 *
	 * @param   array  $options  An array of options for the filter.
	 *
	 * @return  void
	 *
	 * @since   11.3
	 * @throws  InvalidArgumentException
	 */
	public function execute(array $options = array())
	{
		// Validate that the brightness value exists and is an integer.
		if (!isset($options[IMG_FILTER_BRIGHTNESS]) || !is_int($options[IMG_FILTER_BRIGHTNESS]))
		{
			throw new InvalidArgumentException('No valid brightness value was given.  Expected integer.');
		}

		// Perform the brightness filter.
		imagefilter($this->handle, IMG_FILTER_BRIGHTNESS, $options[IMG_FILTER_BRIGHTNESS]);
	}
}
