codnitive.adminWallet = function() 
{
    this._init = function()
    {
        this.getUserCredit();
    };

    this.getUserCredit = function ()
    {
        $('#wallet_form').on('change', '#user_id', function () {
            var userFld = $(this);
            bilit.ajax(codnitive.getBaseUrl() + 'admin/wallet/ajax/getCredit', {id: userFld.val()});
        });
    };
}
