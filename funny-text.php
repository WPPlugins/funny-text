<?php
/*
 * Plugin Name: Funny Text 
 * Plugin URI: https://wordpress.org/plugins/funny-text/
 * Description: A WordPress plugin for Create funny and crazy moving texts in a simple way.
 * Version: 1.1
 * Author: Anshul Labs
 * Author URI: http://anshullabs.xyz
 * textdomain: funny-text
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
/*
Copyright 2012  Anshul Labs  (email : hello@anshullabs.xyz)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * A WordPress plugin for Create funny and crazy moving texts in a simple way.
 * @package     funny-text
 * @author      anshuln90
 * @author_url  http://anshullabs.xyz
 * @copyright   Copyright (c) 2016 Anshul G.
*/

// Plugin enqueue style and script 
add_action('wp_enqueue_scripts', 'funnytext_wp_enqueue_scripts');
function funnytext_wp_enqueue_scripts() {
	wp_enqueue_style( 'funnytext-style', plugins_url('assets/jquery.funnyText.css',__FILE__));
	wp_enqueue_script( 'funnytext-js', plugins_url('assets/jquery.funnyText.js',__FILE__), array('jquery'), '1.1', true );	
}

// add admin menu.
add_action( 'admin_menu', 'funnytext_add_admin_menu' );
function funnytext_add_admin_menu(){ 
	add_options_page( 'Funny Text Setting', 'Funny Text', 'manage_options', 'funny-text-setting', 'funnytext_options_page' );
}

// admin menu callback function. 
function funnytext_options_page(){  ?>
<div class="wrap">
    <h2>About Funny Text Plugin</h2>
    <div class="wrap-inner">
        <h2> For Funny Text use a below shortcode  </h2>
        <code>[funnytext text="Your Text" speed="1000" color="#000000" activeColor="#ffffff" fontSize="18px" direction="both" borderColor="#333333" ]</code>

        <h3>Shortcode Options</h3> 
        <ol>
            <li><b>text:</b>(default Anshul Labs) Defines your text which you want to animate. </li>
            <li><b>speed:</b> (default 700) Defines the speed in which the letters change in milliseconds.</li>
            <li><b>borderColor:</b> (default black) Defines the color of the border when the text is active. This option won't take effect when if the browser doesn't support CSS3.</li>    
            <li><b>activeColor:</b> (default white) Defines the color of the text when it is active.</li>
            <li><b>color:</b> (default black) Defines the color of the text on start.</li>
            <li><b>fontSize:</b> (default 30px) Defines the size of the font.</li>
            <li><b>direction :</b> (default both) Defines the direction of the letters movement. It can be both, horizontal or vertical.</li>
        </ol>        
    </div>
</div>
<?php
}

// Add Shortcode
add_shortcode( 'funnytext', 'funnytext_shortcode_fnc' );
function funnytext_shortcode_fnc( $atts ) {
    // Attributes
    $ft_atts = shortcode_atts(
                array(
                    'speed' => '700',
                    'color' => '#000000',
                    'activeColor' => '#ffffff',
                    'fontSize' => '30px',
                    'direction' => 'both',
                    'borderColor' => '#000000',
                    'text' => 'Anshul Labs',
                ),
                $ft_atts
            );

    ob_start();
    $html = '<div class="ft-funnytext">'.$ft_atts["text"].'</div>';
    $html .= "<script>
                    jQuery(document).ready(function() {
                        jQuery('.ft-funnytext').funnyText({
                            speed: ".$ft_atts['speed'].",
                            borderColor: '".$ft_atts['borderColor']."',
                            activeColor: '".$ft_atts['activeColor']."',
                            color: '".$ft_atts['color']."',
                            fontSize: '".$ft_atts['fontSize']."',
                            direction: '".$ft_atts['direction']."'
                        });
                    });
                </script>";            
    ob_end_clean(); 
    return $html;
}
?>