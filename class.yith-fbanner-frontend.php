<?php/** * Main class * * @author Your Inspiration Themes * @package YITH Footer Banner * @version 1.0.3 */if ( !defined( 'YITH_FBANNER' ) ) { exit; } // Exit if accessed directlyif( !class_exists( 'YITH_Footer_Banner_Frontend' ) ) {    /**     * YITH Custom Login Frontend     *     * @since 1.0.0     */class YITH_Footer_Banner_Frontend {    /**     * Plugin version     *     * @var string     * @since 1.0.0     */    public $version;    /**     * Plugin version     *     * @var string     * @since 1.0.0     */    public $template_file = 'fbanner.php';    /**     * Fonts used within the plugin     *     * @var array     * @since 1.0.0     */    public $fonts = array();    /**     * Constructor     *     * @return YITH_Footer_Banner_Frontend     * @since 1.0.0     */    public function __construct( $version ) {        $this->version = $version;        global $yith_fbanner_base;        $yith_fbanner_base = "yith-fbanner-" . basename( get_template_directory() ) . "-hide-banner";        if (( ! yith_fbanner_is_enabled())||(isset($_COOKIE[$yith_fbanner_base]))) return $this;        add_action( 'wp_enqueue_scripts', array( $this, 'fbanner_in_place_inserter_master'), 99 );        add_action('wp_head', array( $this, 'fbanner_style_to_the_head'));        add_action('init', array( $this, 'add_google_fonts'));        add_action('wp_footer', array( $this, 'fbanner_in_place_inserter'), 999);        return $this;    }    public function add_google_fonts() {        $this->fonts = array(            'title_font' => yit_typo_option_to_css( get_option('yith_fbanner_title_font') ),            'p_font' => yit_typo_option_to_css( get_option('yith_fbanner_paragraph_font') ),            'n_font' => yit_typo_option_to_css( get_option('yith_fbanner_newsletter_email_font')),            's_font' => yit_typo_option_to_css( get_option('yith_fbanner_newsletter_submit_font')),            'top_text_font' => yit_typo_option_to_css( get_option('yith_fbanner_newsletter_top_text_font')),            'hider_font' => yit_typo_option_to_css( get_option('yith_fbanner_hide_font')),        );    }    /**     * Return URL of the template     */    public function fbanner_in_place_inserter() {        $plugin_path   = plugin_dir_path(__FILE__) . 'templates/' . $this->template_file;        $template_path = get_template_directory() . '/' . $this->template_file;        $child_path    = get_stylesheet_directory() . '/' . $this->template_file;        foreach ( array( 'child_path', 'template_path', 'plugin_path' ) as $var ) {            if ( file_exists( ${$var} ) ) {                include ${$var};                return;            }        }    }    /**     * Return the url of stylesheet position     *     */    public function stylesheet_url() {        $filename = 'fbanner.css';        $plugin_path   = array( 'path' => plugin_dir_path(__FILE__) . 'assets/css/style.css', 'url' => YITH_FBANNER_URL . 'assets/css/style.css' );        $template_path = array( 'path' => get_template_directory() . '/' . $filename,         'url' => get_template_directory_uri() . '/' . $filename );        $child_path    = array( 'path' => get_stylesheet_directory() . '/' . $filename,       'url' => get_stylesheet_directory_uri() . '/' . $filename );        foreach ( array( 'child_path', 'template_path', 'plugin_path' ) as $var ) {            if ( file_exists( ${$var}['path'] ) ) {                return ${$var}['url'];            }        }        exit();    }public function fbanner_style_to_the_head(){ ?>    <style type="text/css" >        .fbanner{            background:<?php echo get_option('yith_fbanner_background_color');?> <?php if (get_option('yith_fbanner_background_image')):?>url('<?php echo get_option('yith_fbanner_background_image'); ?>')<?php endif;?>;        <?php if (get_option('yith_fbanner_background_image')) :?>            background-repeat:<?php echo get_option('yith_fbanner_background_repeat');?>;            background-position:<?php echo get_option('yith_fbanner_background_position');?>;            background-attachment:<?php echo get_option('yith_fbanner_background_attachment');?>;        <?php endif ?>            <?php if (get_option('yith_fbanner_background_border')):?>border-bottom: 6px solid <?php echo get_option('yith_fbanner_background_border'); endif?>        }       <?php if (get_option('yith_fbanner_background_border')):?>        div#fbannerlogo.yith-border{top:-32px;}        @media (min-width: 768px) and (max-width: 979px) {            div#fbannerlogo.yith-border{top:-7px;}        }        <?php endif ?>        #fbannermess h3,#fbannermess h3 a {        <?php if ($this->fonts): echo $this->fonts['title_font']; endif ?>        }        #fbannermess p,#fbannermess p a {        <?php if ($this->fonts): echo $this->fonts['p_font']; endif ?>        }        .hiderzone a {        <?php if ($this->fonts): echo $this->fonts['hider_font'];endif ?>;            cursor:pointer;            text-decoration: none;        }        form.fbannernewsletter input.text-field{        ::-webkit-input-placeholder { <?php echo $this->fonts['n_font']; ?> !important; }        :-moz-placeholder, ::-moz-placeholder { <?php echo $this->fonts['n_font']; ?> !important; }        :-ms-input-placeholder { <?php echo $this->fonts['n_font']; ?> !important; }            }        div#fbannernews .submit-field {background:<?php echo get_option('yith_fbanner_newsletter_submit_background');?>}        div#fbannernews .submit-field:hover {background:<?php echo get_option('yith_fbanner_newsletter_submit_background_hover');?>}        input.submit-field{<?php if ($this->fonts): echo $this->fonts['s_font'];endif;?>}        .fbannernewsletter INPUT[type="text"] {<?php if ($this->fonts): echo $this->fonts['n_font'];endif;?>}        .fbanner-top-text { <?php echo $this->fonts['top_text_font']; ?>; }        <?php echo get_option('yith_fbanner_custom_style');?>    </style>    <script type="text/javascript">        var templateDir = "yith-fbanner-<?php global $yith_fbanner_base; echo $yith_fbanner_base; ?>-hide-banner";    </script><?php }    /* Enqueue style */    public function fbanner_in_place_inserter_master() {        wp_enqueue_style( 'yith-fbanner-google-fonts', yith_google_fonts_url(), false, $this->version );        wp_enqueue_script( 'jquery-cookie', plugins_url( 'assets/js/jquery.cookie.js', __FILE__ ), array('jquery'), '1.3.1');        wp_enqueue_script( 'yith-fbanner', plugins_url( 'assets/js/fbanner.js', __FILE__ ), array('jquery'), $this->version);        wp_enqueue_style( 'yith-fbanner', $this->stylesheet_url(), array(), $this->version );    }    } // class YITH_Footer_Banner_Frontend}// if class !YITH_Footer_Banner_Frontend