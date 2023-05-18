<?php
/**
 * Two-column Venue / Organizer starter template
 * 
 * Add name of color on line 19 to set background color behind Venue and Organizer
 */
$template = [
	[ 'tribe/event-datetime' ],
	[
		'core/paragraph',
		[
			'placeholder' => __( 'Add Event Description...', 'the-events-calendar' ),
		],
	],
	[ 'tribe/event-website' ],
	[	
		'core/columns',
		[
			'backgroundColor' => '',
		],
		[
			[
				'core/column', [], [ [ 'tribe/event-venue' ] ]
			],
			[
				'core/column', [], [ [ 'tribe/event-organizer' ] ]
			]
		]
	],
];