<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => __( 'Notice', 'fw' ),
	'description' => __( 'Add a block that displays a notice about something.', 'fw' ),
	'tab'         => __( 'Content Elements', 'fw' ),
	'icon'        => 'unycon unycon-info-circle',
);

//$cfg['page_builder'] = array(
//		'title'       => __( 'Notis', 'fw' ),
//		'description' => __( 'Lägg till ett block som informerar om något specifikt', 'fw' ),
//		'tab'         => __( 'Content Elements', 'fw' ),
//		'icon'        => 'unycon unycon-info-circle',
//);