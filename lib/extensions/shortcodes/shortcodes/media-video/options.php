<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
		'video' => array(
				'type'  => 'multi-picker',
				'label' => false,
				'desc'  => false,
				'value' => array(
						'video-type' => 'url',
				),
				'picker' => array(
						'video-type' => array(
								'label'   => __('Choose video type', 'fw'),
								'desc'    => __('Choose if you want to link to the video with a URL och if you want to pick one from the media library.',  'fw'),
								'type'    => 'select', // or 'short-select'
								'choices' => array(
										'url'  => __('Link with URL', 'fw'),
										'upload' => __('Pick one from the media library.', 'fw')
								)
						)
				),
				'choices' => array(
						'url' => array(
								'video' => array(
										'type'  => 'text',
										'label' => 'URL'
								),
						),
						'upload' => array(
								'video' => array(
										'Video' => 'URL',
										'type'  => 'upload',
										'images_only' => false,
										'files_ext' => array('mp4', 'webm', '3gp'),
										'extra_mime_types' => array( 'video/webm, webm', 'video/3gp, 3gp', 'video/mp4, mp4')
								)
						),
				),
				'show_borders' => false,
		),
		'title' => array(
			'type'  => 'text',
			'label' => __( 'Title', 'fw' )
		),
		'width'  => array(
				'type'  => 'text',
				'label' => __( 'Video Width', 'fw' ),
				'desc'  => __( 'Enter a value for the width', 'fw' ),
				'value' => 300
		),
		'height' => array(
				'type'  => 'text',
				'label' => __( 'Video Height', 'fw' ),
				'desc'  => __( 'Enter a value for the height', 'fw' ),
				'value' => 200
		)
);


//$options = array(
//	'video' => array(
//		'type'  => 'multi-picker',
//		'label' => false,
//		'desc'  => false,
//		'value' => array(
//				'video-type' => 'url',
//		),
//		'picker' => array(
//				'video-type' => array(
//						'label'   => __('Välj videotyp', 'fw'),
//						'desc'    => __('Välj om du vill länka filmen via en URL eller välja en från mediabiblioteket.'),
//						'type'    => 'select', // or 'short-select'
//						'choices' => array(
//								'url'  => __('Länka via URL', 'fw'),
//								'upload' => __('Välj från mediabiblioteket', 'fw')
//						)
//				)
//		),
//		'choices' => array(
//				'url' => array(
//						'video' => array(
//								'type'  => 'text',
//								'label' => 'URL'
//						),
//				),
//				'upload' => array(
//						'video' => array(
//								'Video' => 'URL',
//								'type'  => 'upload',
//								'images_only' => false,
//								'files_ext' => array('mp4', 'webm', '3gp'),
//								'extra_mime_types' => array( 'video/webm, webm', 'video/3gp, 3gp', 'video/mp4, mp4')
//						)
//				),
//		),
//		'show_borders' => false,
//	),
//	'width'  => array(
//		'type'  => 'text',
//		'label' => __( 'Video Width', 'fw' ),
//		'desc'  => __( 'Enter a value for the width', 'fw' ),
//		'value' => 300
//	),
//	'height' => array(
//		'type'  => 'text',
//		'label' => __( 'Video Height', 'fw' ),
//		'desc'  => __( 'Enter a value for the height', 'fw' ),
//		'value' => 200
//	)
//);
