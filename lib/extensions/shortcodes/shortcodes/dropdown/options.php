<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
		'title' => array(
				'type'  => 'text',
				'label' => __( 'Title', 'fw' ),
				'desc'  => __( 'Write a text to be displayed in the button, before a alternative has been selected.', 'fw' ),
		),
		'note' => array(
				'type'  => 'multi-picker',
				'label' => __( 'Notice', 'fw' ),
				'picker' => array(
						'display_note' => array(
								'label' => false,
								'value' => 1,
								'type' => 'switch',
								'text' => __( 'Show notice', 'fw' ),
								'desc'  => __( 'Displays a notice at the top of the list with different alternatives.', 'fw' ),
								'left-choice' => array(
										'value' => 'note',
										'label' => __('On', 'fw'),
								),
								'right-choice' => array(
										'value' => false,
										'label' => __('Off', 'fw'),
								),
						)
				),
				'choices' => array(
						'note' => array(
								'text' => array(
										'type'  => 'text',
										'label' => false,
										'desc'  => __( 'Write the text to be shown in the notice.', 'fw' ),
										'value' => __( 'Related content', 'fw')
								),
						)
				)

		),

		'alternatives' => array(
				'type'  => 'addable-box',
				'label' => __('Alternatives', 'fw'),
				'desc'  => __('Add alternatives to the button', 'fw'),
				'template' => '{{=label}}',
				'box-options' => array(
						'value' => array(
								'type' => 'text' ,
								'label' => __('Value', 'fw'),
								'desc'  => __('The value that the alternative represents.')
						),
						'label' => array(
								'type' => 'text' ,
								'label' => __('Name', 'fw'),
								'desc'  => __('The alternatives name, that should be visible to the user.')
						),
				),
				'limit' => 0,
		)
);

//$options = array(
//	'title' => array(
//		'type'  => 'text',
//		'label' => __( 'Titel', 'fw' ),
//		'desc'  => __( 'Ange texten som visas i knappen innan ett alternativ är valt.', 'fw' ),
//	),
//	'note' => array(
//		'type'  => 'multi-picker',
//		'label' => __( 'Notis', 'fw' ),
//		'picker' => array(
//			'display_note' => array(
//				'label' => false,
//				'value' => 1,
//				'type' => 'switch',
//				'text' => __( 'Visa notis', 'fw' ),
//				'desc'  => __( 'Visar en notis längst upp i listan med alternativ.', 'fw' ),
//				'left-choice' => array(
//					'value' => 'note',
//					'label' => __('På', 'fw'),
//				),
//				'right-choice' => array(
//					'value' => false,
//					'label' => __('Av', 'fw'),
//				),
//			)
//		),
//		'choices' => array(
//			'note' => array(
//				'text' => array(
//					'type'  => 'text',
//					'label' => false,
//					'desc'  => __( 'Ange texten som ska visas i notisen.', 'fw' ),
//					'value' => __( 'Det här är relaterat innehåll', 'fw')
//				),
//			)
//		)
//
//	),
//
//	'alternatives' => array(
//		'type'  => 'addable-box',
//		'label' => __('Alternativ', 'fw'),
//		'desc'  => __('Lägg till alternativ i knappen.', 'fw'),
//		'box-options' => array(
//			'value' => array(
//				'type' => 'text' ,
//				'label' => __('Värde', 'fw'),
//				'desc'  => __('Det värde som alternativet representerar.')
//			),
//			'label' => array(
//				'type' => 'text' ,
//				'label' => __('Namn', 'fw'),
//				'desc'  => __('Det namn som visas för alternativet.')
//			),
//		),
//		'template' => '{{- label }}',
//		'limit' => 0,
//	)
//);
