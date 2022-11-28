<?php
use app\modules\Codnitive\Core\helpers\Tools;
$billingInfo = $cart->billingInfo;
?>

<div class="panel-heading">
    <h4 class="panel-title">
        <a  data-toggle="collapse"
            data-parent="#accordion"
            href="#collapseFour"
            style="display: block;">
                Payment Information
        </a>
    </h4>
</div>
<div id="collapseFour" class="panel-collapse collapse">
    <div class="panel-body">
        <fieldset>
            <legend>What method would you like to pay with today?</legend>
            <input type="hidden" value="cc_record" name="Checkout[payment_method]"/>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="card-holder-name">Name on Card</label>
                <div class="col-sm-9">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="name-on-card" 
                        name="Checkout[cc_record][card_holder]"
                        placeholder="Card Holder's Name"
                    >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="card-number">Card
                    Number</label>
                <div class="col-sm-9">
                    <input type="text" 
                        class="form-control" 
                        name=Checkout[cc_record][card_number] 
                        id="card-number" 
                        placeholder="Debit/Credit Card Number">
                    <br/>
                    <div><img class="pull-right" src="https://s3.amazonaws.com/hiresnetwork/imgs/cc.png" style="max-width: 250px; padding-bottom: 20px;">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="expiry-month">Expiration
                        Date</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-xs-3">
                                <select class="form-control col-sm-2" 
                                    name=Checkout[cc_record][expiry_month] 
                                    id="card-exp-month" 
                                    style="margin-left:5px;"
                                >
                                        <option value="">Month</option>
                                        <option value="01">Jan (01)</option>
                                        <option value="02">Feb (02)</option>
                                        <option value="03">Mar (03)</option>
                                        <option value="04">Apr (04)</option>
                                        <option value="05">May (05)</option>
                                        <option value="06">June (06)</option>
                                        <option value="07">July (07)</option>
                                        <option value="08">Aug (08)</option>
                                        <option value="09">Sep (09)</option>
                                        <option value="10">Oct (10)</option>
                                        <option value="11">Nov (11)</option>
                                        <option value="12">Dec (12)</option>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <select class="form-control" 
                                    name=Checkout[cc_record][expiry_year]  
                                    id="card-exp-year"
                                >
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="cvv">Card CVC</label>
                    <div class="col-sm-3">
                        <input type="text" 
                            class="form-control" 
                            name=Checkout[cc_record][cvv] 
                            id="card-cvc" 
                            placeholder="Security Code"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                    </div>
                </div>
            </div>
        </fieldset>
        <button type="submit" class="btn btn-success btn-lg" style="width:100%;">
            Pay Now
        </button>
        <br/>
        <div style="text-align: left;"><br/> By submiting this order you are agreeing to our <a href="/legal/billing/">universal
                billing agreement</a>, and <a href="/legal/terms/">terms of service</a>. If you have any questions about our products or services please contact us before placing this order.
        </div>
    </div>
</div>
