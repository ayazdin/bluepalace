<?php
/**
 * Template Name: Career
 *
 * @package    WP Pro Real Estate 7
 * @subpackage Template
 */
global $ct_options;
        $ct_email = isset( $ct_options['ct_contact_email'] ) ? esc_attr( $ct_options['ct_contact_email'] ) : '';
get_header();
if (isset($_POST['Submit'])) {

    if ( ! function_exists( 'wp_handle_upload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    $secretKey = "6LfZ-icUAAAAABDifhce-yQnfaOqme5fLQdWqwwK";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
    $responseKeys = json_decode($response , TRUE);
    $errMsg;
    if(intval($responseKeys["success"]) !== 1) {
        $errMsg = '<h5 style="color:red;">Captcha is required</h5>';
    }
    else{
        $first_name     =   $_POST['first_name'];
        $last_name      =   $_POST['last_name'];
        $areaofstudy    =   $_POST['areaofstudy'];
        $phone_number   =   $_POST['phone_number'];
        $your_email     =   $_POST['email_id'];
        $address        =   $_POST['address'];
        $workexperience =   $_POST['workexperience'];
        $highesteducation = $_POST['highesteducation'];
        $graduationyear =   $_POST['graduationyear'];
        $aboutyourself  =   $_POST['aboutyourself'];

        $adminemail     =   $ct_email;
        //$adminemail     =   'binaya619@gmail.com';

        $uploadedfile       = $_FILES['filepc'];
        $upload_overrides   = array( 'test_form' => false );
        $movefile           = wp_handle_upload( $uploadedfile, $upload_overrides );
            $subject = "Career in Blue Palace";
            $msg = '<table>
                            <tr><td>Full Name :</td><td>'.$first_name.' '.$last_name.'</td></tr>
                            <tr><td>Area of Study :</td><td>'.$areaofstudy.'</td></tr>
                            <tr><td>Phone Number :</td><td>'.$phone_number.'</td></tr>
                            <tr><td>Email Address :</td><td>'.$your_email.'</td></tr>
                            <tr><td>Address :</td><td>'.$address.'</td></tr>
                            <tr><td>Work Experience :</td><td>'.$workexperience.'</td></tr>
                            <tr><td>Highest Education :</td><td>'.$highesteducation.'</td></tr>
                            <tr><td>H. S Graduation year :</td><td>'.$graduationyear.'</td></tr>
                            <tr><td>About '.$first_name.' '.$last_name.' :</td><td>'.$aboutyourself.'</td></tr>
                        </table>';
        
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "From:" . $first_name .' '.$last_name . "<" . $your_email . ">" . "\r\n";
            $headers[] = "Reply-To:" . $adminemail . "\r\n";



        if( $movefile ) {
            
            $attachments = $movefile[ 'file' ];
            wp_mail($adminemail, $subject, $msg, $headers, $attachments);
            $successMsg = '<h5 style="color:green;">Sent successfully</h5>';
        }
        else {
      
             wp_mail($adminemail, $subject, $msg, $headers);
            $successMsg = '<h5 style="color:green;">Sent successfully</h5>';

        }
    }

}
do_action('before_single_listing_header');
// Header
echo '<header id="title-header"';
if ($ct_listing_single_layout == 'listings-two') {
    echo 'class="marB0"';
}
echo '>';
echo '<div class="container">';
//    echo '<div class="left">';
//    echo '<h5 class="marT0 marB0">';
//    esc_html_e('List Your Property' , 'contempo');
//    echo '</h5>';
//    echo '</div>';
echo ct_breadcrumbs();
echo '<div class="clear"></div>';
echo '</div>';
echo '</header>';

do_action('before_single_listing_content'); ?>
    <style>
        .selectbox{  margin-bottom: 16px;}
    </style>
    <!-- Container -->
    <div class="container marT60 padB60">
        <!-- Page Content -->
        <div class="content col span_12">
            <h3 class=" pagetitle"><?php the_title();?></h3>
            <!-- Inner Content -->
            <div class="col span_12 first">
                <?php if ($errMsg) {
                    echo $errMsg;
                }
                if ($successMsg) {
                    echo $successMsg;
                }

                ?>
                <form method="post" enctype="multipart/form-data">

                    <div class="form-inline">
                        <div class="col span_6">
                            <input name="first_name" type="text" class="listTl" id="first_name" placeholder="First Name"
                                   required>
                        </div>
                        <div class="col span_6">
                            <input name="last_name" type="text" class="listLN" id="last_name" placeholder="Last Name">
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form-inline">
                        <div class="col span_4">
                            <input name="phone_number" type="text" class="listTl" id="first_name"
                                   placeholder="Phone Number" required>
                        </div>
                        <div class="col span_4">
                            <input name="email_id" type="email" class="listLN" id="last_name"
                                   placeholder="Email Address" required>
                        </div>
                        <div class="col span_4">
                            <input name="address" type="text" class="listTl" id="first_name" placeholder="Address">
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form-inline">
                        <div class="col span_3 selectbox">
                            <select name="areaofstudy" id="areaofstudy" class="">
                                <option selected="selected">Area of Study</option>
                                <option>Information Techonoloy</option>
                                <option>Marketing</option>
                                <option>Sales</option>
                                <option>Finance</option>
                                <option>Web Marketing</option>
                            </select>
                        </div>

                        <div class="col span_3 selectbox">
                            <select name="workexperience" id="workexperience">
                                <option value="">Work Experience</option>
                                <option value="Fresher">Fresher</option>
                                <option value="2+yr">2+yr</option>
                                <option value="5+yr">5+yr</option>
                            </select>
                        </div>
                        <div class="col span_3 selectbox" >
                            <select name="highesteducation" id="highesteducation">
                                <option value="">Highest Education</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Graduate">Graduate</option>
                                <option value="Masters in Business">Masters in Business</option>
                            </select>
                        </div>
                        <div class="col span_3 selectbox">
                            <select name="graduationyear" id="graduationyear">
                                <option value="">H.S Graduation Year</option>
                                <option value="2000">2000</option>
                                <option value="2001">2001</option>
                                <option value="2002">2002</option>
                                <option value="2003">2003</option>
                                <option value="2004">2004</option>
                                <option value="2005">2005</option>
                                <option value="2006">2006</option>
                                <option value="2007">2007</option>
                                <option value="2008">2008</option>
                                <option value="2009">2009</option>
                                <option value="2010">2010</option>
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                            </select>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form-inline">
                        <div class="col span_12">
                            <textarea class=" text-input" name="aboutyourself" id="aboutyourself" rows="5" cols="10"
                                      placeholder="<?php esc_html_e('Write about yourself', 'contempo'); ?>"
                                      required></textarea>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form-inline">
                        <div class="col span_2">Post your C.V :</div>
                        <div class="col span_8">
                            <input name="filepc" type="file" id="filepc" class="listPN"/>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="form-inline">
                        <div class="g-recaptcha" data-sitekey="6LfZ-icUAAAAAHBB-Dzcr4W_qfUGuq0ovqodXCTb"></div>
                    </div>
                    <div class="form-inline">
                        <input type="submit" name="<?php esc_html_e('Submit', 'contempo'); ?>"
                               value="<?php esc_html_e('Submit', 'contempo'); ?>" id="submit" class="btn"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
get_footer();
?>