<?php 

/* secure */ 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

    // meta options //
	$options_meta = array( 
        //start options meta as array
		array("name" => "Open by Default",
              "desc" => "Open this accordion on page load",
              "id" => "open_default",
              "type" => "checkbox",
              "std" => "0"),
		array("name" => __("Content", "wp_accordions"),
              "desc" => __("Content of Accordion", "wp_accordions"),
              "id" => "content",
              "type" => "textarea",
              "std" => __("Content", "wp_accordions")),
       
        /// end meta   
	 );
?>