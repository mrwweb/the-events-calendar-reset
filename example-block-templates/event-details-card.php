<?php
/**
 * Event Details "Card" Template with two-column Venue/Organizer
 * 
 * Use fontSize, textColor, backgroundColor, and heading levels to match your theme
 */
$template = [
	[
		'core/paragraph',
		[ 'placeholder' => 'Event Description…', ],
	],
	[
		'core/group',
		[ 'backgroundColor' => '', 'align' => 'wide' ],
		[
			[ 'tribe/event-datetime' ],
			[	
				'core/columns',	[ 'align' => 'wide' ],
				[
					[
						'core/column', [],
						[
							[
								'core/heading',
								[
									'level' => 2,
									'content' => 'Where',
									'fontSize' => '',
									'textColor' => '',
								]
							],
							[ 'tribe/event-venue' ]
						]
					],
					[
						'core/column', [],
						[
							[
								'core/heading',
								[
									'level' => 2,
									'content' => 'Organizer',
									'fontSize' => '',
									'textColor' => '',
								]
							],
							[ 'tribe/event-organizer' ]
						]
					],
				]
			],
			[ 'tribe/event-website' ],
		]
	],
	[
		'core/paragraph',
		[ 'placeholder' => 'Additional Event Details…', ],
	],
];