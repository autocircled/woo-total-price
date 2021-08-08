<?php
/**
 * @version 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<script type="text/template" id="tmpl-wcptp-total-price-template">
	<?php
		$price_label = '<span class="price-label">' . __( 'Total Price:', 'wc-total-price' ) . '</span>';
		$price_format = get_woocommerce_price_format();
		$currency_html = '<span class="currency woocommerce-Price-currencySymbol">{{{ data.currency }}}</span>';
		$price_html = '<span class="amount">{{{ data.price }}}</span>';
		ob_start();
		?>
		<p class="price product-final-price">
			<span class="woocommerce-Price-amount amount">
				<?php echo $price_label; ?>
				<?php echo sprintf( $price_format, $currency_html, $price_html ); ?>
			</span>
		</p>
		<?php 
		echo apply_filters( 'wcptp_price_html', ob_get_clean(), $price_format, $currency_html, $price_html );
	?>
</script>