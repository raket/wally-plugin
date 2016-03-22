<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
		'image'            => array(
				'type'  => 'upload',
				'label' => __( 'Upload', 'fw' ),
				'desc'  => __( 'Choose a existing image or upload a new one.', 'fw' )
		),
		'image-link-group' => array(
				'type'    => 'group',
				'options' => array(
						'link'   => array(
								'type'  => 'text',
								'label' => __( 'Image link', 'fw' ),
								'desc'  => __( 'Add a web link (url) if you want the image to link to that url.', 'fw' )
						),
						'advanced' => array(
								'type'         => 'switch',
								'label'        => __( 'Advanced', 'fw' ),
								'desc'         => __( 'Activate this function to allow the image to be displayed as a fullscreen image.', 'fw' ),
								'right-choice' => array(
										'value' => true,
										'label' => __( 'Yes', 'fw' ),
								),
								'left-choice'  => array(
										'value' => false,
										'label' => __( 'No', 'fw' ),
								),
						),
						'size' => array(
								'type'  => 'select',
								'label' => __('Size', 'fw'),
								'desc'  => __('Choose a image size', 'fw'),
								'choices' => array(
										'small' => __('Small', 'fw'),
										'regular' => __('Medium', 'fw'),
										'large' => __('Large', 'fw'),
								)
						),
						'fit' => array(
							'type'  => 'select',
							'label' => __('Fit', 'fw'),
							'desc'  => __('Choose how to fit the image to the container', 'fw'),
							'choices' => array(
								'fit-cover' => __('Help me with the best possible fit', 'fw'),
								'fit-height' => __('Fit the image by the height', 'fw'),
								'fit-width' => __('Fit the image by the width', 'fw')
							)
						)

				)
		)
);



//$options = array(
//	'image'            => array(
//		'type'  => 'upload',
//		'label' => __( 'Ladda upp', 'fw' ),
//		'desc'  => __( 'Välj en befintlig, eller ladda upp en ny bild', 'fw' )
//	),
//	'image-link-group' => array(
//		'type'    => 'group',
//		'options' => array(
//			'link'   => array(
//				'type'  => 'text',
//				'label' => __( 'Bildlänk', 'fw' ),
//				'desc'  => __( 'Fyll i det här fältet med en webblänk om du vill att bilden länkar dit.', 'fw' )
//			),
//			'advanced' => array(
//				'type'         => 'switch',
//				'label'        => __( 'Avancerad', 'fw' ),
//				'desc'         => __( 'Aktivera den här funktionen för att tillåta att bilden visas i fullskärm', 'fw' ),
//				'right-choice' => array(
//					'value' => true,
//					'label' => __( 'Ja', 'fw' ),
//				),
//				'left-choice'  => array(
//					'value' => false,
//					'label' => __( 'Nej', 'fw' ),
//				),
//			),
//			'size' => array(
//				'type'  => 'select',
//				'label' => __('Storlek', 'fw'),
//				'desc'  => __('Välj en bildstorlek', 'fw'),
//				'choices' => array(
//					'small' => __('Liten', 'fw'),
//					'regular' => __('Mellan', 'fw'),
//					'large' => __('Stor', 'fw'),
//				)
//			)
//		)
//	)
//);
//
