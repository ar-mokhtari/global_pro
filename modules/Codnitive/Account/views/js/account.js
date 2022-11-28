var account = {
    init: function()
    {
        this.viewOrderListener();
    },

    viewOrderListener: function() 
    {
        $('.orders-grid').on('click', '.view-order-details', function () {
            bilit.addGridDetailRow($(this), 'order_details', 'account/sales/getOrderDetails');
        })
    },
}

$(document).ready(function() {
    codnitive.changePerPage();
    account.init();
});
