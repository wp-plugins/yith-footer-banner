<?php/** * Functions * * @author Your Inspiration Themes * @package YITH Footer Banner * @version 1.0.2 */if ( !defined( 'YITH_FBANNER' ) ) { exit; } // Exit if accessed directlyif( !function_exists( 'yith_fbanner_is_enabled' ) ) {    /**     * Returns if the plugin is enabled     *     * @return bool     * @since 1.0.0     */    function yith_fbanner_is_enabled() {        return get_option('yith_fbanner_enable') == '1';    }}