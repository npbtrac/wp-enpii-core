<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/1/17 1:44 PM
 */

namespace Enpii\WpEnpiiCore;

class Common {

	/**
	 * Fulfill a link with http or https
	 * @param string $link to be fulfilled
	 * @param boolean $https using https or not in the result
	 *
	 * @return string complete url with protcal
	 */
	public static function fulfill_link($link, $https = false)
	{
		$link = strtolower($link);
		$link = !$link || substr($link, 0, 7) == 'http://' || substr($link, 0,
			8) == 'https://' ? $link : $https ? 'https' : 'http' . '://' . $link;

		return $link;
	}

	/**
	 * Get option from ACF option, with WPML supported
	 *
	 * @param string $name
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function get_option($name, $default = null)
	{
		if (get_field($name, 'option')) {
			return get_field($name, 'option');
		} else if (defined('ICL_LANGUAGE_CODE') && get_field($name . '_' . ICL_LANGUAGE_CODE, 'option')) {
			return get_field($name . '_' . ICL_LANGUAGE_CODE, 'option');
		} else {
			return $default;
		}
	}

	/**
	 * Get option value from a data given
	 *
	 * @param string $name name of the option to get
	 * @param mixed $data data given for getting option
	 * @param null $default default value
	 *
	 * @return null
	 */
	public static function get_option_data($name, $data, $default = null)
	{
		if (!empty($data[$name])) {
			return $data[$name];
		} else if (defined('ICL_LANGUAGE_CODE') && !empty($data[$name . '_' . ICL_LANGUAGE_CODE])) {
			return $data[$name . '_' . ICL_LANGUAGE_CODE];
		} else {
			return $default;
		}
	}

	/**
	 * Get a substring from beginning to a position without space, tab ...
	 * @param $str
	 * @param $end
	 * @param $replace
	 *
	 * @return bool|string
	 */
	public static function get_substring($str, $end, $replace)
	{
		if (strlen($str) > $end) {
			$str = substr($str, 0, $end);
			return preg_replace('/\W\w+\s*(\W*)$/', '$1', $str) . $replace;
		}
		return $str;
	}

	/**
	 * Convert a date time from GMT time zone to another
	 *
	 * @param $time_zone
	 * @param null $format
	 * @param null $date_time
	 *
	 * @return string
	 */
	public static function convert_time_zone($time_zone, $format = null, $date_time = null)
	{
		date_default_timezone_set('Europe/London');
		if (empty($format)) {
			$format = 'Y-m-d H:i:s';
		}
		if (empty($date_time)) {
			$date_time = date($format);
		}
		$obj_date_time = new \DateTime($date_time);
		$obj_date_time->format($format);
		$la_time = new \DateTimeZone($time_zone);
		$obj_date_time->setTimezone($la_time);
		return $obj_date_time->format($format);
	}
}