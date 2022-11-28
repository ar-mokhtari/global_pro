codnitive.wallet = function(/*stateData, title*/) 
{
    /*this.stateData   = stateData || {};
    this.title       = title     || '';*/
    
    this._init = function()
    {
        this.walletPaymentSelectionListener();
        this.walletCreditChangeListener();
    };

    this.walletPaymentSelectionListener = function ()
    {
        var wallet = this;
        $('#checkout_payment_methods').on('click', '.payment-method .radio', function () {
            var payment = $(this);
            if (payment.hasClass('payment-method-wallet')) {
                wallet.showWalletTotal();
            }
            else {
                wallet.hideWalletTotal();
            }
        });
    };

    this.walletCreditChangeListener = function ()
    {
        var wallet = this;
        $('#checkout_payment_methods').on('keyup', '#wallet_credit_to_use', function () {
            var creditField = $(this);
            wallet.updateTotals(wallet.getWalletTotal());
        });
    };

    this.showWalletTotal = function ()
    {
        this.updateTotals(this.getWalletTotal());
        $('.used-credit-total').removeClass('hidden');
        $('.grand-total').removeClass('hidden');
    };

    this.hideWalletTotal = function() 
    {
        $('.grand-total-price').text(this.formatRial(this.getGrandTotal()));
        $('.used-credit-total').addClass('hidden');
        // $('.grand-total').addClass('hidden');
    };

    this.updateTotals = function(creditToUse)
    {
        var grandTotalValue = this.getGrandTotal();
        var payableAmount   = grandTotalValue - creditToUse;
        $('.credit-total-price').text(this.formatRial(parseFloat(creditToUse)));
        $('.grand-total-price').text(this.formatRial(payableAmount));
    };

    this.getGrandTotal = function()
    {
        return parseFloat($('#grand_total_value').val().toEnglishDigits());
    };

    this.getWalletTotal = function()
    {
        var value = parseFloat($('#wallet_credit_to_use').val().toEnglishDigits());
        var grandTotalValue = this.getGrandTotal();
        if (value > grandTotalValue) {
            value = grandTotalValue;
        }
        return isNaN(value) ? 0 : value
    };

    this.formatRial = function(price)
    {
        return codnitive.formatRial(price);
        // return price.format(0, 3, ',', '.') + 'ریال';
    };
}
