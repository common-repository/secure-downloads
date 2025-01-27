<?php /**
 * @version 1.0
 * @package Secure Downloads 
 * @category Content of item Listing page
 * @author wpdevelop
 *
 * @web-site https://oplugins.com/
 * @email info@oplugins.com 
 * 
 * @modified 2015-11-13
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/** Show Content
 *  Update Content
 *  Define Slug
 *  Define where to show
 */
class OPSD_Page_Single extends OPSD_Page_Structure {
    
        
    public function in_page() {
        return 'opsd';
    }

    
    public function tabs() {
        
        $tabs = array();
        $tabs[ 'send' ] = array(
                              'title' => __('Send Link', 'secure-downloads')            // Title of TAB    
                            , 'hint' => __('Send Link', 'secure-downloads')                      // Hint    
                            , 'page_title' => __('Send Link', 'secure-downloads')                                // Title of Page    
                            , 'link' => ''                                      // Can be skiped,  then generated link based on Page and Tab tags. Or can  be extenral link
                            , 'position' => ''                                  // 'left'  ||  'right'  ||  ''
                            , 'css_classes' => ''                               // CSS class(es)
                            , 'icon' => ''                                      // Icon - link to the real PNG img
                            , 'font_icon' => 'glyphicon glyphicon-th'             // CSS definition  of forn Icon
                            , 'default' => true                                 // Is this tab activated by default or not: true || false. 
                            , 'disabled' => false                               // Is this tab disbaled: true || false. 
                            , 'hided'   => true                                 // Is this tab hided: true || false. 
                            , 'subtabs' => array()
            
        );        
        // $subtabs = array();                
        // $tabs[ 'items' ][ 'subtabs' ] = $subtabs;        
        return $tabs;        
    }


    public function content() {
                
        // Checking ////////////////////////////////////////////////////////////
        
        do_action( 'opsd_hook_settings_page_header', array( 'page' => $this->in_page() ) );					// Define Notices Section and show some static messages, if needed.
            
        // $this->settings_api();     // Init Settings API & Get Data from DB   // Define all fields and get values from DB
        
        
        // Submit  /////////////////////////////////////////////////////////////
        
        $submit_form_name = 'opsd_send_links_form';                             // Define form name
        
        $data_after_update = false;
        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {

            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
            $nonce_gen_time = check_admin_referer( 'opsd_settings_page_' . $submit_form_name  );  // Its stop show anything on submiting, if its not refear to the original page

            // Save Changes 
            $data_after_update = $this->update();                        
            $updated_data = '';//$data_after_update['original_validated_data'];
        } else {
            $updated_data = '';
        }
         
        //$opsd_user_role_master   = get_opsd_option( 'opsd_user_role_master' );    // O L D   W A Y:   Get Fields Data
                
        // JavaScript: Tooltips, Popover, Datepick (js & css) //////////////////
        echo '<span class="wpdevelop">';
        opsd_js_for_items_page();                                        
        echo '</span>';
		
        ?><span class="wpdevelop"><?php                                         // BS UI CSS Class              
        //   T o o l b a r s   /////////////////////////////////////////////////
        // opsd_items_toolbar();                                                
        ?></span><?php
     
        ?><div class="clear" style="height:0px;"></div><?php

        
        // Content  ////////////////////////////////////////////////////////////
        ?>
        <div class="clear" style="margin-bottom:10px;"></div>
        <span class="metabox-holder">
            <form  name="<?php echo $submit_form_name; ?>" id="<?php echo $submit_form_name; ?>" action="" method="post" >
                <?php 
                   // N o n c e   field, and key for checking   S u b m i t 
                   wp_nonce_field( 'opsd_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo $submit_form_name; ?>" id="is_form_sbmitted_<?php echo $submit_form_name; ?>" value="1" />
                
                <div class="clear" style="margin-bottom:0px;"></div>

                <div class="opsd_settings_row opsd_settings_row_left" >
                    
                    <?php opsd_open_meta_box_section( 'opsd_single_results', __('Send', 'secure-downloads') );  ?>
                    
                    <?php 

                    // Get List of products ////////////////////////////////////
                    $products_csv = get_opsd_option('opsd_products_csv' ); 

                    $products_obj = new OPSD_Products();

                    $products_obj->define_products_from_csv( $products_csv );   /** Array
                                                                                    (
                                                                                        [id] => 0
                                                                                        [order] => 0
                                                                                        [ip] => 0.0.0.0
                                                                                        [ipl] => 0
                                                                                        [expire] => +1440 seconds
                                                                                        [title] => Personal
                                                                                        [size] => 3.45
                                                                                        [path] => XXXXXXXXXX/wpbc/personal.zip
                                                                                    ), ...
                                                                                 */
                    
                    $products = $products_obj->get_products();
                    
                    //$secret_link = opsd_get_secret_link( $products[0] );      // Get Secret Link
                     
					// Warning - NO Products
					if ( $products_obj->get_products_count() == 0 ) {												
						
						$notice_id = 'opsd_warning_no_products';
						if ( ! opsd_section_is_dismissed( $notice_id ) ) {

							?><div  id="<?php echo $notice_id; ?>" 							           
									class="opsd_system_notice opsd_is_dismissible0 opsd_is_hideable0 notice-error opsd_internal_notice"
									data-nonce="<?php echo wp_create_nonce( $nonce_name = $notice_id . '_opsdnonce' ); ?>"	
									data-user-id="<?php echo get_current_user_id(); ?>"
								><?php 
							// opsd_x_dismiss_button();
							echo '<strong>' . __( 'Warning!', 'secure-downloads' ) . '</strong> ';
							printf( __( 'No products defined at %s menu page.', 'secure-downloads' )
									, '<a href="' . admin_url( 'admin.php?page=opsd-files' ) . '">' 
												. '<strong>' . 'Secure Downloads > ' . __( 'Files', 'secure-downloads' ) . '</strong>'
									. '</a>'							
							);			
							?></div><?php
						}
						
						$opsd_csv_separator = get_opsd_option( 'opsd_csv_separator' );
						if (   ( strlen( $products_csv ) > 0 ) 
							&& ( strpos( $products_csv, $opsd_csv_separator ) === false )  ) {
							
							
								$notice_id = 'opsd_warning_wrong_csv_separator';
								if ( ! opsd_section_is_dismissed( $notice_id ) ) {

									?><div  id="<?php echo $notice_id; ?>" 							           
											class="opsd_system_notice opsd_is_dismissible0 opsd_is_hideable0 notice-warning opsd_internal_notice"
											data-nonce="<?php echo wp_create_nonce( $nonce_name = $notice_id . '_opsdnonce' ); ?>"	
											data-user-id="<?php echo get_current_user_id(); ?>"
										><?php 
									// opsd_x_dismiss_button();
									echo '<strong>' . __( 'Warning!', 'secure-downloads' ) . '</strong> ';
									printf( __( 'Probabaly you have defined incorrect CSV separator at %s menu page.', 'secure-downloads' )
											, '<a href="' . admin_url( 'admin.php?page=opsd-settings' ) . '#opsd_general_settings_opsd_misc_metabox">' 
														. '<strong>' . __( 'Settings', 'secure-downloads' ) . '</strong>'
											. '</a>'							
									);			
									?></div><?php
								}
							
						}
						
						
					} else {

						if ( ! empty( $data_after_update ) ) {
							opsd_show_copy_button();
						}

						?><div class="opsd_link_container wpdevelop"><?php

							// Email  //////////////////////////////////////////////////
							$fields = array(  'type'              => 'email',
											  'title'             => ''
											, 'disabled'          => false
											, 'class'             => ''
											, 'css'               => ''
											, 'placeholder'       => 'info@server.com'
											, 'description'       => ''
											, 'attr'              => array()
											, 'group'             => 'general'
											, 'tr_class'          => ''
											, 'only_field'        => true
											, 'description_tag'   => 'p'
											, 'validate_as'       => array( 'email' )
											, 'value'             => ( ( ! empty( $_GET[ 'email' ] ) ) ? sanitize_email( $_GET[ 'email' ] ) :  '' )	//FixIn: 1.1.5
										);
							OPSD_Settings_API::field_text_row_static( 'opsd_email_to', $fields );

							// Send Button  ////////////////////////////////////////////
							?>
							<a class="button button-primary opsd_send_button opsd_generate_button"
							   href="javascript:void(0)"  title="<?php _e('Generate Secure Link for Download' , 'secure-downloads') ?>"
							><span class="opsd_text_hide_mobile"><?php _e('Generate' , 'secure-downloads') ?>&nbsp;&nbsp;</span><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></a>
						</div>
						<input type="hidden" value='' name='opsd_action'  id='opsd_action' />  
						<?php 



						// Products List  //////////////////////////////////////////
						$options = array( '' => __( 'Please Select', 'secure-downloads' ) );

						$is_group_open = false;					

						//FixIn: 1.1.5
						$selected_product_id =  ( ! empty( $_GET[ 'product_id' ] ) ) ? intval( $_GET[ 'product_id' ] ) :  0 ;

						$check_name = '';
						if ( ! empty( $_GET[ 'product_name' ] ) ) {
							$check_name = esc_js( $_GET[ 'product_name' ] );
						}

						foreach ( $products as $product_arr ) {

							//FixIn: 1.1.5
							if ( ( ! empty( $check_name ) ) && ( $product_arr['title'] == $check_name ) ) {             //FixIn: 1.1.3.2
								$selected_product_id = $product_arr['id'];
							}

							if ( count($product_arr) == 2 ) {	//Group

								if ( $is_group_open ) {
									$options[ intval( microtime( false ) ) + wp_rand(100) ] = array( 'optgroup' => true, 'title' =>'', 'close' => true ) ;		//FixIn: 1.1.2.3
								}

								$options[ intval( microtime( false ) ) + wp_rand(100) ] = array( 'optgroup' => true, 'title' => $product_arr['title'], 'close' => false ) ;	//FixIn: 1.1.2.3
								$is_group_open = true;	

							} else { // Regular option


								$options[ $product_arr['id'] ] = $product_arr['title'] . ' ~ ' . $product_arr['version_num'];
							}
						}   	

						//Close group,  if opened
						if ( $is_group_open ) {
							$options[ intval( microtime( false ) ) + wp_rand(100) ] = array(  'optgroup' => true, 'title' =>'', 'close' => true ) ;	//FixIn: 1.1.2.3
						}


						$fields = array(
											  'title'             => ''
											, 'label'             => ''
											, 'disabled'          => false
											, 'disabled_options'  => array()
											, 'class'             => 'opsd_product_selection'
											, 'css'               => ''
											, 'type'              => 'select'
											, 'description'       => ''
											, 'multiple'          => ! true
											, 'attr'              => array( 'size' => 1 )
											, 'options'           => $options 
											, 'group'             => 'general'
											, 'tr_class'          => ''
											, 'only_field'        => true
											, 'description_tag'   => 'span'
											, 'value' =>  ( ( ! empty( $selected_product_id ) ) ? intval( $selected_product_id ) :  1 )	//FixIn: 1.1.4	//FixIn: 1.1.5
									);
							OPSD_Settings_API::field_select_row_static( 'opsd_product_selection', $fields );                        
						
					}
					
					do_action( 'opsd_secure_links_send_section_footer' );
					
                    ?>
		

                    <?php opsd_close_meta_box_section(); ?>    
                    
                    <?php opsd_open_meta_box_section( 'opsd_single_help', __('Info', 'secure-downloads') );  ?>

                    <?php //$this->settings_api()->show( 'help' ); ?>
                        <div class="opsd_submmary">
                            <?php printf(__('Nothing yet.', 'secure-downloads'),'<code>[email]</code>') ?>
                        </div>
    
                    <?php opsd_close_meta_box_section(); ?>                    
                    
                </div>  
                <div class="opsd_settings_row opsd_settings_row_right">                    
                    
                    <?php opsd_open_meta_box_section( 'opsd_single_actions', __('Advanced', 'secure-downloads') );  ?>

                        <table class="form-table">
                            <tbody>                    
                                <tr>
                                    <td style="padding-left: 0;">
                                        
                                        
                                    </td>
                                    <td>
                                        <?php 
                                        
                                            $mail_api = new OPSD_Emails_API_LinkUser( OPSD_EMAIL_LINK_USER_ID );        

                                            $field_name = 'send_copy_to_admin';

                                            $field = array(
                                                              'title' => ''
                                                            , 'label' => __('Send copy to administrator', 'secure-downloads')
                                                            , 'type' => 'checkbox'
                                                            , 'value' => ( ( $mail_api->fields_values['copy_to_admin'] == 'On' ) ? 'On' : 'Off' )
                                                            , 'class' => ''
                                                            , 'css' => ''
                                                            , 'group' => 'advanced'
                                                            , 'only_field' => true
                                            );                        
                                            OPSD_Settings_API::field_checkbox_row_static( $field_name, $field );                        
                                        
                                        ?>
                                    </td>
                                </tr>    
                            <?php                         
                        
                            $options = array( 
                                          '' =>  __('Default Expiration', 'secure-downloads') 
                                        , '+5 minutes' => '5 ' . __('minutes', 'secure-downloads')     
                                        , '+15 minutes' => '15 ' . __('minutes', 'secure-downloads')     
                                        , '+30 minutes' => '30 ' . __('minutes', 'secure-downloads')     
                                        , '+45 minutes' => '45 ' . __('minutes', 'secure-downloads')     
                                        , '+1 hour' => '1 ' . __('hour', 'secure-downloads')     
                                        , '+6 hours' => '6 ' . __('hours', 'secure-downloads')     
                                        , '+12 hours' => '12 ' . __('hours', 'secure-downloads')     
                                        , '+24 hours' => '24 ' . __('hours', 'secure-downloads')     
                                        , '+3 days' => '3 ' . __('days', 'secure-downloads')     
                                        , '+5 days' => '5 ' . __('days', 'secure-downloads')     
                                        , '+7 days' => '7 ' . __('days', 'secure-downloads')     
                                        , '+30 days' => '30 ' . __('days', 'secure-downloads')     
                                        , '+90 days' => '90 ' . __('days', 'secure-downloads')     
                                        , '+365 days' => '1 ' . __('year', 'secure-downloads')                                             
                                        , '0' => __('Never', 'secure-downloads')						//FixIn: 1.2.2.2
                                );
                            // Expire
                            $fields = array(
                                              'title'             => __('Link expire after', 'secure-downloads') 
                                            , 'label'             => ''
                                            , 'disabled'          => false
                                            , 'disabled_options'  => array()
                                            , 'class'             => ''
                                            , 'css'               => ''
                                            , 'type'              => 'select'
                                            , 'description'       => ''
                                            , 'multiple'          => false
                                            , 'attr'              => array()
                                            , 'options'           => $options 
                                            , 'group'             => 'advanced'
                                            , 'tr_class'          => ''
                                            , 'only_field'        => false
                                            , 'description_tag'   => 'span'
                                            , 'value' => get_opsd_option( 'opsd_defualt_expiration' )                       //array( '+24 hours' )
                                    );
                            OPSD_Settings_API::field_select_row_static( 'opsd_product_expire', $fields );

                            
                            // IP lock
                            $fields = array(
                                              'title'             => __( 'IP Lock', 'secure-downloads') 
                                            , 'disabled'          => false
                                            , 'class'             => ''
                                            , 'css'               => 'width:100%;'
                                            , 'placeholder'       => '0.0.0.0'
                                            , 'description'       => ''
                                            , 'attr'              => array()
                                            , 'group'             => 'advanced'
                                            , 'tr_class'          => ''
                                            , 'only_field'        => false
                                            , 'description_tag'   => 'p'
                                            , 'validate_as'     => array()    
                                            , 'value' => get_opsd_option( 'opsd_defualt_iplock' )
                                        );
                            OPSD_Settings_API::field_text_row_static( 'opsd_product_ip_lock', $fields );

                            ?>
                            </tbody>
                        </table>                                       
                    
                    <?php opsd_close_meta_box_section(); ?>                    

                    
                </div>                
                <div class="clear"></div>
<!--                <input type="button" value="<?php _e('Send', 'secure-downloads'); ?>" class="button button-primary opsd_send_button" />  -->
<!--                <input type="submit" value="<?php _e('Submit', 'secure-downloads'); ?>" class="button button-primary opsd_submit_button" />-->
                
            </form>
            <?php 
                
                if ( ! empty( $data_after_update ) )
                    echo $data_after_update['sent_summary_content'];
            ?>            
        </span>
        <?php 

		opsd_show_opsd_footer();   
		
        $this->js();
        $this->css();
    
        do_action( 'opsd_hook_settings_page_footer', 'send_links' );    
    }


    public function update() {                   
        
        $post_action_key = 'opsd_action';
        if (  isset( $_POST[ $post_action_key ] )  && ( $_POST[ $post_action_key ] == 'go_send' )  ) {

			// Get Validated post
			$validated = array();

			// Email
			$validated['opsd_email_to'] = OPSD_Settings_API::validate_email_post_static( 'opsd_email_to' );

			// Is send copy to admin
			$validated['send_copy_to_admin'] = OPSD_Settings_API::validate_checkbox_post_static( 'send_copy_to_admin' );

			// Products
			$validated['opsd_product_selection'] = OPSD_Settings_API::validate_select_post_static( 'opsd_product_selection' );

			// Expire
			$validated['opsd_product_expire'] = OPSD_Settings_API::validate_select_post_static( 'opsd_product_expire' );

			// IP lock
			$validated['opsd_product_ip_lock'] = OPSD_Settings_API::validate_text_post_static( 'opsd_product_ip_lock' );

			// Check  if we selected custom email template and need to  send email  even if the product  was not selected
			$validated['continue_without_product'] = false;
			$validated = apply_filters( 'opsd_send_secure_links_validate_fields', $validated );            			//Hook for validated fields.


			$response = opsd_send_secure_download_email_to_user( $validated );	//FixIn: 1.1.3.2

//debuge($response);

        	$sent_summary_content = '';

			switch ( $response[ 'status' ] ) {

			    case 'error':

			    	if ( 'select_valid_product' == $response[ 'error_type' ] ) {

					    opsd_show_fixed_message( __( 'Select valid product', 'secure-downloads' ), 3, 'updated error' );                // Show Message
				    }
			        break;

			    case 'email_sent':

					// Get Summary about sending email and generating link ...
				    $sent_summary_content = $this->get_sent_summary( $response['mail_api'], $response['product_replace'], $validated );

			    	opsd_show_fixed_message ( __('Email sent to', 'secure-downloads') . ' ' . $validated['opsd_email_to'], 3 );        // Show Message
			        break;

				case 'link_generated':

					// Get Summary about sending email and generating link ...
				    $sent_summary_content = $this->get_sent_summary( $response['mail_api'], $response['product_replace'], $validated );

					opsd_show_fixed_message ( __('Link generated', 'secure-downloads'), 3 );                							// Show Message
					break;

			    default:
			       // Default
			}

 			// Reload page after sending.  Stop from sending once again,  if refresh browser in mobile browser after  some time
			?>
			<script type="text/javascript">
				setTimeout(function() { document.location.href = "<?php echo opsd_get_master_url(); ?>"; }, 30000);
			</script>
			<?php

            return array (   'validated_data' => $validated, 'sent_summary_content' => $sent_summary_content );                  // Exit, for do  not parse 
        }

        /*
        //$validated_fields = $this->settings_api()->validate_post();             // Get Validated Settings fields in $_POST request.
        
        //$validated_fields = apply_filters( 'opsd_settings_validate_fields_before_saving', $validated_fields );   //Hook for validated fields.

        // Skip saving specific option, for example in Demo mode.
        // unset($validated_fields['opsd_start_day_weeek']);

        //$this->settings_api()->save_to_db( $validated_fields );                 // Save fields to DB
        //opsd_show_changes_saved_message();
        //opsd_show_fixed_message ( __('Done', 'secure-downloads'), 0 );                        // Show Message
        
        // O L D   W A Y:   Saving Fields Data
        //      update_opsd_option( 'opsd_is_delete_if_deactive'
        //                       , OPSD_Settings_API::validate_checkbox_post('opsd_is_delete_if_deactive') );  
        //      ( (isset( $_POST['opsd_is_delete_if_deactive'] ))?'On':'Off') );
		*/
        return false;
    }


    public function get_sent_summary( $mail_api, $replace, $validated ) {
		
		if ( false === $mail_api ) {	// Email disabled
			$mail_api = new OPSD_Emails_API_LinkUser( OPSD_EMAIL_LINK_USER_ID );
		}
        
        // Parse for getting email content /////////////////////////////////
        $mail_api->set_replace( $replace );
        $content_email = $mail_api->get_content();
        $subject_email = $mail_api->get_subject();
        $mail_api->set_replace();                   // Reset Email

        $pos = strpos($content_email, '<body' );
        if ( $pos !== false ) {
            $pos = strpos($content_email, '>',  ++$pos );
            $content_email = substr($content_email, ++$pos );
        }
        ////////////////////////////////////////////////////////////////////
        
        ob_start();
        
        opsd_open_meta_box_section( 'opsd_sent_summary', __('Summary', 'secure-downloads') );
        
//debuge($validated,$replace);        
        ?><table class="form-table"><tbody><?php
        
            ?><tr><td colspan="2" style="padding-left: 0;font-size: 1.2em;border-bottom: 2px dashed #ddd;line-height: 1.8em;"><?php
                if ( ! empty ( $validated['opsd_email_to'] ) )
                    echo  __( 'Email have sent to', 'secure-downloads' ) . ' <strong>' . $validated['opsd_email_to'] . '</strong> - ';
                //echo ( $validated['send_copy_to_admin'] == 'On' ) ? ' [' . __('copy to administrator' , 'secure-downloads') . ']' : '';

				if (
					   ( isset( $replace[ 'product_summary' ] ) )
					&& ( isset( $replace[ 'product_expire_date' ] ) )
				)
					echo $replace['product_summary'] . ' <code>' . $replace['product_expire_date'] . '</code>';
            ?></td></tr><?php

                // Link
                $fields = array(
                                  'title'             => __( 'Link', 'secure-downloads') 
                                , 'disabled'          => false
                                , 'class'             => ''
                                , 'css'               => 'width:100%;'
                                , 'placeholder'       => ''
                                , 'description'       => ''
                                , 'attr'              => array()
                                , 'group'             => 'advanced'
                                , 'tr_class'          => 'opsd_tr_more_margin'
                                , 'only_field'        => false
                                , 'description_tag'   => 'p'
                                , 'validate_as'     => array() 
                                , 'value'           => ( isset( $replace[ 'product_link' ] ) ) ? $replace['product_link'] : ''
                            );
                OPSD_Settings_API::field_text_row_static( 'opsd_sent_summary_link', $fields );

                // email
                $fields = array(
                                  'title'             => __( 'To', 'secure-downloads') 
                                , 'disabled'          => false
                                , 'class'             => ''
                                , 'css'               => 'width:100%;'
                                , 'placeholder'       => ''
                                , 'description'       => ''
                                , 'attr'              => array()
                                , 'group'             => 'advanced'
                                , 'tr_class'          => ''
                                , 'only_field'        => false
                                , 'description_tag'   => 'p'
                                , 'validate_as'     => array() 
                                , 'value' => $validated['opsd_email_to']
                            );
                OPSD_Settings_API::field_text_row_static( 'opsd_sent_summary_email', $fields );

                // email
                $fields = array(
                                  'title'             => __( 'Subject', 'secure-downloads') 
                                , 'disabled'          => false
                                , 'class'             => ''
                                , 'css'               => 'width:100%;'
                                , 'placeholder'       => '0.0.0.0'
                                , 'description'       => ''
                                , 'attr'              => array()
                                , 'group'             => 'advanced'
                                , 'tr_class'          => ''
                                , 'only_field'        => false
                                , 'description_tag'   => 'p'
                                , 'validate_as'     => array() 
                                , 'value'           => $subject_email
                            );
                OPSD_Settings_API::field_text_row_static( 'opsd_sent_summary_subject', $fields );

                
            $field = array(
                'title'             => '',
                'disabled'          => false,
                'class'             => '',
                'css'               => '',
                'placeholder'       => '',
                'type'              => 'text',
                'description'       => '',
                'attr'              => array(),
                'rows'              => 10, 
                'cols'              => 20, 
                'teeny'             => true, 
                'show_visual_tabs'  => true,
                'default_editor' => 'tinymce',                                  // 'tinymce' | 'html'       // 'html' is used for the "Text" editor tab.
                'drag_drop_upload'  => false, 
                'show_in_2_cols'    => true, 
                'group'             => 'general',
                'tr_class'          => '',
                'only_field'        => false,
                'description_tag'   => 'p'
            , 'value' => $content_email
        );

        $email_content = OPSD_Settings_API::field_wp_textarea_row_static( 'show_email_content' , $field );
            
        ?></tbody></table><?php
        
        opsd_close_meta_box_section();    
		/*
        ?>
        <script type="text/javascript">
            jQuery( document ).ready(function(){
                setTimeout(function() {
                        opsd_scroll_to( '#opsd_sent_summary_metabox' );
                }, 100)
            });         
        </script>
        <?php
		 */
        return ob_get_clean();  
    }
    
    
	
    
    public function js() {
        ?>
        <script type="text/javascript">
            // Catch data for summary            
            jQuery('#opsd_email_to').on( "keypress", function( event ) {
                if( event.which != 13) {
                    opsd_generate_send_info();
                    //return false;
                }
            });  
            jQuery('#opsd_email_to,#opsd_product_selection,#opsd_product_expire,#opsd_product_ip_lock').on( 'change', function(){  
                opsd_generate_send_info();  
            } );            
            jQuery(document).ready( function(){
            	setTimeout( opsd_generate_send_info , 1000);
                // opsd_generate_send_info();
            });
            // On click submit form
            jQuery( '.opsd_send_button' ).on( 'click', function() {
				if ( jQuery( '.opsd_send_button' ).hasClass( 'disabled' ) ) {
					return false;	// Prevent submit form, if button disabled.
				}
                    jQuery('#opsd_action').val('go_send');
                    jQuery('#opsd_send_links_form<?php //echo $submit_form_name; ?>').trigger( 'submit' );
					return false;
            });
            //Allow enter key on textareas and submit buttons only
            jQuery(document).on( "keypress", ":input:not(textarea):not([type=submit])", function( event ) {
                if( event.which == 13) {
					if ( jQuery( '.opsd_send_button' ).hasClass( 'disabled' ) ) {
						return false; // Prevent submit form, if button disabled.
					}
                    //alert('You pressed enter!');                    
                    jQuery('#opsd_action').val('go_send');
                    jQuery('#opsd_send_links_form<?php //echo $submit_form_name; ?>').trigger( 'submit' );
                    return false;
                }
            });  
            

            function opsd_generate_send_info() {
			
				if  ( jQuery( '#opsd_email_to' ).length == 0 ) 
					return;

				var selected_products = []; 
				var selected_products_val = []; 
                jQuery('#opsd_product_selection :selected').each(function(i, selected){ 
                  selected_products[i] = jQuery(selected).text().trim(); 
				  selected_products_val[i] = jQuery(selected).val().trim(); 
                });
                selected_products = selected_products.join( ', ' );
                selected_products_val = selected_products_val.join( ', ' );
				if ( '' == selected_products_val ) {
					jQuery( '.opsd_send_button' ).addClass( 'disabled' );
				} else {
					jQuery( '.opsd_send_button' ).removeClass( 'disabled' )
				}

                jQuery('.opsd_submmary').html('<table class="form-table"><tbody></tbody></table>');
                
                if  ( jQuery( '#opsd_email_to' ).val().trim() != '' ) {
                    jQuery( '.opsd_send_button .opsd_text_hide_mobile' ).html('<?php echo esc_js( __( 'Send', 'secure-downloads' ) ); ?>&nbsp;&nbsp;');
                    jQuery('.opsd_submmary .form-table tbody').append( '<tr><th style="width:5em;"><?php echo esc_js( __( 'To', 'secure-downloads' ) ); ?></th><td>[' + jQuery( '#opsd_email_to' ).val().trim() + ']</td></tr>' );
                } else {
                    jQuery( '.opsd_send_button .opsd_text_hide_mobile' ).html('<?php echo esc_js( __( 'Generate', 'secure-downloads' ) ); ?>&nbsp;&nbsp;');
                    jQuery('.opsd_submmary .form-table tbody').append( '<tr><th colspan="2" style=""><?php echo esc_js( __( 'Generate Secure Link for Download', 'secure-downloads' ) ); ?></th></tr>' );
                }
                
                jQuery('.opsd_submmary .form-table tbody').append( '<tr><th style="width:5em;"><?php echo esc_js( __( 'Products', 'secure-downloads' ) ); ?></th><td>[' + selected_products.trim() + ']</td></tr>' );
                jQuery('.opsd_submmary .form-table tbody').append( '<tr><th style="width:5em;"><?php echo esc_js( __( 'Expire', 'secure-downloads' ) ); ?></th><td>[' + jQuery('#opsd_product_expire :selected').text().trim() + ']</td></tr>' );
                if ( jQuery('#opsd_product_ip_lock').val().trim() != '' )
                    jQuery('.opsd_submmary .form-table tbody').append( '<tr><th style="width:5em;"><?php echo esc_js( __( 'IP Loc', 'secure-downloads' ) ); ?></th><td>' + jQuery('#opsd_product_ip_lock').val().trim() + '</td></tr>' );
				
				jQuery( ".opsd_submmary" ).trigger( "generate_send_info" , [] );										// Action  hook
            }

        </script>
        <?php
    }
    
    
    public function css() {
        ?>
        <style type="text/css">
			.opsd_link_container {
				display: flex;
				flex-flow: row nowrap;
				justify-content: flex-start;
			}
			.opsd_link_container #opsd_email_to {
				flex: 65% 1 0;
				font-size: 1.4em;
				font-weight: 600;
				height: 43px;
				line-height: 2;
				/*max-width: 25rem;*/
				min-width: 0;
				padding: 6px 10px;
			}
			.opsd_link_container .opsd_generate_button{
				flex: 10% 0 0;
				margin: 0 0 0 1.5em;
				line-height: 34px;
				font-size: 1.2em;
				text-align: center;
				height: 43px;
				padding: 5px 20px;
				box-shadow: none;
			}
            .opsd_tr_more_margin th,
            .opsd_tr_more_margin td {
                padding-top: 30px !important;
            }
            .metabox-holder select option{
               padding:0.7em 20px;
               height:1.5em;
               border-bottom:1px solid #ccc;
            }
            select.opsd_product_selection,
			#select_opsd_form {
                margin: 30px 0 0;
                width:100%;

				max-width: 100%;
				height: 2.2em;
				/*line-height: 2.2em;*/
				font-size: 1.2em;
            }
			/*#opsd_email_to {				*/
			/*	width: 75%;*/
			/*	font-size: 1.4em;*/
			/*	font-weight: 600;*/
			/*	height: 2.1em;				*/
			/*}*/
            /*.opsd_page .opsd_send_button {                */
            /*    font-size: 1.4em;*/
            /*    height: 2.04em;*/
            /*    font-weight: 600;*/
            /*    line-height: 1.91em;*/
			/*	width: 100%;*/
			/*	overflow: hidden;*/
			/*	text-align: center;*/
			/*	padding:0;*/
            /*}*/
			/* iPad mini and all iPhones  and other Mobile Devices */
			@media (max-width: 782px) {
				.opsd_page .opsd_copy_2_clipboard_button,
				.opsd_page .opsd_send_button {
					line-height: 2.15;
				/*	padding: 2px;										*/
				/*	margin-top: 1px;*/
				}
			}
        </style>
        <?php
    }    
}
add_action('opsd_menu_created', array( new OPSD_Page_Single() , '__construct') );    // Executed after creation of Menu




//function opsd_gotopages() {
//    
//    wp_redirect( admin_url('admin.php?page=opsd' ) );
//}
//add_action('wp_dashboard_setup', 'opsd_gotopages');


function opsd_show_copy_button(){

	if  (
				(  ( isset( $_SERVER['SCRIPT_FILENAME'] ) ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], '/email-reminders/www' ) !== false ) )
			||  (  ( isset( $_SERVER['SCRIPT_FILENAME'] ) ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], 'wpbookingcalendar.com' ) !== false ) )
			||  (  ( isset( $_SERVER['HTTP_HOST'] ) ) && ( strpos( $_SERVER['HTTP_HOST'], 'wpbookingcalendar.com' ) !== false )  )
		){

	} else {
		  return true;
	}
	?>
	<div class="opsd_link_container wpdevelop" style="margin: 0 0 2em;justify-content: flex-end;">
		<a class="button button-primary opsd_copy_2_clipboard_button opsd_generate_button js-copy-email-btn" style="margin: 0;"
		   href="javascript:void(0)"  title="<?php _e('Copy to clipboard' , 'secure-downloads') ?>"
		><span class="opsd_text_hide_mobile0 btn_text_inside"><?php _e('Copy to clipboard' , 'secure-downloads') ?>&nbsp;&nbsp;</span><span class="glyphicon glyphicon-copy" aria-hidden="true"></span></a>
	</div>

		<script type="text/javascript">

			copyEmailBtn = document.querySelector('.js-copy-email-btn');

			copyEmailBtn.addEventListener('click', function(event) {

				var inputid = 'show_email_content';
				var content;
				var editor = tinyMCE.get(inputid);
				if (editor) {
					// Ok, the active tab is Visual
					content = editor.getContent();
				} else {
					// The active tab is HTML, so just query the textarea
					content = $('#'+inputid).val();
				}
				console.log( content );

				// Now get it as HTML  (original here https://stackoverflow.com/questions/34191780/javascript-copy-string-to-clipboard-as-text-html )

				// Create container for the HTML
				// [1]
				var container = document.createElement('div')
				container.innerHTML = content

				// Hide element
				// [2]
				container.style.position = 'fixed'
				container.style.pointerEvents = 'none'
				container.style.opacity = 0

				// Detect all style sheets of the page
				var activeSheets = Array.prototype.slice.call(document.styleSheets)
				.filter(function (sheet) {
					return !sheet.disabled
				})

				// Mount the container to the DOM to make `contentWindow` available
				// [3]
				document.body.appendChild(container)

				// Copy to clipboard
				// [4]
				window.getSelection().removeAllRanges()

				var range = document.createRange()
				range.selectNode(container)
				window.getSelection().addRange(range)

				// [5.1]
				document.execCommand('copy')

				// [5.2]
				for (var i = 0; i < activeSheets.length; i++) activeSheets[i].disabled = true

				// [5.3]

//if ( ! navigator.clipboard ){

	try{
		var successful = document.execCommand( 'copy' );
		var msg = successful ? 'successful' : 'unsuccessful';
		//console.log( 'Fallback: Copying text command was ' + msg );

		var btn_today = new Date();
		var btn_date = btn_today.getFullYear()+'-'+(btn_today.getMonth()+1)+'-'+btn_today.getDate();
		var btn_time = btn_today.getHours() + ":" + btn_today.getMinutes() + ":" + btn_today.getSeconds();
		var btn_dateTime = ' '+btn_time;
		jQuery( '.js-copy-email-btn .btn_text_inside').html( 'Copied' + btn_dateTime + ' ' );

		opsd_scroll_to( jQuery( '#opsd_sent_summary_subject' ) );

	} catch ( err ){
		//console.error( 'Fallback: Oops, unable to copy', err );
	}
// } else {
// 	var type = "text/html";
// 	var blob = new Blob([content], { type });
// 	var data = [new ClipboardItem({ [type]: blob })];
//
// 	navigator.clipboard.write(data).then(
// 		function () {
// 		/* success */
// 			console.log( 'Async: Copying to clipboard was successful!' );
// 		},
// 		function (err) {
// 		/* failure */
// 			console.error( 'Async: Could not copy text: ', err );
// 		}
// 	);
// }


				// [5.4]
				for (var i = 0; i < activeSheets.length; i++) activeSheets[i].disabled = false

				// Remove the container
				// [6]
				document.body.removeChild(container)

				// opsd_copy_text_to_clipboard( content );
			});



			function opsd_fallback_copy_text_to_clipboard( text ){
				var textArea = document.createElement( "textarea" );
				textArea.value = text;

				// Avoid scrolling to bottom
				textArea.style.top = "0";
				textArea.style.left = "0";
				textArea.style.position = "fixed";

				document.body.appendChild( textArea );
				textArea.focus();
				textArea.select();

				try{
					var successful = document.execCommand( 'copy' );
					var msg = successful ? 'successful' : 'unsuccessful';
					console.log( 'Fallback: Copying text command was ' + msg );
				} catch ( err ){
					console.error( 'Fallback: Oops, unable to copy', err );
				}

				document.body.removeChild( textArea );
			}


			function opsd_copy_text_to_clipboard( text ){
				if ( !navigator.clipboard ){
					opsd_fallback_copy_text_to_clipboard( text );
					return;
				}
				navigator.clipboard.writeText( text ).then( function (){
					console.log( 'Async: Copying to clipboard was successful!' );
				}, function ( err ){
					console.error( 'Async: Could not copy text: ', err );
				} );
			}

		</script>
	<?php
}