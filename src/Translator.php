<?php

declare(strict_types=1);

namespace TLS;

class Translator {

    public string $file;

    /**
     * @var string $file should be the path to your file with translations only YML is supported as of now
     */
    public function __construct(string $file) {
        $this->file = $file;
    }

    public function translate(string $key, array $args = []) {
        $data = yaml_parse_file($this->file);
		$vars = explode(".", $key);
		$base = $data[$vars[0]] ?? $key;
		array_shift($vars);
		foreach($vars as $var) {
			if (!isset($base[$var])) {
				return $key;
			}
			$base = $base[$var];
		}

		foreach($args as $arg => $val) {
			$base = str_replace('{%' . $arg . '}', $val, $base);
		}

		return $base;
    }

}