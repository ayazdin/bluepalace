<?php
/**
 * Template Name: List Your Property
 *
 * @package Royal Oasis
 * @subpackage Template
 */
global $ct_options;
$ct_email = isset( $ct_options['ct_contact_email'] ) ? esc_attr( $ct_options['ct_contact_email'] ) : '';
get_header();
?>
<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    $secretKey = "6LfZ-icUAAAAABDifhce-yQnfaOqme5fLQdWqwwK";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
    $responseKeys = json_decode($response , TRUE);
    $errMsg;
    //print_r($responseKeys);die();
    if(intval($responseKeys['success']!=1)){
        $successMsg = '<h5 style="color:red;">Please fill the required field. Captcha is required</h5>';
    }
    else
    {
        $title = $_POST['title'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $phone_number = $_POST['phone_number'];
        $your_email = $_POST['your_email'];
        $look_to = $_POST['look_to'];
        $Property_Type = $_POST['Property_Type'];
        $city = $_POST['city'];
        $project = $_POST['project'];
        $sub_project = $_POST['sub-project'];
        $building = $_POST['building'];
        $unitno = $_POST['unitno'];
        $bedroom = $_POST['bedroom'];
        $furnish = $_POST['furnish'];
        $size = $_POST['size'];
        $sizem = $_POST['sizem'];
        $view = $_POST['view'];
        $bathroom = $_POST['bathroom'];
        $parking = $_POST['parking'];
        $Budget = $_POST['Budget'];
        $prmode = $_POST['prmode'];
        $ctyouremail=$_POST['ctyouremail'];
        $to = $ctyouremail;
        if ((!empty($_FILES['filepc']['name']))) {

            $mime_boundary = "==Multipart_Boundary_x" . md5(mt_rand()) . "x";
            $mime_boundary1 = "==Multipart_Boundary_x" . md5(mt_rand()) . "x";
            $tmp_name = $_FILES['filepc']['tmp_name'];
            $tmp_name1 = $_FILES['filepc1']['tmp_name'];
            $tmp_name2 = $_FILES['filepc2']['tmp_name'];
            $tmp_name3 = $_FILES['filepc3']['tmp_name'];
            $tmp_name4 = $_FILES['filepc4']['tmp_name'];

            $type = $_FILES['filepc']['type'];
            $type1= $_FILES['filepc1']['type'];
            $type2 = $_FILES['filepc']['type'];
            $type3 = $_FILES['filepc']['type'];
            $type4 = $_FILES['filepc']['type'];

            $file_name = $_FILES['filepc']['name'];
            $file_name1 = $_FILES['filepc1']['name'];
            $file_name2 = $_FILES['filepc2']['name'];
            $file_name3 = $_FILES['filepc3']['name'];
            $file_name4 = $_FILES['filepc4']['name'];

            $size = $_FILES['filepc']['size'];
            $size1 = $_FILES['filepc1']['size'];
            $size2 = $_FILES['filepc2']['size'];
            $size3 = $_FILES['filepc3']['size'];
            $size4 = $_FILES['filepc4']['size'];

            // Check to make sure that it is an uploaded file and not a system file
            if (is_uploaded_file($tmp_name)) {
                // Now Open the file for a binary read
                $file = fopen($tmp_name , 'rb');
                // Now read the file content into a variable
                $data = fread($file , filesize($tmp_name));
                // close the file
                fclose($file);
                // Now we need to encode it and split it into acceptable length lines
                $data = chunk_split(base64_encode($data));
            }
            if (is_uploaded_file($tmp_name1)) {
                // Now Open the file for a binary read
                $file1 = fopen($tmp_name1 , 'rb');
                // Now read the file content into a variable
                $data1 = fread($file1 , filesize($tmp_name1));
                // close the file
                fclose($file1);
                // Now we need to encode it and split it into acceptable length lines
                $data1 = chunk_split(base64_encode($data1));
            }
            if (is_uploaded_file($tmp_name2)) {
                // Now Open the file for a binary read
                $file2 = fopen($tmp_name2 , 'rb');
                // Now read the file content into a variable
                $data2 = fread($file2 , filesize($tmp_name2));
                // close the file
                fclose($file2);
                // Now we need to encode it and split it into acceptable length lines
                $data2 = chunk_split(base64_encode($data2));
            }
            if (is_uploaded_file($tmp_name3)) {
                // Now Open the file for a binary read
                $file3 = fopen($tmp_name3 , 'rb');
                // Now read the file content into a variable
                $data3 = fread($file3 , filesize($tmp_name3));
                // close the file
                fclose($file3);
                // Now we need to encode it and split it into acceptable length lines
                $data3 = chunk_split(base64_encode($data3));
            }
            if (is_uploaded_file($tmp_name44)) {
                // Now Open the file for a binary read
                $file4 = fopen($tmp_name4 , 'rb');
                // Now read the file content into a variable
                $data4 = fread($file4 , filesize($tmp_name4));
                // close the file
                fclose($file4);
                // Now we need to encode it and split it into acceptable length lines
                $data4 = chunk_split(base64_encode($data4));
            }

            $mybody = "This is a multi-part message in MIME format.\n\n" .
                "--{$mime_boundary}\n" .
                "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" .
                $mybody . "\n\n";

            $headers = "From: $from\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-Type: multipart/mixed;\r\n" .
                " boundary=\"{$mime_boundary}\"";

            $mybody .=  "\n\n" .
                "Title: $title" . "<br/>" .
                "First name: $first_name" . "<br/>" .
                "Last name: $last_name" . "<br/>" .
                "Phone: $phone_number" . "<br/>" .
                "Email: $your_email" . "<br/>" .
                "Look to: $look_to" . "<br/>" .
                "Property type: $Property_Type" . "<br/>" .
                "City: $city" . "<br/>" .
                "Project: $project" . "<br/>" .
                "Sub project: $sub_project" . "<br/>" .
                "Building: $building" . "<br/>" .
                "Unit no.: $unitno" . "<br/>" .
                "Bedroom: $bedroom" . "<br/>" .
                "Furnish: $furnish" . "<br/>" .
                "Size: $size" . "<br/>" .
                "Sizem: $sizem" . "<br/>" .
                "View: $view" . "<br/>" .
                "Bathroom: $bathroom" . "<br/>" .
                "Parking: $parking" . "<br/>" .
                "Budget: $Budget" . "<br/>";
            if((!empty($_FILES['filepc']['name']))) {
                $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                    "Content-Type: {$type};\n" .
                    " name=\"{$file_name}\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data . "\n\n";
            }if((!empty($_FILES['filepc1']['name']))) {
                $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                    "Content-Type: {$type1};\n" .
                    " name=\"{$file_name1}\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data1 . "\n\n";
            }if((!empty($_FILES['filepc2']['name']))) {
                $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                    "Content-Type: {$type2};\n" .
                    " name=\"{$file_name2}\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data2 . "\n\n";
            }if((!empty($_FILES['filepc3']['name']))) {
                $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                    "Content-Type: {$type3};\n" .
                    " name=\"{$file_name3}\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data3 . "\n\n";
            }if((!empty($_FILES['filepc4']['name']))) {
                $mybody .= "Prefered mode to contact: $prmode" . "\r\n" . "--{$mime_boundary}\n" .
                    "Content-Type: {$type4};\n" .
                    " name=\"{$file_name4}\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" .
                    $data4 . "\n\n";
            }

            $bodys .=   $mybody;

            $subject = "Attachment";
            $body =  $body . $bodys;
            if(mail($to , $subject , $body , $headers))
                $successMsg = '<h5 style="color:green;">Message sent successfully</h5>';
        } else {
            $to = $ctyouremail;

            //    $subject = $subject;
            $subject = "from website";
            $msg = "\n\n" .
                "Title: $title" . "\n" .
                "First name: $first_name" . "\n" .
                "Last name: $last_name" . "\n" .
                "Phone: $phone_number" . "\n" .
                "Email: $your_email" . "\n" .
                "Look to: $look_to" . "\n" .
                "Property type: $Property_Type" . "\n" .
                "City: $city" . "\n" .
                "Project: $project" . "\n" .
                "Sub project: $sub_project" . "\n" .
                "Building: $building" . "\n" .
                "Unit no.: $unitno" . "\n" .
                "Bedroom: $bedroom" . "\n" .
                "Furnish: $furnish" . "\n" .
                "Size: $size" . "\n" .
                "Sizem: $sizem" . "\n" .
                "View: $view" . "\n" .
                "Bathroom: $bathroom" . "\n" .
                "Parking: $parking" . "\n" .
                "Budget: $Budget" . "\n" .

                "Prefered mode to contact: $prmode" . "\n";
            $headers = "From:" . $your_email . " < " . $email . ">" . "\r\n";
            $headers .= "Reply - To:" . $ct_email . "\r\n";
            //$headers .= "Content-Disposition: attachment; filename=\"" . $attachments . "\"\r\n\r\n";
            //$headers = "Bcc: someone@domain . com" . "\r\n";

            if(mail($to , $subject , $msg ,$headers))
            $successMsg = '<h5 style="color:green;">Message sent successfully</h5>';
        }
    }

}
?>

    <main class="page-content">
        <section class="bg-gray-lighter">
            <div class="shell text-left">
                <?php echo ct_breadcrumbs();?>
            </div>
        </section>
        <section class="section-top-70 section-bottom-80">
            <div class="shell text-md-left">
                <div class="range">
                    <div class="cell-md-8">
                        <?php if($inside_page_title == "Yes") {?>
                            <h3><?php the_title();?></h3>
                        <?php  } ?>
                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php the_content(); ?>

                        <?php endwhile; ?>
                        <hr>
                        <?php if ($successMsg) {
                            echo $successMsg;
                        }
                        ?>
                        <!-- RD Mailform-->
                        <form  enctype="multipart/form-data" method="post" action="" class="offset-top-40 text-left">


                            <div class="range range-xs-middle ">

                                <div class="cell-lg-2 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select data-placeholder="Choose" name="title" id="title"   class="form-control select-filter">
                                            <option value="Mr." selected>Mr.</option>
                                            <option value="Ms.">Ms.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="cell-lg-5 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="first_name" class="form-label">First name</label>
                                        <input id="first_name" type="text" name="first_name" required class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-5 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input id="last_name" type="text" name="last_name" required class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="range range-xs-middle offset-top-10">


                                <div class="cell-lg-6 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input id="phone_number" type="text" name="phone_number" required class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-6 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="your_email" class="form-label">Email Id</label>
                                        <input id="your_email" type="email" name="your_email" required class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="range range-xs-middle offset-top-10">

                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="look_to" id="look_to"  class="form-control select-filter">
                                            <option selected="selected">Looking To</option>
                                            <option value="Sell">Sell</option>
                                            <option value="Lease">Lease</option>
                                            <option value="Manage">Manage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="Property_Type" id="Property_Type"  class="form-control select-filter">
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
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="city" id="city"  class="form-control select-filter">
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
                                </div>
                            </div>

                            <div class="range range-xs-middle offset-top-10">
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="project" class="form-label">Project</label>
                                        <input id="project" type="text" name="project" class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="sub-project" class="form-label">Sub Project</label>
                                        <input id="sub-project" type="text" name="sub-project"  class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="building" class="form-label">Building</label>
                                        <input id="building" type="text" name="building" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="range range-xs-middle offset-top-10">
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="unitno" class="form-label">Unit No.</label>
                                        <input id="unitno" type="text" name="unitno" class="form-control">
                                    </div>
                                </div>

                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="bedroom" id="bedroom"  class="form-control select-filter">
                                            <option selected="selected">Bedroom</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7+">7+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="furnish" id="furnish"  class="form-control select-filter">
                                            <option selected="selected">Furnished</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="range range-xs-middle offset-top-10">
                                <div class="cell-lg-2 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="size" class="form-label">Size.</label>
                                        <input id="size" type="text" name="size" class="form-control">
                                    </div>
                                </div>

                                <div class="cell-lg-2 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="sizem" id="sizem"  class="form-control select-filter">
                                            <option value="Sq.Ft." selected="selected">Sq.Ft.</option>
                                            <option value="Sq.Mt.">Sq.Mt.</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="cell-lg-3 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="view" class="form-label">View (lake view, sea...).</label>
                                        <input id="view" type="text" name="view" class="form-control">
                                    </div>
                                </div>

                                <div class="cell-lg-3 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="bathroom" id="bathroom"  class="form-control select-filter">
                                            <option selected="selected">Bathroom</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5+">5+</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="cell-lg-2 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select  name="parking" id="parking"  class="form-control select-filter">
                                            <option selected="selected">Reserved Parking</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4+">4+</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="range range-xs-middle offset-top-10">
                                <div class="cell-lg-6 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="Budget" class="form-label">Price Range (in AED / From - To)</label>
                                        <input id="Budget" type="text" name="Budget" required class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-6 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <select name="prmode" id="prmode"  class="form-control select-filter">
                                            <option selected="selected">Prefered mode to contact</option>
                                            <option value="Phone">Phone</option>
                                            <option value="Email">Email</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="range range-xs-middle offset-top-10">
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <input id="filepc" type="file" name="filepc" class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <input id="filepc1" type="file" name="filepc1" class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <input id="filepc2" type="file" name="filepc2" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="range range-xs-middle offset-top-10">
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <input id="filepc3" type="file" name="filepc3" class="form-control">
                                    </div>
                                </div>
                                <div class="cell-lg-4 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <input id="filepc4" type="file" name="filepc4" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($ct_email); ?>" />

                            <div class="range range-xs-middle offset-top-10">
                                <div class="cell-lg-5">
                                    <div class="g-recaptcha" data-sitekey="6LfZ-icUAAAAAHBB-Dzcr4W_qfUGuq0ovqodXCTb"></div>
                                </div>
                            </div>

                            <div class="range offset-top-30 text-center text-sm-left">
                                <div class="cell-lg-5">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Submit">

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="cell-md-4">
                        <div class="well well-rudo">
                            <h3>Search for properties:</h3>
                            <?php get_template_part('includes/advanced-search'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php

get_footer();?>