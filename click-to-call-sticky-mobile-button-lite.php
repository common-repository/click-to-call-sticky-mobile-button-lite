<?php
/**
 * Plugin Name: Click-To-Call Sticky Mobile Button Lite
 * Description: This Click-To-Call plugin has been developed by highly skilled, SEO-oriented programmers. This plugin was developed especially for website owners who prioritize website speed, SEO and understand its impact on their Google search results rankings.
 * Version: 1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Sitelinx
 * Author URI: https://seo.sitelinx.co.il/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: click-to-call-sticky-mobile-button-lite
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // only can be accessed through wp
} 


final class CTCS_Sitelinx{
    
    /**
     * The single instance of the class.
     *
     * @private
     */
    protected static $_instance = null;
    
    /**
     * Plugin Instance.
     *
     * Ensures only one instance of this plugin is loaded or can be loaded.
     *
     * @static
     * @return plugin - Main instance.
     */
     
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Plugin Constructor.
     */
     
    public function __construct(){
        
        $this->init();
    }

    public function init(){
        $this->defined();     

        add_action( 'wp_enqueue_scripts', array($this, 'ctcs_include_scripts' ) );
        add_action( 'admin_enqueue_scripts', array($this, 'ctcs_admin_scripts' ) );
         
        //add setting page
        add_action('admin_menu', array( $this,'ctcs_setting_func'));
      
        //show in footer
        add_action('wp_footer', array( $this,'ctcs_show_frotend'));
        add_action('admin_notices', array( $this,'ctcs_offer_banner'));
        add_action( 'admin_init', array( $this,'ctcs_plugin_notice_dismissed' ));
       
        /* plugin activation */
        register_activation_hook( __FILE__, array( $this, 'ctcs_activation' ) );
        
        /* plugin deactivation */
        register_deactivation_hook( __FILE__, array( $this, 'ctcs_deactivation' ) );
    }

    /**
     * define constant variables
     */

    private function defined(){
        if ( ! defined( 'CTCS_PATH' ) ) {
            define( 'CTCS_PATH', dirname( __FILE__ ) );
        }
        
        if ( ! defined( 'CTCS_URL' ) ) {
            define( 'CTCS_URL', plugins_url( '/', __FILE__ ) );
        }
        
        if ( ! defined( 'CTCS_CSS_VERSION' ) ) {
            define( 'CTCS_CSS_VERSION', '1.0' );
        }
        
        if ( ! defined( 'CTCS_JS_VERSION' ) ) {
            define( 'CTCS_JS_VERSION', '1.0' );
        }
		
		if ( ! defined( 'CTCS_ADMIN_EMAIL' ) ) {
            define( 'CTCS_ADMIN_EMAIL', 'tamirperl@gmail.com' );
        }
    }

    //enqueue css and js files frontend
    public function ctcs_include_scripts(){
        // Enqueue CSS file with version number
        wp_enqueue_style('click-call-frontend-style', CTCS_URL . 'css/click-call-frontend.css', array(), CTCS_CSS_VERSION);

        // Enqueue jQuery
        wp_enqueue_script('jquery');

        // Enqueue JavaScript file with version number
        wp_enqueue_script('click-call-frontend-script', CTCS_URL . 'js/click-call-frontend.js', array('jquery'), CTCS_JS_VERSION, true);
    }
 

    public function ctcs_admin_scripts(){
        $current_screen = get_current_screen();
        /* Check wether this page is Click Call setting page or not if yes please add the scripts */
        wp_enqueue_style('click-to-call-offer-banner-style', CTCS_URL . 'css/click-to-call-offer-banner.css', array(), CTCS_CSS_VERSION);

        // Check whether this page is the Click Call setting page or not, if yes, add the scripts
        if( $current_screen->id === "settings_page_click-to-call" ){
            wp_enqueue_style('click-call-backend-style', CTCS_URL . 'css/click-call-backendend.css', array(), CTCS_CSS_VERSION); 
            wp_enqueue_script('click-call-backend-script', CTCS_URL . 'js/click-call-backend.js', array('jquery'), CTCS_JS_VERSION, true);
        }
    }
    
    /**
     * setting page configruation
     */

    public function ctcs_setting_func()
    {    
        add_submenu_page(
            'options-general.php',
            'Click TO Call Setting',
            'Click TO Call Setting',
            'manage_options',
            'click-to-call',
            array($this, 'ctcs_setting_page')
        );
    }

    /**
     * Setting page callback function
     */
    public function ctcs_setting_page()
    {   ?> 
        
        
        <div class="footerstylediv">
        <?php
        // Check if the form is submitted
        if (isset($_POST['save']) && isset($_POST['ctcs_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ctcs_settings_nonce'])), 'ctcs_settings_action')){

            // Process and save the form data
            $ctcs_tag_line = isset($_POST['ctcs_tag_line']) ? sanitize_text_field(wp_unslash($_POST['ctcs_tag_line'])) : '';
            $ctcs_phone_number = isset($_POST['ctcs_phone_number']) ? sanitize_text_field(wp_unslash($_POST['ctcs_phone_number'])) : '';
            $ctcs_email = isset($_POST['ctcs_email']) ? sanitize_email(wp_unslash($_POST['ctcs_email'])) : '';
            $ctcs_instagram = isset($_POST['ctcs_instagram']) ? esc_url_raw(wp_unslash($_POST['ctcs_instagram'])) : '';
            $ctcs_whatsapp = isset($_POST['ctcs_whatsapp']) ? esc_url_raw(wp_unslash($_POST['ctcs_whatsapp'])) : '';
            $ctcs_facebook = isset($_POST['ctcs_facebook']) ? esc_url_raw(wp_unslash($_POST['ctcs_facebook'])) : '';
            $ctcs_twitter = isset($_POST['ctcs_twitter']) ? esc_url_raw(wp_unslash($_POST['ctcs_twitter'])) : '';
            $ctcs_google_business = isset($_POST['ctcs_google_business']) ? esc_url_raw(wp_unslash($_POST['ctcs_google_business'])) : '';
            $ctcs_skype = isset($_POST['ctcs_skype']) ? esc_url_raw(wp_unslash($_POST['ctcs_skype'])) : '';
            $ctcs_telegram = isset($_POST['ctcs_telegram']) ? esc_url_raw(wp_unslash($_POST['ctcs_telegram'])) : '';
            $ctcs_linktr = isset($_POST['ctcs_linktr']) ? esc_url_raw(wp_unslash($_POST['ctcs_linktr'])) : '';
            $ctcs_onlyfans = isset($_POST['ctcs_onlyfans']) ? esc_url_raw(wp_unslash($_POST['ctcs_onlyfans'])) : '';
            $ctcs_position_display = isset($_POST['ctcs_position_display']) ? sanitize_text_field(wp_unslash($_POST['ctcs_position_display'])) : '';

            // Save the data to options
            
            $errors = array();

            if(!empty($ctcs_tag_line)){
              update_option('ctcs_tag_line', $ctcs_tag_line);
            }

            if(!empty($ctcs_email) && is_email($ctcs_email)){
                update_option('ctcs_email', $ctcs_email);
            }else{
                $errors[] = __('Please enter a valid email.','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_phone_number) && ctcs_is_valid_phone_number($ctcs_phone_number)){
              update_option('ctcs_phone_number', $ctcs_phone_number);
            }else{
              $errors[] = __('Phone number should be added with country code like and atleast 9 digit like +1234567890','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_whatsapp) && ctcs_is_valid_whatsapp_url($ctcs_whatsapp)){
               update_option('ctcs_whatsapp', $ctcs_whatsapp);
            }else{
               $errors[] = __('Whatsapp Invalid URL. Url should be like https://wa.me/+1234567890','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_facebook) && ctcs_is_valid_facebook_url($ctcs_facebook)){
               update_option('ctcs_facebook', $ctcs_facebook);
            }else{
              $errors[] = __('Facebook Invalid URL. Url should be like https://www.facebook.com/examplepage','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_instagram) && ctcs_is_valid_instagram_url($ctcs_instagram)){
               update_option('ctcs_instagram', $ctcs_instagram);
            }else{
              $errors[] = __('Instagram Invalid URL. Url should be like https://www.instagram.com/example_username/','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_twitter) && ctcs_is_valid_twitter_url($ctcs_twitter)){
               update_option('ctcs_twitter', $ctcs_twitter);
            }else{
               $errors[] = __('Twitter Invalid URL. Url should be like https://twitter.com/example_username','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_google_business) && ctcs_is_valid_google_business_url($ctcs_google_business)){
               update_option('ctcs_google_business', $ctcs_google_business);
            }else{
              $errors[] = __('Google Business Invalid URL. Url should be like https://business.google.com/example','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_skype) && ctcs_is_valid_skype_url($ctcs_skype)){
               update_option('ctcs_skype', $ctcs_skype);
            }else{
              $errors[] = __('Skype Invalid URL. Url should be like https://join.skype.com/invite/abcdef123456','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_telegram) && ctcs_is_valid_telegram_url($ctcs_telegram)){
               update_option('ctcs_telegram', $ctcs_telegram);
            }else{
              $errors[] = __('Telegram Invalid URL. Url should be like https://t.me/example_channel','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_onlyfans) && ctcs_is_valid_onlyfans_url($ctcs_onlyfans)){
               update_option('ctcs_onlyfans', $ctcs_onlyfans);
            }else{
              $errors[] = __('Onlyfans Invalid URL. Url should be like https://onlyfans.com/example_username','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_linktr) && ctcs_is_valid_linktr_url($ctcs_linktr)){
               update_option('ctcs_linktr', $ctcs_linktr);
            }else{
               $errors[] = __('Linktr Invalid URL. Url should be like https://linktr.ee/example_username','click-to-call-sticky-mobile-button-lite');
            }

            if(!empty($ctcs_position_display)){
                update_option('ctcs_position_display', $ctcs_position_display);
            }else{
                $errors[] = __('Please select icons display position','click-to-call-sticky-mobile-button-lite');
            }

            // Redirect or display a success message
            if(empty($errors)){
             echo '<div class="updated"><p>Data saved successfully!</div>';
            }else{
                echo '<div class="error">';
                      foreach($errors as $error) {
                         echo '<p>' . esc_html($error) . '</p>';
                    }
               echo '</div>';
            }
        }

        $ctcs_email_val = !empty($value = sanitize_email(get_option('ctcs_email', ''))) ? $value : '';
        $ctcs_phone_number_val = !empty($value = sanitize_text_field(get_option('ctcs_phone_number', ''))) ? $value : '';
        $ctcs_tagline_val = !empty($value = sanitize_text_field(get_option('ctcs_tag_line', ''))) ? $value : '';
        $ctcs_whatsapp_val = !empty($value = sanitize_text_field(get_option('ctcs_whatsapp', ''))) ? $value : '';
        $ctcs_facebook_val = !empty($value = sanitize_text_field(get_option('ctcs_facebook', ''))) ? $value : '';
        $ctcs_instagram_val = !empty($value = sanitize_text_field(get_option('ctcs_instagram', ''))) ? $value : '';
        $ctcs_twitter_val = !empty($value = sanitize_text_field(get_option('ctcs_twitter', ''))) ? $value : '';
        $ctcs_google_business_val = !empty($value = sanitize_text_field(get_option('ctcs_google_business', ''))) ? $value : '';
        $ctcs_skype_val = !empty($value = sanitize_text_field(get_option('ctcs_skype', ''))) ? $value : '';
        $ctcs_telegram_val = !empty($value = sanitize_text_field(get_option('ctcs_telegram', ''))) ? $value : '';
        $ctcs_onlyfans_val = !empty($value = sanitize_text_field(get_option('ctcs_onlyfans', ''))) ? $value : '';
        $ctcs_linktr_val = !empty($value = sanitize_text_field(get_option('ctcs_linktr', ''))) ? $value : '';

        
        $ctcs_position_display_val = get_option('ctcs_position_display');
        ?>
            <h1><?php esc_html_e( "Click To Call Setting", "click-to-call-sticky-mobile-button-lite" );?></h1>
           <p><?php esc_html_e( "Choose the means of communication your website audience can contact you through. The options you choose will reflect as icons at the bottom of mobile screens.", "click-to-call-sticky-mobile-button-lite" );?></p>
           <p><?php esc_html_e( "This free plugin is brought to you by", "click-to-call-sticky-mobile-button-lite");?> <a href="https://seo.sitelinx.co.il" target="_blank">https://seo.sitelinx.co.il</a> <?php esc_html_e("| Expert SEO services. For a limited time only, we are offering our U.S / Canada users a FREE SEO audit and a very low rate SEO service. For more information,", "click-to-call-sticky-mobile-button-lite");?><br> <strong><?php esc_html_e(" Contact us at:", "click-to-call-sticky-mobile-button-lite");?></strong> <a href="mailto:info@seo.sitelinx.co.il">info@seo.sitelinx.co.il</a></p>

            <form action="" method="POST">
                <label><?php esc_html_e( "Display Position", "click-to-call-sticky-mobile-button-lite" );?></label>
                <select name="ctcs_position_display">
                    <option value="horizontal_display" <?php if(!empty($ctcs_position_display_val) && $ctcs_position_display_val == 'horizontal_display'){ echo 'selected';}?>><?php esc_html_e( "Horizontal Display", "click-to-call-sticky-mobile-button-lite" );?></option>
                    <option value="vertical_display" <?php if(!empty($ctcs_position_display_val) && $ctcs_position_display_val == 'vertical_display'){ echo 'selected';}?>><?php esc_html_e( "Vertical Display", "click-to-call-sticky-mobile-button-lite" );?></option>
                </select>
                <label for="ctcs_tag_line"><?php esc_html_e( "Tag Line", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="text" name="ctcs_tag_line" id="ctcs_tag_line" value="<?php echo esc_attr($ctcs_tagline_val); ?>"/>

                <label for="ctcs_phone_number"><?php esc_html_e( "Phone Number", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="text" name="ctcs_phone_number" id="ctcs_phone_number" value="<?php echo esc_attr($ctcs_phone_number_val); ?>" placeholder="+1234567890"/>

                <label for="ctcs_email"><?php esc_html_e( "Email", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="email" name="ctcs_email" id="ctcs_email" value="<?php echo esc_attr($ctcs_email_val); ?>" placeholder="test24@gmail.com"/>
                
                <label for="ctcs_whatsapp"><?php esc_html_e( "WhatsApp link", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_whatsapp" id="ctcs_whatsapp" value="<?php echo esc_url($ctcs_whatsapp_val); ?>" placeholder="https://wa.me/+1234567890"/>

                <label for="ctcs_facebook"><?php esc_html_e( "Facebook page/profile link", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_facebook" id="ctcs_facebook" value="<?php echo esc_url($ctcs_facebook_val); ?>"  placeholder="https://www.facebook.com/examplepage"/>

                <label for="ctcs_instagram"><?php esc_html_e( "Instagram Link", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_instagram" id="ctcs_instagram" value="<?php echo esc_url($ctcs_instagram_val); ?>" placeholder="https://www.instagram.com/example_username"/>

                <label for="ctcs_twitter"><?php esc_html_e( "Twitter Link", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_twitter" id="ctcs_twitter" value="<?php echo esc_url($ctcs_twitter_val); ?>" placeholder="https://twitter.com/example_username"/>

                <label for="ctcs_google_business"><?php esc_html_e( "Google My business page link", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_google_business" id="ctcs_google_business" value="<?php echo esc_url($ctcs_google_business_val); ?>" placeholder="https://business.google.com/example"/>

                <label for="ctcs_skype"><?php esc_html_e( "Skype", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_skype" id="ctcs_skype" value="<?php echo esc_url($ctcs_skype_val); ?>" placeholder="https://join.skype.com/invite/abcdef123456"/>

                <label for="ctcs_telegram"><?php esc_html_e( "Telegram", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="text" name="ctcs_telegram" id="ctcs_telegram" value="<?php echo esc_url($ctcs_telegram_val); ?>" placeholder="https://t.me/example_channel"/>

                <label for="ctcs_onlyfans"><?php esc_html_e( "Onlyfans", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_onlyfans" id="ctcs_onlyfans" value="<?php echo esc_url($ctcs_onlyfans_val); ?>" placeholder="https://onlyfans.com/example_username"/>

                <label for="ctcs_linktr"><?php esc_html_e( "Linktr.ee", "click-to-call-sticky-mobile-button-lite" );?></label>
                <input type="url" name="ctcs_linktr" id="ctcs_linktr" value="<?php echo esc_url($ctcs_linktr_val); ?>" placeholder="https://linktr.ee/example_username"/>
                 <?php wp_nonce_field('ctcs_settings_action', 'ctcs_settings_nonce'); ?>
                <input type="submit" name="save" value="SAVE" class="button button-primary button-large"/>
            </form>
        </div>
        <?php
    }

    
    public function ctcs_show_frotend(){
        $ctcs_email = !empty(get_option('ctcs_email')) ? sanitize_email(get_option('ctcs_email')) : '';
        $ctcs_phone_number = !empty(get_option('ctcs_phone_number')) ? sanitize_text_field(get_option('ctcs_phone_number')) : '';
        $ctcs_tagline = !empty(get_option('ctcs_tagline')) ? sanitize_text_field(get_option('ctcs_tagline')) : '';
        $ctcs_whatsapp_val = !empty(get_option('ctcs_whatsapp')) ? esc_url_raw(get_option('ctcs_whatsapp')) : '';
        $ctcs_facebook_val = !empty(get_option('ctcs_facebook')) ? esc_url_raw(get_option('ctcs_facebook')) : '';
        $ctcs_instagram_val = !empty(get_option('ctcs_instagram')) ? esc_url_raw(get_option('ctcs_instagram')) : '';
        $ctcs_twitter_val = !empty(get_option('ctcs_twitter')) ? esc_url_raw(get_option('ctcs_twitter')) : '';
        $ctcs_google_business_val = !empty(get_option('ctcs_google_business')) ? esc_url_raw(get_option('ctcs_google_business')) : '';
        $ctcs_skype_val = !empty(get_option('ctcs_skype')) ? esc_url_raw(get_option('ctcs_skype')) : '';
        $ctcs_telegram_val = !empty(get_option('ctcs_telegram')) ? esc_url_raw(get_option('ctcs_telegram')) : '';
        $ctcs_onlyfans_val = !empty(get_option('ctcs_onlyfans')) ? esc_url_raw(get_option('ctcs_onlyfans')) : '';
        $ctcs_linktr_val = !empty(get_option('ctcs_linktr')) ? esc_url_raw(get_option('ctcs_linktr')) : '';
        $ctcs_position_display = !empty(get_option('ctcs_position_display')) ? sanitize_text_field(get_option('ctcs_position_display')) : '';
        $ctcs_position_display = !empty(get_option('ctcs_position_display')) ? sanitize_text_field(get_option('ctcs_position_display')) : '';        

        ?>
        <div id="foot-cont-div">
            <div id="up-arrow-foot" class="shutter-down">
                <span class="ua-span"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" transform="rotate(0)matrix(1, 0, 0, -1, 0, 0)" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 10L12 15L17 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></span>
            </div>
            <div id="mobile-contact-div" class="mobile-contact-div <?php echo esc_attr($ctcs_position_display);?> shutter-up">
                <div class="centerbox">
                    <div class="left-mobile">
                        <?php if(!empty($ctcs_email)){ ?>
                            <div class="m-contact-div">
                                <a href="mailto:<?php echo esc_attr($ctcs_email); ?>">
                                    <img src="<?php echo esc_url(CTCS_URL) ?>/img/email-mail.svg" alt="Email">  
                                </a>
                            </div>
                        <?php } ?>
                        <?php if(!empty($ctcs_phone_number)){ ?>
                            <div class="m-tel-div">
                                <a href="tel:<?php echo esc_attr($ctcs_phone_number); ?>" >
                                    <img src="<?php echo esc_url(CTCS_URL) ?>/img/phone-call.svg" alt="phone">      
                                </a>
                            </div>
                       <?php } ?>
                    </div>
                    <div class="m-text-div">
                        <span class="da-span"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 10L12 15L17 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></span>
                        <?php echo esc_html($ctcs_tagline); ?>
                    </div>
                    <div class="right-mobile">
                        <?php if(!empty($ctcs_whatsapp_val)){ ?>
                        <div class="m-tel-div mtel-whatapp">
                            <a href="<?php echo esc_url($ctcs_whatsapp_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/whatsapp.svg" alt="whatsapp">
                            </a>
                        </div>
                       <?php } ?>
                    <div class="moreicon">
                    <button type="button" class="btn moreiconbtn">
                        <svg fill="#ffffff" height="200px" width="200px" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path class="cls-1" d="M8,6.5A1.5,1.5,0,1,1,6.5,8,1.5,1.5,0,0,1,8,6.5ZM.5,8A1.5,1.5,0,1,0,2,6.5,1.5,1.5,0,0,0,.5,8Zm12,0A1.5,1.5,0,1,0,14,6.5,1.5,1.5,0,0,0,12.5,8Z"></path> </g></svg>
                    </button>
                    <div class="iconmore-list">
                        <?php if(!empty($ctcs_facebook_val)){ ?>
                        <div class="m-tel-div mtel-facebook">
                            <a href="<?php echo esc_url($ctcs_facebook_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/facebook.svg" alt="facebook">
                            </a>
                        </div>
                       <?php } ?>
                       <?php if(!empty($ctcs_instagram_val)){ ?>
                        <div class="m-tel-div mtel-insta">
                            <a href="<?php echo esc_url($ctcs_instagram_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/instagram-.svg" alt="instagram">
                            </a>
                        </div>
                       <?php } ?>
                       <?php if(!empty($ctcs_twitter_val)){ ?>
                        <div class="m-tel-div mtel-twit">
                            <a href="<?php echo esc_url($ctcs_twitter_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/twitter.svg" alt="twitter">
                            </a>
                        </div>
                       <?php } ?>
                       <?php if(!empty($ctcs_google_business_val)){ ?>
                        <div class="m-tel-div mtel-googl">
                            <a href="<?php echo esc_url($ctcs_google_business_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/google-plus.svg" alt="gplus">
                            </a>
                        </div>
                       <?php } ?>
                       <?php if(!empty($ctcs_skype_val)){ ?>
                        <div class="m-tel-div mtel-skype">
                            <a href="<?php echo esc_url($ctcs_skype_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/skype.svg" alt="skype">
                            </a>
                        </div>
                       <?php } ?>
                       <?php if(!empty($ctcs_telegram_val)){ ?>
                        <div class="m-tel-div mtel-telegrm">
                            <a href="<?php echo esc_url($ctcs_telegram_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/telegram.svg" alt="telegram">
                            </a>
                        </div>
                       <?php } ?>
                       <?php if(!empty($ctcs_onlyfans_val)){ ?>
                        <div class="m-tel-div mtel-fans">
                            <a href="<?php echo esc_url($ctcs_onlyfans_val); ?>" target="_blank">
                                <img src="<?php echo esc_url(CTCS_URL) ?>/img/onlyfans.png" alt="onlyfans" />
                            </a>
                        </div>
                       <?php } ?>
                        <?php if(!empty($ctcs_linktr_val)){ ?>
                        <div class="m-tel-div mtel-tree">
                            <a href="<?php echo esc_url($ctcs_linktr_val); ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" xml:space="preserve"><path d="m13.511 5.853 4.005-4.117 2.325 2.381-4.201 4.005h5.909v3.305h-5.937l4.229 4.108-2.325 2.334-5.741-5.769-5.741 5.769-2.325-2.325 4.229-4.108H2V8.122h5.909L3.708 4.117l2.325-2.381 4.005 4.117V0h3.473v5.853zM10.038 16.16h3.473v7.842h-3.473V16.16z"></path></svg>
                            </a>
                        </div>
                       <?php } ?>
                    </div>
                </div>
                        </div>
                </div>
            </div>
        </div>
    <?php
    }

    //Genral plugin notification for ratings. 
    public function ctcs_offer_banner(){
    global $pagenow;
    $user_id = get_current_user_id();
    if ( !get_user_meta( $user_id, 'ctcs_notice_dismissed' ) ){
    ?>
        <div id="rate-us-wp" class="notice updated is-dismissible">
            <p><?php esc_html_e( "Limited Offer: FREE SEO AUDIT!  We are offering all our users a free audit. Don’t miss out! Visit our website", "click-to-call-sticky-mobile-button-lite");?> <a href="https://seo.sitelinx.co.il" target="_blank"> https://seo.sitelinx.co.il</a></p>
            <div class="seo-mail-box">
              <span class="seo-form-design" >
                <svg height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#21D0C3;" cx="256" cy="256" r="256"></circle> <g> <path style="fill:#FFFFFF;" d="M62.959,178.471c0-13.316,3.172-23.538,9.516-30.667c6.346-7.129,15.863-10.692,28.553-10.692 c12.688,0,22.206,3.563,28.551,10.692c6.346,7.128,9.517,17.35,9.517,30.667v5.169h-24.439v-6.815 c0-5.952-1.137-10.143-3.406-12.572c-2.273-2.428-5.444-3.642-9.517-3.642c-4.074,0-7.246,1.214-9.518,3.642 c-2.271,2.429-3.406,6.62-3.406,12.572c0,5.639,1.253,10.613,3.759,14.922c2.507,4.309,5.64,8.383,9.401,12.22 c3.759,3.837,7.793,7.676,12.101,11.515c4.31,3.839,8.344,8.028,12.102,12.572c3.761,4.543,6.894,9.713,9.401,15.509 c2.506,5.797,3.759,12.611,3.759,20.444c0,13.316-3.25,23.538-9.752,30.667c-6.502,7.128-16.096,10.692-28.787,10.692 c-12.689,0-22.284-3.565-28.787-10.692c-6.502-7.128-9.753-17.35-9.753-30.667v-10.103h24.44v11.749 c0,5.954,1.214,10.105,3.641,12.455c2.429,2.35,5.679,3.524,9.753,3.524c4.073,0,7.324-1.174,9.752-3.524 c2.428-2.349,3.644-6.501,3.644-12.455c0-5.639-1.255-10.613-3.761-14.921c-2.507-4.309-5.64-8.383-9.401-12.22 c-3.759-3.839-7.793-7.677-12.101-11.515c-4.309-3.839-8.342-8.029-12.102-12.572c-3.761-4.544-6.894-9.713-9.401-15.509 C64.212,193.119,62.959,186.305,62.959,178.471L62.959,178.471z"></path> <path style="fill:#FFFFFF;" d="M179.984,208.314h35.483v23.501h-35.483v48.172h44.648v23.5h-70.496V138.993h70.496v23.498h-44.648 V208.314z"></path> </g> <path style="fill:#15BDB2;" d="M289.612,129.448l-2.702-17.898l28.336-7.749l6.792,16.805c6.368-0.643,12.786-0.672,19.156-0.105 l6.62-16.868l28.417,7.454l-2.517,17.929c5.766,2.595,11.339,5.771,16.639,9.51l14.162-11.301l20.883,20.665l-11.156,14.279 c3.797,5.26,7.025,10.802,9.686,16.541l17.901-2.697l7.747,28.333l-16.801,6.797c0.634,6.368,0.669,12.782,0.097,19.153 l16.874,6.623l-7.456,28.414l-17.925-2.517c-2.603,5.766-5.776,11.343-9.513,16.638l11.302,14.165l-20.665,20.878l-14.282-11.15 c-5.26,3.792-10.802,7.02-16.543,9.686l2.702,17.895l-28.334,7.752l-6.796-16.804c-6.369,0.639-12.785,0.669-19.154,0.103 l-6.621,16.868l-28.416-7.454l2.515-17.927c-5.767-2.604-11.343-5.774-16.642-9.512l-14.162,11.303l-20.88-20.67l11.152-14.277 c-3.788-5.261-7.019-10.805-9.68-16.548l-17.898,2.707l-7.75-28.336l16.805-6.793c-0.642-6.37-0.672-12.787-0.103-19.159 l-16.875-6.616l7.456-28.416l17.93,2.513c2.6-5.767,5.771-11.341,9.509-16.641l-11.302-14.16l20.669-20.883l14.278,11.16 C278.329,135.338,283.875,132.111,289.612,129.448L289.612,129.448z M332.14,145.528c41.814,0,75.713,33.898,75.713,75.713 c0,41.814-33.899,75.713-75.713,75.713c-41.815,0-75.713-33.899-75.713-75.713C256.427,179.426,290.325,145.528,332.14,145.528z"></path> <g> <path style="fill:#666666;" d="M338.834,314.134v20.893h-13.392v-20.893c2.218,0.048,4.45,0.076,6.697,0.076 C334.386,314.21,336.617,314.183,338.834,314.134z"></path> <circle style="fill:#666666;" cx="332.141" cy="221.497" r="93.517"></circle> </g> <circle style="fill:#FAD24D;" cx="332.141" cy="221.497" r="84.834"></circle> <path style="fill:#FFFFFF;" d="M332.141,145.926c5.039,0,9.97,0.497,14.744,1.443c4.89,0.969,9.624,2.416,14.144,4.288 c4.604,1.907,8.979,4.256,13.068,6.989c4.135,2.765,7.977,5.923,11.473,9.418c3.496,3.496,6.655,7.34,9.42,11.474 c2.735,4.09,5.083,8.465,6.989,13.071c1.872,4.519,3.32,9.252,4.289,14.142c0.945,4.774,1.443,9.707,1.443,14.748 c0,5.04-0.497,9.973-1.443,14.746c-0.969,4.889-2.416,9.621-4.289,14.14c-1.906,4.607-4.254,8.981-6.987,13.068 c-2.77,4.145-5.928,7.99-9.416,11.478h-0.005c-3.495,3.494-7.338,6.653-11.473,9.419c-4.089,2.733-8.464,5.082-13.068,6.987 c-4.519,1.87-9.253,3.319-14.144,4.288c-4.774,0.946-9.705,1.443-14.744,1.443c-5.04,0-9.973-0.496-14.745-1.443 c-4.891-0.969-9.624-2.415-14.144-4.288c-4.605-1.906-8.981-4.254-13.068-6.987c-4.136-2.766-7.979-5.924-11.474-9.419l-0.005-0.005 c-3.494-3.495-6.652-7.339-9.418-11.473c-2.733-4.089-5.082-8.463-6.989-13.068c-1.872-4.519-3.319-9.253-4.288-14.144 c-0.946-4.773-1.443-9.704-1.443-14.743c0-5.04,0.496-9.972,1.443-14.745c0.969-4.89,2.415-9.624,4.288-14.146 c1.907-4.604,4.257-8.979,6.99-13.07c5.523-8.262,12.632-15.37,20.895-20.892c4.088-2.735,8.464-5.082,13.068-6.989 c4.519-1.87,9.252-3.319,14.144-4.288C322.169,146.424,327.1,145.926,332.141,145.926L332.141,145.926z M272.613,248.65h18.818 c-0.493-1.387-0.946-2.782-1.356-4.177c-0.593-2.01-1.106-4.025-1.535-6.039c-0.453-2.136-0.821-4.314-1.1-6.522 c-0.226-1.776-0.389-3.554-0.493-5.331h-20.024c0.122,1.575,0.3,3.144,0.535,4.705c0.307,2.045,0.709,4.051,1.192,6.008 c0.519,2.088,1.14,4.148,1.857,6.166C271.137,245.227,271.841,246.96,272.613,248.65L272.613,248.65z M302.286,248.65h24.77v-22.068 h-29.954c0.105,1.549,0.262,3.097,0.471,4.638c0.268,1.987,0.629,3.975,1.075,5.954c0.464,2.063,1.031,4.125,1.695,6.174 C300.917,245.129,301.565,246.899,302.286,248.65z M337.225,248.65h24.768c0.724-1.758,1.369-3.522,1.941-5.288 c0.664-2.055,1.231-4.121,1.698-6.187c0.445-1.978,0.805-3.963,1.075-5.948c0.21-1.544,0.367-3.094,0.473-4.644h-29.954V248.65 L337.225,248.65z M372.85,248.65h18.816c0.775-1.693,1.478-3.426,2.108-5.196c0.718-2.014,1.34-4.071,1.855-6.159 c0.483-1.953,0.883-3.957,1.19-6.001c0.235-1.562,0.415-3.134,0.536-4.712h-20.024c-0.103,1.775-0.266,3.55-0.492,5.325 c-0.279,2.21-0.649,4.39-1.102,6.528c-0.427,2.01-0.937,4.024-1.53,6.03C373.796,245.863,373.343,247.259,372.85,248.65 L372.85,248.65z M385.863,258.821h-17.39c-0.373,0.732-0.777,1.49-1.205,2.275v0.005c-0.523,0.955-1.093,1.947-1.702,2.968 c-0.66,1.105-1.367,2.229-2.117,3.367c-0.744,1.128-1.51,2.24-2.294,3.327c-1.391,1.929-2.858,3.815-4.396,5.649 c-1.538,1.833-3.17,3.644-4.887,5.423c-0.939,0.972-1.906,1.935-2.896,2.884c1.138-0.301,2.264-0.637,3.377-0.997 c2.659-0.864,5.249-1.895,7.746-3.079c3.398-1.608,6.64-3.504,9.691-5.656c4.225-2.979,8.09-6.456,11.504-10.334l0.002,0.002 c0.929-1.057,1.831-2.155,2.702-3.286c0.551-0.714,1.1-1.459,1.645-2.232L385.863,258.821L385.863,258.821z M356.892,258.821 h-19.667v22.833c0.802-0.68,1.591-1.366,2.364-2.062c1.447-1.301,2.827-2.616,4.14-3.937c1.737-1.749,3.36-3.514,4.868-5.286 c1.535-1.802,2.981-3.647,4.337-5.526c0.574-0.793,1.154-1.632,1.737-2.505c0.547-0.822,1.105-1.695,1.667-2.609l0.002,0.002 L356.892,258.821L356.892,258.821z M327.055,258.821h-19.668l0.554,0.912l0.002-0.002c1.07,1.744,2.206,3.455,3.402,5.113 c1.355,1.877,2.801,3.72,4.335,5.522c1.509,1.773,3.133,3.539,4.869,5.289c1.313,1.323,2.698,2.641,4.147,3.944 c0.772,0.692,1.558,1.379,2.358,2.057V258.821L327.055,258.821z M295.805,258.821h-17.387l0.22,0.311 c0.545,0.775,1.096,1.523,1.648,2.239c0.85,1.103,1.753,2.2,2.702,3.281v0.006c3.383,3.856,7.337,7.392,11.505,10.331 c5.341,3.769,11.223,6.716,17.439,8.735c1.114,0.362,2.241,0.696,3.378,0.998c-2.73-2.622-5.347-5.399-7.778-8.299 c-1.542-1.836-3.013-3.726-4.406-5.659c-0.782-1.083-1.547-2.192-2.288-3.316c-0.753-1.142-1.46-2.271-2.123-3.378 c-0.588-0.983-1.157-1.975-1.702-2.973C296.582,260.311,296.18,259.551,295.805,258.821L295.805,258.821z M278.422,184.172h17.755 c0.354-0.69,0.712-1.367,1.076-2.032v-0.006c0.503-0.917,1.031-1.843,1.583-2.774c0.592-0.998,1.249-2.055,1.966-3.166v-0.005 c0.696-1.075,1.398-2.118,2.102-3.12c1.38-1.96,2.869-3.915,4.462-5.86c1.577-1.923,3.235-3.807,4.966-5.638 c1.07-1.132,2.181-2.258,3.327-3.368l0.033-0.032c-1.214,0.316-2.415,0.664-3.6,1.046c-2.687,0.863-5.307,1.901-7.843,3.099 c-3.41,1.61-6.666,3.51-9.726,5.668c-3.084,2.174-5.972,4.607-8.63,7.265l-0.005,0.006c-1.654,1.653-3.225,3.398-4.696,5.222 C280.229,181.672,279.303,182.907,278.422,184.172L278.422,184.172z M307.781,184.172h19.274v-22.676 c-0.802,0.698-1.591,1.405-2.362,2.116c-1.464,1.35-2.862,2.716-4.19,4.088c-1.719,1.778-3.355,3.606-4.908,5.477 c-1.561,1.881-3.025,3.797-4.387,5.731c-0.541,0.769-1.077,1.56-1.604,2.364c-0.543,0.828-1.05,1.628-1.513,2.389L307.781,184.172 L307.781,184.172z M337.225,184.172h19.275l-0.306-0.512l-0.004,0.002c-0.462-0.76-0.965-1.556-1.509-2.383 c-0.528-0.806-1.066-1.597-1.609-2.37c-1.365-1.938-2.832-3.856-4.395-5.742c-1.549-1.867-3.183-3.692-4.894-5.461v-0.006 c-1.295-1.339-2.694-2.702-4.187-4.081c-0.773-0.714-1.564-1.423-2.37-2.123V184.172L337.225,184.172z M368.105,184.172h17.757 l-0.222-0.316c-0.545-0.773-1.094-1.517-1.643-2.229c-0.842-1.098-1.745-2.19-2.696-3.273c-0.946-1.076-1.919-2.112-2.911-3.101 l-0.005-0.006c-2.656-2.658-5.545-5.091-8.628-7.265c-3.061-2.157-6.317-4.057-9.728-5.668c-2.535-1.198-5.155-2.236-7.84-3.099 c-1.186-0.382-2.385-0.73-3.6-1.044c1.145,1.082,2.272,2.254,3.354,3.399h0.005c1.732,1.831,3.389,3.716,4.967,5.64 c1.593,1.942,3.08,3.897,4.46,5.858c0.684,0.975,1.389,2.023,2.112,3.14h0.005c0.673,1.042,1.325,2.094,1.949,3.151 C366.381,180.942,367.264,182.539,368.105,184.172L368.105,184.172z M391.666,194.345h-19.124c0.501,1.381,0.965,2.776,1.392,4.18 c0.608,1.998,1.141,4.015,1.594,6.042c0.487,2.173,0.881,4.348,1.183,6.512c0.247,1.773,0.432,3.553,0.56,5.332h20.085 c-0.122-1.576-0.301-3.147-0.536-4.711v-0.006c-0.305-2.035-0.705-4.036-1.19-5.996c-0.515-2.086-1.138-4.143-1.855-6.158 C393.144,197.772,392.441,196.038,391.666,194.345L391.666,194.345z M361.661,194.345h-24.435v22.066h29.882 c-0.125-1.522-0.301-3.051-0.53-4.581c-0.293-1.972-0.678-3.958-1.151-5.945c-0.504-2.128-1.095-4.21-1.771-6.235 C363.063,197.87,362.396,196.099,361.661,194.345z M327.055,194.345H302.62c-0.736,1.754-1.401,3.527-1.996,5.31 c-0.675,2.024-1.264,4.104-1.77,6.231c-0.473,1.993-0.857,3.98-1.152,5.955c-0.228,1.529-0.404,3.053-0.529,4.571h29.882V194.345 L327.055,194.345z M291.738,194.345h-19.126c-0.772,1.691-1.476,3.423-2.104,5.189c-0.718,2.018-1.339,4.076-1.857,6.165 c-0.483,1.958-0.884,3.963-1.192,6.009c-0.235,1.561-0.415,3.13-0.535,4.703h20.089c0.126-1.783,0.313-3.566,0.561-5.343 c0.299-2.163,0.693-4.334,1.179-6.502c0.454-2.03,0.987-4.05,1.595-6.05C290.774,197.116,291.238,195.725,291.738,194.345 L291.738,194.345z"></path> <path style="fill:#666666;" d="M321.884,452.28h20.505c2.851,0,5.184-2.393,5.184-5.314V345.291c0-2.919-2.337-5.314-5.184-5.314 h-20.505c-2.846,0-5.185,2.398-5.185,5.314v101.674C316.699,449.881,319.033,452.28,321.884,452.28z"></path> <path style="fill:#FEFEFE;" d="M347.573,349.471v-9.129c0-2.919-2.336-5.314-5.184-5.314h-20.505c-2.847,0-5.185,2.396-5.185,5.314 v9.129H347.573z"></path> <path style="fill:#ECF0F1;" d="M347.573,349.471v-9.128c0-2.796-2.141-5.109-4.824-5.301v14.429H347.573z M321.523,335.043 c-2.682,0.193-4.824,2.506-4.824,5.301v9.128h4.824V335.043z"></path> <path style="fill:#15BDB2;" d="M407.312,329.822c2.331-0.372,4.67-0.487,6.986-0.363l3.271-6.926l16.547,5.8l-2.037,7.427 c1.874,1.359,3.621,2.921,5.201,4.68l7.209-2.587l7.597,15.799l-6.69,3.811c0.372,2.331,0.488,4.674,0.363,6.986l6.929,3.273 l-5.802,16.547l-7.425-2.037c-1.359,1.879-2.921,3.622-4.677,5.202l2.584,7.203l-15.8,7.603l-3.809-6.69 c-2.331,0.373-4.676,0.488-6.987,0.36l-3.27,6.929l-16.547-5.799l2.033-7.426c-1.875-1.359-3.621-2.927-5.198-4.681l-7.207,2.586 l-7.599-15.799l6.688-3.811c-0.371-2.332-0.487-4.674-0.363-6.985l-6.927-3.273l5.799-16.548l7.426,2.037 c1.361-1.877,2.923-3.622,4.682-5.2l-2.586-7.207l15.801-7.602L407.312,329.822L407.312,329.822z M412.537,337.85 c13.713,0,24.833,11.119,24.833,24.833c0,13.717-11.12,24.836-24.833,24.836c-13.717,0-24.833-11.118-24.833-24.836 C387.703,348.969,398.82,337.85,412.537,337.85z"></path> </g></svg>
                 <span class="form-section">
                    <form action="" method="post">
                        <input type="email" name="emailadid" id="email" required placeholder="<?php esc_html_e("Your Email Address","click-to-call-sticky-mobile-button-lite") ?>">
                        <input name="url" placeholder="<?php esc_html_e("Your Website URL..","click-to-call-sticky-mobile-button-lite") ?>" type="text" required >
                      <?php wp_nonce_field('ctcs_settings_action', 'ctcs_settings_nonce'); ?>
                        <Button class="sln-send-mail-btn button-primary"><?php esc_html_e("SEND", "click-to-call-sticky-mobile-button-lite"); ?></Button>
                    </form>
                    <a href="https://wordpress.org/support/plugin/click-to-call-sticky-mobile-button-lite/reviews/?filter=5#new-post" class="rating-btn" target="_blank" ><button class="sl-rating-btn button-primary" ><?php esc_html_e("Rate Us 5* STAR", "click-to-call-sticky-mobile-button-lite"); ?></button> </a>
                    <div class="sitelinx-banner offer-div">
                        <?php echo '<div><img width="270px" src="' . esc_url(CTCS_URL) . '/img/500-siteLinx.png" alt="Click to call"></div>'; ?>
                        <p class="offer-text"><?php esc_html_e("Top rated SEO service for English websites only.", "click-to-call-sticky-mobile-button-lite");?> <br />
                        <b style='color:red'><?php esc_html_e("Limited time offer for our plugin users only!","click-to-call-sticky-mobile-button-lite");?>
                         </b>
                         <br /> 
                         <?php esc_html_e("For information and contact, visit .","click-to-call-sticky-mobile-button-lite");?> <br>
                          <a href="https://seo.sitelinx.co.il" target="_blank"> https://seo.sitelinx.co.il</a></p>  
                    </div>
                 </span>
                </span>

                <!-- Send mail using php. -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    if (isset($_POST['ctcs_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ctcs_settings_nonce'])), 'ctcs_settings_action')) {
                        if (!empty($_POST["emailadid"]) && !empty($_POST["url"])) {
                
                            $email = sanitize_email(wp_unslash($_POST["emailadid"]));
                            $url = esc_url_raw(wp_unslash($_POST["url"]));
                            $url = esc_textarea($url) . ' From- ' . $email;
                
                            $to = CTCS_ADMIN_EMAIL;
                            $subject = 'SEO Audit Request Through Click to call Plugin';
                            $headers = 'From: ' . $email;
                
                            if (wp_mail($to, $subject, $url, $headers)) {
                                echo '<p>';
                                esc_html_e('Email Sent!.', 'click-to-call-sticky-mobile-button-lite');
                                echo '</p>';
                            } else {
                                echo '<p>';
                                esc_html_e('Issue with sending Email', 'click-to-call-sticky-mobile-button-lite');
                                echo '</p>';
                            }
                
                        } else {
                            echo '<p>';
                            esc_html_e('Please add URL and email.', 'click-to-call-sticky-mobile-button-lite');
                            echo '</p>';
                        }
                    }
                }
                ?>
                

            </div>
             <?php esc_html_e( "Like Click-To-Call Sticky Mobile Button Lite? GIVE US A 5 STAR RATING", "click-to-call-sticky-mobile-button-lite"); ?>  <?php esc_html_e( "Click Here", "click-to-call-sticky-mobile-button-lite" ); ?>
            <a style="text-decoration: none;" href="?ctcs-notice-dismissed=<?php echo esc_attr( wp_create_nonce( 'ctcs_notice_nonce' ) ); ?>"> <?php esc_html_e( "Already rated! | Dismiss forever", "click-to-call-sticky-mobile-button-lite"); ?>.<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( "Dismiss this notice. ", "click-to-call-sticky-mobile-button-lite" ); ?></span></button></a>
        </div>

       <?php
        }
   
    }

    //Dismiss this notice if rated or don't want to see on screen.
    public function ctcs_plugin_notice_dismissed() {
        $user_id = get_current_user_id();
        if ( isset( $_GET['ctcs-notice-dismissed'] ) ) {
            $nonce = sanitize_text_field( wp_unslash( $_GET['ctcs-notice-dismissed'] ) );
            if ( wp_verify_nonce( $nonce, 'ctcs_notice_nonce' ) ) {
                update_user_meta( $user_id, 'ctcs_notice_dismissed', 'true' );
            }
        }
    }

    /**
     * Plugin Activation
     * @return: void
     */  
     public function ctcs_activation(){
        
        //write your codes here...
        
     }
     
    /**
     * Plugin Deactivation
     * @return: void
     */  
    public function ctcs_deactivation(){
        
        $user_id = get_current_user_id();
        delete_user_meta($user_id, 'ctcs_notice_dismissed');
    }

}

/**
 * Main instance of Plugin.
 */
 CTCS_Sitelinx::instance();



add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ctcs_add_action_links' );

function ctcs_add_action_links ( $links ) {
    
    $mylinks = array('<a href="' . admin_url( 'admin.php?page=click-to-call' ) . '">'. __('Settings', 'click-to-call-sticky-mobile-button-lite') .'</a>');
    
    $free_audit_text = __('FREE SEO AUDIT', 'click-to-call-sticky-mobile-button-lite');
    $free_audit_link = '<a target="_blank" href="https://seo.sitelinx.co.il"><b style="color:red;">' . $free_audit_text . '</b></a>';
    $addLink = array($free_audit_link);

   return array_merge(  $mylinks, $links, $addLink );
}

// Function to validate WhatsApp URL
function ctcs_is_valid_whatsapp_url($url) {
    // WhatsApp URL must start with 'https://wa.me/' followed by a phone number
    return preg_match('/^https:\/\/wa\.me\/\+[0-9]+$/i', $url);
}

// Function to validate Facebook URL
function ctcs_is_valid_facebook_url($url) {
    // Facebook URL must start with 'https://www.facebook.com/'
    return preg_match('/^https:\/\/www\.facebook\.com\/.*/i', $url);
}

// Function to validate Instagram URL
function ctcs_is_valid_instagram_url($url) {
    // Instagram URL must start with 'https://www.instagram.com/' followed by a username
    return preg_match('/^https:\/\/www\.instagram\.com\/[a-zA-Z0-9_.]+\/?$/i', $url);
}

// Function to validate Twitter URL
function ctcs_is_valid_twitter_url($url) {
    // Twitter URL must start with 'https://twitter.com/' followed by a username
    return preg_match('/^https:\/\/twitter\.com\/[a-zA-Z0-9_]+\/?$/i', $url);
}

// Function to validate Google Business URL
function ctcs_is_valid_google_business_url($url) {
    // Google Business URL must start with 'https://business.google.com/'
    return preg_match('/^https:\/\/business\.google\.com\/.*/i', $url);
}

// Function to validate Skype URL
function ctcs_is_valid_skype_url($url) {
    // Skype URL must start with 'https://join.skype.com/'
    return preg_match('/^https:\/\/join\.skype\.com\/.*/i', $url);
}

// Function to validate Telegram URL
function ctcs_is_valid_telegram_url($url) {
    // Telegram URL must start with 'https://t.me/' followed by a username or channel name
    return preg_match('/^https:\/\/t\.me\/[a-zA-Z0-9_]+\/?$/i', $url);
}

// Function to validate OnlyFans URL
function ctcs_is_valid_onlyfans_url($url) {
    // OnlyFans URL must start with 'https://onlyfans.com/' followed by a username
    return preg_match('/^https:\/\/onlyfans\.com\/[a-zA-Z0-9_]+\/?$/i', $url);
}

// Function to validate Linktr URL
function ctcs_is_valid_linktr_url($url) {
    // Linktr URL must start with 'https://linktr.ee/' followed by a username
    return preg_match('/^https:\/\/linktr\.ee\/[a-zA-Z0-9_]+\/?$/i', $url);
}

function ctcs_is_valid_phone_number($phone_number) {
    // Regular expression to match a common phone number format with optional country code (e.g., +1234567890)
    return preg_match('/^\+?\d{1,3}\d{9,}$/i', $phone_number);
}

