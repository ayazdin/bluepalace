<?php
/**
 * Page for showing the child theme creation form. (In the Theme > Child Theme submenu.)
 *
 */
?>
<div class="wrap">
    <div id="col-left">
            <div class="col-wrap">
            
                <h2><?php esc_html_e('Create a Child Theme','ct-child-theme') ?></h2>
            
                <p class="copy"><?php printf( __( 'Easily create a child theme based on <strong>%s</strong> by filling out this form. This saves you time later when updates are released you don\'t have to worry about overwritting your customizations.', 'contempo' ), $parent_theme_name ); ?></p>
                
                <p class="copy"><?php printf( __( 'Once you\'ve created your child theme you can modify the CSS via Appearance > Editor. You can also do more advanced customizations, more on that <a href="http://wp.contempographicdesign.com/wp-real-estate-7/documentation/#childthemes" target="_blank">here</a>.', 'contempo' ), $parent_theme_name ); ?>
                
            <?php
            if ( !empty( $error ) ) :
            ?>
                <div class="error"><?php echo esc_html($error); ?></div>
            <?php
            endif;
            ?>
    
            <div class="form-wrap">
                <form action="<?php echo admin_url( 'themes.php?page=ct-child-theme-page' ); ?>" method="post" id="create_child_form">
                    <div class="form-field">
                        <label>
                            <?php esc_html_e( 'Give your theme a name:', 'ct-child-theme' ) ?>
                            <input type="text" name="theme_name" value="<?php echo esc_html($theme_name); ?>" />
                        </label>
                    </div>
                    <div class="form-field">
                        <label>
                            <?php esc_html_e( 'Describe your theme:', 'ct-child-theme' ) ?><br />
                            <textarea name="description" value="<?php echo esc_html($description); ?>" rows="5" cols="40"/></textarea>
                        </label>
                    </div>
                    <div class="form-field">
                        <label>
                            <?php esc_html_e( 'Your Name:', 'ct-child-theme' ) ?>
                            <input type="text" name="author_name" value="<?php echo esc_html($author); ?>" />
                        </label>
                    </div>
                    <p class="submit">
                        <input type="submit" class="button-primary" value="<?php esc_html_e( 'Create Child', 'contempo' ); ?>" />
                    </p>
                </form>
            </div>
            
        </div>
    </div>
</div>

