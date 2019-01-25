<?php

if (! function_exists('only_numbers')) {
	/**
	 * Remove mask from string number
	 * @param string $number
	 * @return string
	 */
	function only_numbers ($number = '') {
		return preg_replace('/[^0-9]/', '', $number);
	}
}

if (! function_exists('get_route_method')) {
	/**
	 * Get de action name route
	 * @param string $routeName
	 * @return string
	 */
	function get_route_method ($routeName) {
		$action = explode('.',$routeName);
		return $action[1];
	}
}

if (! function_exists('get_action_page')) {
	/**
	 * Get action for title of page
	 * @param string $routeName
	 * @return string
	 */
	function get_action_page($routeName){
		$action = explode('.',$routeName);
		return ( $action[1] === 'create' ? 'Adicionar' : 'Atualizar' );
	}
}

if (! function_exists('convertDate')) {
  function convertDate($strDate, $format = '') {
    if ( is_null($strDate) ) {
      return null;
    }
    $date = str_replace('/', '-', $strDate);
    $carbon = new Carbon\Carbon($date);
    if (!empty($format)) {
      return $carbon->format($format);
    }
    return $carbon->toDateTimeString();
  }
}