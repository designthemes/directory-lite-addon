<?php

// Price HTML Generator
if(!function_exists('dtdr_generate_price_html')) {
	function dtdr_generate_price_html($listing_id) {

		$dtdr_currency_symbol = get_post_meta($listing_id, 'dtdr_currency_symbol', true);
		$dtdr_currency_symbol_position = get_post_meta($listing_id, 'dtdr_currency_symbol_position', true);

		$currency_symbol = dtdr_option('price','currency-symbol');
		$currency_symbol_position = dtdr_option('price','currency-symbol-position');

		if($dtdr_currency_symbol == '') {
			$dtdr_currency_symbol = $currency_symbol;
		}

		if($dtdr_currency_symbol_position == '') {
			$dtdr_currency_symbol_position = $currency_symbol_position;
		}

		$_regular_price = get_post_meta($listing_id, '_regular_price', true);
		$_sale_price = get_post_meta($listing_id, '_sale_price', true);

		if($dtdr_currency_symbol != '') {
			$dtdr_currency_symbol = '<span class="dtdr-price-currency-symbol">'.$dtdr_currency_symbol.'</span>';
		}

		$_regular_price_label = $_sale_price_label = '';

		if($dtdr_currency_symbol_position == 'right_space') {
			if($_regular_price != '') {
				$_regular_price_label = '<del><span class="dtdr-price-amount">'.$_regular_price.' '.$dtdr_currency_symbol.'</span></del>';
			}
			if($_sale_price != '') {
				$_sale_price_label = '<ins><span class="dtdr-price-amount">'.$_sale_price.' '.$dtdr_currency_symbol.'</span></ins>';
			}
		} else if($dtdr_currency_symbol_position == 'left_space') {
			if($_regular_price != '') {
				$_regular_price_label = '<del><span class="dtdr-price-amount">'.$dtdr_currency_symbol.' '.$_regular_price.'</span></del>';
			}
			if($_sale_price != '') {
				$_sale_price_label = '<ins><span class="dtdr-price-amount">'.$dtdr_currency_symbol.' '.$_sale_price.'</span></ins>';
			}
		} else if($dtdr_currency_symbol_position == 'right') {
			if($_regular_price != '') {
				$_regular_price_label = '<del><span class="dtdr-price-amount">'.$_regular_price.$dtdr_currency_symbol.'</span></del>';
			}
			if($_sale_price != '') {
				$_sale_price_label = '<ins><span class="dtdr-price-amount">'.$_sale_price.$dtdr_currency_symbol.'</span></ins>';
			}
		} else {
			if($_regular_price != '') {
				$_regular_price_label = '<del><span class="dtdr-price-amount">'.$dtdr_currency_symbol.$_regular_price.'</span></del>';
			}
			if($_sale_price != '') {
				$_sale_price_label = '<ins><span class="dtdr-price-amount">'.$dtdr_currency_symbol.$_sale_price.'</span></ins>';
			}
		}

		$output = array (
			'regular_price' => $_regular_price_label,
			'sale_price' => $_sale_price_label
		);

		return $output;

	}
}

?>