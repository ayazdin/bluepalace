<?php
function location_importer()
{
    add_menu_page('Location Import', 'Location Import', 'manage_options', 'locationImport', 'locationImport');
}

add_action('admin_menu', 'location_importer');


function locationImport()
{
    echo '<h1>Import Location</h1>';

    if (isset($_POST['btnSubmit'])) {

        global $wpdb;

        $table_name = $wpdb->prefix . "location";
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            city text NOT NULL,
            community text NOT NULL,
            sub_community text NOT NULL,
            building text NOT NULL,
            PRIMARY KEY  (id)
	    ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        require_once 'Classes/PHPExcel.php';

        include 'Classes/PHPExcel/IOFactory.php';

        $file = $_FILES['excelfile']['tmp_name'];
        //echo $filename = $_FILES['excelfile']['name'];
        //$handle = fopen($file, "r");

        if ($file == NULL) {
            echo 'Please select a file to import';

        }
        else {
            try {
                $objPHPExcel = PHPExcel_IOFactory::load($file);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $arrayCount = count($allDataInSheet);
            for ($i = 2; $i <= $arrayCount; $i++) {
                $city = trim($allDataInSheet[$i]["A"]);
                $community = trim($allDataInSheet[$i]["B"]);
                $sub_community = trim($allDataInSheet[$i]["C"]);
                $building = trim($allDataInSheet[$i]["D"]);

                $wpdb->insert(
                    $table_name,
                    array(
                        'city' => $city,
                        'community' => $community,
                        'sub_community' => $sub_community,
                        'building' => $building,
                    )
                );

            }//for loop

            echo 'success';
        }
    }

    if (isset($_POST['downloadbutt'])) {
        $allargs = array(
            'posts_per_page' => -1,
            'post_type' => 'listings'
        );

        $the_query = new WP_Query($allargs);
        if ($the_query->have_posts()) { //if loop
            error_reporting(E_ALL);
            ini_set('display_errors', TRUE);
            ini_set('display_startup_errors', TRUE);

            define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

            date_default_timezone_set('Europe/London');

            /** Include PHPExcel */
            require_once 'Classes/PHPExcel.php';

            /** PHPExcel_Writer_Excel2007 */
            //include 'PHPExcel/Writer/Excel2007.php';

            $objPHPExcel = new PHPExcel();
            // Set document properties
            $objPHPExcel->getProperties()->setCreator("Blue Palace Realestate")
                ->setLastModifiedBy("Blue Palace Realestate")
                ->setTitle("Blue Palace Realestate")
                ->setSubject("Blue Palace Realestate")
                ->setDescription("Blue Palace Realestate")
                ->setKeywords("Blue Palace Realestate")
                ->setCategory("Blue Palace Realestate");

            $objPHPExcel->getActiveSheet()->setCellValue('A1', "REF : NO");
            $objPHPExcel->getActiveSheet()->setCellValue('B1', "Purpose");
            $objPHPExcel->getActiveSheet()->setCellValue('C1', "Location");
            $objPHPExcel->getActiveSheet()->setCellValue('D1', "Community");
            $objPHPExcel->getActiveSheet()->setCellValue('E1', "Building");
            $objPHPExcel->getActiveSheet()->setCellValue('F1', "Type");
            $objPHPExcel->getActiveSheet()->setCellValue('G1', "Bedroom");
            $objPHPExcel->getActiveSheet()->setCellValue('H1', "Unit");
            $objPHPExcel->getActiveSheet()->setCellValue('I1', "Street/Floor");
            $objPHPExcel->getActiveSheet()->setCellValue('J1', "Area");
            $objPHPExcel->getActiveSheet()->setCellValue('K1', "Net Price");
            $objPHPExcel->getActiveSheet()->setCellValue('L1', "NP/sqft");
            $objPHPExcel->getActiveSheet()->setCellValue('M1', "View");
            $objPHPExcel->getActiveSheet()->setCellValue('N1', "Commision/Transfer");
            $objPHPExcel->getActiveSheet()->setCellValue('O1', "Updated Date");
            $objPHPExcel->getActiveSheet()->setCellValue('P1', "Landlord");
            $objPHPExcel->getActiveSheet()->setCellValue('Q1', "Landlord Mobile");
            $objPHPExcel->getActiveSheet()->setCellValue('R1', "Landlord Landline");
            $objPHPExcel->getActiveSheet()->setCellValue('S1', "Landlord Email");
            $objPHPExcel->getActiveSheet()->setCellValue('T1', "Agent");
            $objPHPExcel->getActiveSheet()->setCellValue('U1', "Status");
            $objPHPExcel->getActiveSheet()->setCellValue('V1', "Images");

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("20");

            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");

            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("20");

            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("12");

            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("25");

            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth("40");

            $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(false);
            $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth("40");

            //while loop start
            $i = 2;
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $post_id = get_the_ID();

                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A' . $i, get_post_meta($post_id, "_ct_reference", true))
                    ->setCellValue('B' . $i, get_post_meta($post_id, "_ct_purpose", true))
                    ->setCellValue('C' . $i, strip_tags(get_the_term_list($post_id, 'state', '', ', ', '')))
                    ->setCellValue('D' . $i, strip_tags(get_the_term_list($post_id, 'community', '', ', ', '')))
                    ->setCellValue('E' . $i, get_post_meta($post_id, "_ct_building", true))
                    ->setCellValue('F' . $i, strip_tags(get_the_term_list($post_id, 'property_type', '', ', ', '')))
                    ->setCellValue('G' . $i, strip_tags(get_the_term_list($post_id, 'beds', '', ', ', '')))
                    ->setCellValue('H' . $i, '')
                    ->setCellValue('I' . $i, get_post_meta($post_id, "_ct_floorimages", true))
                    ->setCellValue('J' . $i, get_post_meta($post_id, "_ct_sqft", true))
                    ->setCellValue('K' . $i, get_post_meta($post_id, "_ct_price", true))
                    ->setCellValue('L' . $i, '')
                    ->setCellValue('M' . $i, get_post_meta($post_id, "_ct_view", true))
                    ->setCellValue('N' . $i, '')
                    ->setCellValue('O' . $i, '')
                    ->setCellValue('P' . $i, get_post_meta($post_id, "_ct_landlord", true))
                    ->setCellValue('Q' . $i, '')
                    ->setCellValue('R' . $i, '')
                    ->setCellValue('S' . $i, '')
                    ->setCellValue('T' . $i, strip_tags(get_the_term_list($post_id, 'agents', '', ', ', '')))
                    ->setCellValue('U' . $i, strip_tags(get_the_term_list($post_id, 'ct_status', '', ', ', '')))
                    ->setCellValue('V' . $i, '');

                $i++;
            }

            //while loop end


            wp_reset_postdata();
            $objPHPExcel->setActiveSheetIndex(0);
            $up = wp_upload_dir();
            // Save Excel 95 file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save(str_replace(__FILE__, $up['basedir'] . '/export/bluepalace_listings.xls', __FILE__));

            $objOutput = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
            ob_start();
            $objOutput->save('php://output');
            $excelOutput = ob_get_clean();

            exit();
            //$file = 'bluepalace_listings.xls';


        }//if loop

    }
    ?>
    <div class="excelforms">
        <form action="" enctype="multipart/form-data" method="post" name="locationImportForm">
            <lbael>
                Upload Excel File
            </lbael>
            <br>
            <input type="file" name="excelfile" value="">
            <br>

            <input type="submit" name="btnSubmit" value="Upload">
            <!--<input type="submit" name="downloadbutt" value="Download">-->
        </form>
    </div>
<?php }