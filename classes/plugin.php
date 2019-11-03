<?php

namespace Kntnt\Auto_Excerpt_Generator;

class Plugin extends Abstract_Plugin {

	public function classes_to_load() {

		return [
			'public' => [
				'init' => [
					'Generator',
				],
			],
			'admin' => [
				'init' => [
					'Settings',
				],
			],
		];

	}

}
