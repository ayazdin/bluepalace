<div class="col-sm-8">
    <?php
        global $ct_options;
        $ct_email = isset( $ct_options['ct_contact_email'] ) ? esc_attr( $ct_options['ct_contact_email'] ) : ''; ?>
    <form method="post" enctype="multipart/form-data">
        <div class="form-inline">
            <select name="title" class="listTl" id="title">
                <option value="Mr." selected="selected">Mr.</option>
                <option value="Ms.">Ms.</option>
            </select>
            <input name="first_name" type="text" class="listFN" id="first_name" placeholder="First Name" required>
            <input name="last_name" type="text" class="listLN" id="last_name" placeholder="Last Name">
        </div>
        <div style="clear: both;"></div>
        <div class="form-inline">
            <input name="phone_number" type="text" class="listPN" id="phone_number" placeholder="Phone Number" required>
            <input name="your_email" id="your_email" type="text" class="listEN" placeholder="Email" required>
        </div>
        <div style="clear: both;"></div>
        <div class="form-inline">
            <select name="look_to" class="listCt" id="look_to">
                <option selected="selected">Looking To</option>
                <option value="Sell">Sell</option>
                <option value="Lease">Lease</option>
                <option value="Manage">Manage</option>
            </select>
            <select name="Property_Type" id="Property_Type" class="listFN">
                <option selected="selected">Property Type</option>
                <option value="Apartment">Apartment</option>
                <option value="Building">Building</option>
                <option value="Full Floor">Full Floor</option>
                <option value="Hotel">Hotel</option>
                <option value="Hotel Apartment">Hotel Apartment</option>
                <option value="Labour Camp">Labour Camp</option>
                <option value="Office">Office</option>
                <option value="Plots">Plots</option>
                <option value="Retail">Retail</option>
                <option value="Shop">Shop</option>
                <option value="Showroom">Showroom</option>
                <option value="Townhouse">Townhouse</option>
                <option value="Villa">Villa</option>
                <option value="Warehouse">Warehouse</option>
            </select>
            <select name="city" class="listSN" id="city">
                <option selected="selected">City</option>
                <option value="Abu Dhabi">Abu Dhabi</option>
                <option value="Ajman">Ajman</option>
                <option value="Al Ain">Al Ain</option>
                <option value="Dubai">Dubai</option>
                <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                <option value="Sharjah">Sharjah</option>
                <option value="Umm Al Quwain">Umm Al Quwain</option>
            </select>
        </div>

        <div style="clear: both;"></div>
        <br>
        <div class="form-inline">

            <input name="project" type="text" class="listSN" id="project" placeholder="project">
            <input name="sub-project" type="text" class="listSN" id="sub-project" placeholder="sub-project">
            <input name="building" type="text" class="listSN" id="building" placeholder="Building">


        </div>
        <div style="clear: both;"></div>
        <div class="form-inline">
            <input name="unitno" type="text" class="listSN" id="unitno" value="Unit No.">

            <select name="bedroom" id="bedroom" class="listSN">
                <option selected="selected">Bedroom</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7+">7+</option>
            </select>
            <select name="furnish" class="listSN" id="furnish">
                <option selected="selected">Furnished</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div style="clear: both;"></div>
        <div class="form-inline">
            <input name="size" type="text" class="listTl" id="size" placeholder="Size">
            <select name="sizem" class="listTl" id="sizem">
                <option value="Sq.Ft." selected="selected">Sq.Ft.</option>
                <option value="Sq.Mt.">Sq.Mt.</option>
            </select>
            <input name="view" type="text" class="listWN" id="view" placeholder="View (lake view, sea...)">

            <select name="bathroom" class="listWN">
                <option selected="selected">Bathroom</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5+">5+</option>
            </select>
            <select name="parking" class="listWN" id="parking">
                <option selected="selected">Reserved Parking</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4+">4+</option>
            </select>
        </div>

        <div style="clear: both;"></div>

        <div class="form-inline">
            <input name="Budget" type="text" class="listEN" id="Budget" placeholder="Price Range (in AED / From - To)">
            <select name="prmode" class="listPN" id="prmode">
                <option selected="selected">Prefered mode to contact</option>
                <option value="Phone">Phone</option>
                <option value="Email">Email</option>
            </select>
        </div>
        <input name="filepc" type="file" id="filepc" class="listPN"/>
        <input name="filepc1" type="file" id="filepc1" class="listPN"/>
        <input name="filepc2" type="file" id="filepc2" class="listPN"/>
        <input name="filepc3" type="file" id="filepc3" class="listPN"/>
        <input name="filepc4" type="file" id="filepc4" class="listPN"/>
        <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($ct_email); ?>" />
        <div class="g-recaptcha" data-sitekey="6LfZ-icUAAAAAHBB-Dzcr4W_qfUGuq0ovqodXCTb"></div>
        <input type="submit" name="submit">
    </form>
</div>

<style type="text/css">
    .form-inline {
        display: block;
    }

    .form-inline input, select {
        display: inline-block;
    }

    .listTl {
        width: 10% !important;
    }

    .listFN, .listLN {
        width: 44% !important;
    }

    .listPN {
        width: 40% !important;
    }

    .listSN {
        width: 32.5% !important;
    }

    .listWN {
        width: 25.5% !important;
    }
    .listEN{
        width: 58% !important;
    }
</style>