;(function( $, w ){
    $(document).ready(function(){
        
        var wcptp = function( $form ) {
            this.$form                	= $form;
            this.$template 				= wp.template( 'wcptp-total-price-template' );
            this.$price_wrapper 		= $('.wcptp-total-price');
            this.product_totalPrice 	= null;
            this.current_product 		= 0;
            
            $form.on( 'input.price_total', '[name="quantity"]', 	{wcptp: this}, this.onChange );
            $form.on( 'click', '.quantity .plus,.quantity .minus', 	function(){
                setTimeout(function(){
                    $form.find( '[name="quantity"]' ).trigger('input.price_total');
                },100)
            } );
        };
        wcptp.prototype.priceCalculator = function( event ){
            this.product_totalPrice = this.qty * wcptp_data.price;
        }

        wcptp.prototype.updatePrice_html = function ( event ) {
            var wcptp = this,
                $template_html = '';
            if ( wcptp.product_totalPrice != null ) {
                try {
                    $template_html = wcptp.$template( {
                        price:   	wcptp.product_totalPrice.formatMoney(
                                        wcptp_data.precision,
                                        wcptp_data.decimal_separator,
                                        wcptp_data.thousand_separator
                                    ),
                        currency: 	wcptp_data.currency_symbol
                    } );
                } catch (err) {
                    $template_html = '<p style="color:red;">Something is not right with your price-total.php template.</p>';
                }
                $template_html = $template_html.replace( '/*<![CDATA[*/', '' );
                $template_html = $template_html.replace( '/*]]>*/', '' );
                wcptp.$price_wrapper.html( $template_html );
            }
            
        };
        
        wcptp.prototype.onChange =  function( event ) {
            event.data.wcptp.qty = this.value;
            event.data.wcptp.priceCalculator();
            event.data.wcptp.updatePrice_html();
        }
        
        $(function() {
            if ( typeof wcptp_data !== 'undefined' ) {
                $( '.woocommerce div.product form.cart' ).each( function() {
                    $( this ).wcptp();
                });
            }
        });

        $.fn.wcptp = function() {
            new wcptp( this );
            return this;
        };

        Number.prototype.formatMoney = function( precision, decimalSeparator, thousandSeparator ){
            
            var total = this, 
                precision = isNaN( precision = Math.abs( precision ) ) ? 2 : precision, 
                decimalSeparator = decimalSeparator == undefined ? "." : decimalSeparator, 
                thousandSeparator = thousandSeparator == undefined ? "," : thousandSeparator, 
                negetiveSign = total < 0 ? "-" : "", 
                intPart = parseInt( total = Math.abs(+total || 0).toFixed( precision )) + "", 
                thousandSeparatorPosition = (thousandSeparatorPosition = intPart.length) > 3 ? thousandSeparatorPosition % 3 : 0;
                console.log(total, intPart, thousandSeparatorPosition);
                return negetiveSign + (thousandSeparatorPosition ? intPart.substr(0, thousandSeparatorPosition) + thousandSeparator : "") + intPart.substr( thousandSeparatorPosition ).replace(/(\d{3})(?=\d)/g, "$1" + thousandSeparator) + ( precision ? decimalSeparator + Math.abs(total - intPart).toFixed( precision ).slice(2) : "");
            };
        
    });
}(jQuery, window));
