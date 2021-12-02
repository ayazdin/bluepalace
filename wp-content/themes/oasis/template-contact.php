<?php
/**
 * Template Name: Contact
 *
 * @package Royal Oasis
 * @subpackage Template
 */

global $ct_options;

$inside_page_title = get_post_meta($post->ID, "_ct_inner_page_title", true);

$ct_contact_multiple_locations = isset( $ct_options['ct_contact_multiple_locations'] ) ? esc_attr( $ct_options['ct_contact_multiple_locations'] ) : '';
$ct_subject = isset( $ct_options['ct_contact_subject'] ) ? esc_attr( $ct_options['ct_contact_subject'] ) : '';
$ct_email = isset( $ct_options['ct_contact_email'] ) ? esc_attr( $ct_options['ct_contact_email'] ) : '';

get_header();

if(isset($_POST['submit']))
{
    $email=$_POST['emailadd'];
    $name=$_POST['fullname'];
    $phone=$_POST['phonenumber'];
    $youremail=$_POST['ctyouremail'];
    $subject=$_POST['messagesubject'];
    $message=$_POST['messagebody'];

    $to = $youremail;
    $subject = $subject;
    $msg = "$message" . "\n\n" .
        "Phone: $phone" . "\n" .
        "Email: $email" . "\n";
    $headers = "From:" . $name ."<" . $email . ">" . "\r\n";
    $headers .= "Reply-To:" . $email . "\r\n";
    //$headers = "Bcc: someone@domain.com" . "\r\n";
    $headers = "X-Mailer: PHP/" . phpversion();
    if(mail ($to, $subject, $msg, "From: $name <$email>"))
        $successMsg = '<h5 style="color:green;">Message sent successfully</h5>';
}
?>
    <!-- Page Content-->
    <main class="page-content">
        <section class="bg-gray-lighter">
            <div class="shell text-left">
                <?php echo ct_breadcrumbs();?>
            </div>
        </section>
        <section class="section-top-70 section-bottom-80">
            <div class="shell text-md-left">
                <div class="range">
                    <div class="cell-md-7">
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
                        <form id="formcontact"  method="post" action="" class="offset-top-40  text-left formular">
                            <div class="range range-xs-middle">
                                <div class="cell-lg-2">
                                    <p class="text-base">Name*</p>
                                </div>
                                <div class="cell-lg-10 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="contact-name" class="form-label">Enter name</label>
                                        <input id="contact-name" type="text" name="fullname" id="name" required  class=" form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="range range-xs-middle offset-top-20">
                                <div class="cell-lg-2">
                                    <p class="text-base">E-mail*</p>
                                </div>
                                <div class="cell-lg-10 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="contact-email" class="form-label">Enter e-mail</label>
                                        <input id="contact-email" type="email" name="emailadd" id="emailadd" required class=" form-control ">
                                    </div>
                                </div>
                            </div>
                            <div class="range range-xs-middle offset-top-20">
                                <div class="cell-lg-2">
                                    <p class="text-base">Phone</p>
                                </div>
                                <div class="cell-lg-10 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="contact-phone" class="form-label">Enter phone</label>
                                        <input id="contact-phone" type="text" name="phonenumber" id="phone" required  class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="range range-xs-middle offset-top-20">
                                <div class="cell-lg-2">
                                    <p class="text-base">Subject*</p>
                                </div>
                                <div class="cell-lg-10 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="contact-phone" class="form-label">Subject</label>
                                        <input id="contact-phone" type="text" name="messagesubject" id="messagesubject" required class=" form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="range offset-top-20">
                                <div class="cell-lg-2 text-lg-nowrap">
                                    <p class="text-base">Message*</p>
                                </div>
                                <div class="cell-lg-10 offset-top-7 offset-lg-top-0">
                                    <div class="form-group">
                                        <label for="contact-message" class="form-label">Message</label>
                                        <textarea id="contact-message" name="messagebody" id="messagebody" required  class=" form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="ctyouremail" name="ctyouremail" value="<?php echo esc_attr($ct_email); ?>" />
                            <div class="range offset-top-20 text-center text-sm-left">
                                <div class="cell-lg-5 cell-lg-preffix-2">
                                    <input type="submit" name="submit" value="<?php esc_html_e('Submit','contempo'); ?>" id="submit" class="btn btn-primary" />

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="cell-md-5">
                        <div class="well well-rudo">
                            <h3>Contact Details:</h3>
                            <p>Royal Oasis Real Estate Brokers</p>
                            <ul>
                                <li>
                                    <div class="con-left">Tel :</div>
                                    <div class="con-right">(971) 4 399 8470</div>
                                </li>
                                <li>
                                    <div class="con-left">Fax :</div>
                                    <div class="con-right">(971) 4 368 6286</div>
                                </li>
                                <li>
                                    <div class="con-left">Address :</div>
                                    <div class="con-right">
                                        P.O Box 49729 <br>
                                        Business Bay,<br>
                                        Churchill Tower Office, 602<br>
                                        Dubai, United Arab Emirates
                                    </div>
                                </li>
                                <li>
                                    <div class="con-left">Email:</div>
                                    <div class="con-right"><a href="mailto:info@royaloasis.co.ae">info@royaloasis.co.ae</a></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
get_footer();?>