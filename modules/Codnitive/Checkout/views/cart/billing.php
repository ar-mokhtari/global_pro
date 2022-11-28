<?php
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Template\assets\Location;
Location::register($this);
$billingInfo = $cart->billingInfo;
?>

<div class="panel-heading">
    <h4 class="panel-title">
        <a  data-toggle="collapse"
            data-parent="#accordion"
            href="#collapseTwo"
            onclick="$('#collapseTwo').slideToggle('200', 'linear');"
            style="display: block;">
                Contact and Billing Information
        </a>
    </h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse">
    <div class="panel-body">
        <table class="table table-striped" style="font-weight: bold;vertical-align: middle">
            <tr>
                <td style="width: 175px;">
                    <label class="required" for="email">Email:</label>
                </td>
                <td>
                    <input  class="form-control"
                            id="email"
                            value="<?= $billingInfo['email'] ?>"
                            name="Checkout[billing][email]"
                            required="required"
                            type="email"
                            placeholder="Enter an active email"
                    />
                </td>
            </tr>
            <tr>
                <td style="width: 175px;">
                    <label class="required" for="fullname">Name:</label></td>
                <td>
                    <input  class="form-control"
                            id="fullname"
                            value="<?= $billingInfo['fullname'] ?>"
                            name="Checkout[billing][fullname]"
                            required="required"
                            type="text"
                            placeholder="Enter your full name"
                    />
                </td>
            </tr>
            <tr>
                <td style="width: 175px;">
                    <label class="required" for="address">Address:</label></td>
                <td>
                    <input  class="form-control"
                            id="address"
                            value="<?= $billingInfo['address'] ?>"
                            name="Checkout[billing][address]"
                            required="required"
                            type="text"
                            placeholder="Enter street address"
                    />
                </td>
            </tr>
            <tr>
                <td style="width: 175px;">
                    <label class="required" for="location">Location:</label></td>
                <td>
                    <input  class="form-control"
                            id="location"
                            value="<?= $billingInfo['location'] ?>"
                            name="Checkout[billing][location]"
                            required="required"
                            type="text"
                    />
                    <script type="text/javascript">
                        $(document).ready(function() {
                            codnitive.location.geolocate();
                            codnitive.location.initAutocomplete('location');
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td style="width: 175px;">
                    <label for="zipcode">Zip Code:</label></td>
                <td>
                    <input  class="form-control"
                            id="zipcode"
                            value="<?= $billingInfo['zipcode'] ?>"
                            name="Checkout[billing][zipcode]"
                            type="number"
                            placeholder="Enter address zip code"
                            min="0"
                    />
                </td>
            </tr>
            <tr>
                <td style="width: 175px;">
                    <label for="phone">Phone:</label></td>
                <td>
                    <input  class="form-control"
                            id="phone"
                            value="<?= $billingInfo['phone'] ?>"
                            name="Checkout[billing][phone]"
                            type="tel"
                            placeholder="Enter your phone number"
                    />
                </td>
            </tr>

        </table>
    </div>
    <div class="panel-heading">
        <h4 class="panel-title" style="text-align: center; width:100%;">
            <a  style="width:100%; color: #fff"
                data-toggle="collapse"
                class="btn btn-success billing-submit">
                    Continue to Payment Information »
            </a>
        </h4>
    </div>
</div>
