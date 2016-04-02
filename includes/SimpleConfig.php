<?php
/**
 * Simple PHP class for parsing commong config file formats and making the
 * values inside easily accessable. Once parsed, nested config options can be
 * referenced using a period (.) delimited string.
 * E.G.: "database.table.prefix"
 *
 * Notes:
 * Class cannot be instantiated directly; must be done through static methods.
 * Parsed config options are read-only.
 * Once a simple config option has
 * Supports XML, <del>YAML</del>, and JSON formats.
 * - Use SimpleConfig::fromXMLFile($file) for XML files.
 * - <del>Use SimpleConfig::fromYAMLFile($file) for YAML files.</del>
 * - Use SimpleConfig::fromJSONFile($file) for JSON files.
 */
class SimpleConfig
{
	// Property definitions
	private $config = NULL;
	private $file = NULL;
	private $error = FALSE;



	// DATA FETCHING/CHECKING FUNCTIONS

	/**
	 * Checks to see if a specific option is defined in the config.
	 * Nested options must be period (.) delimited.
	 * E.g.: "database.table.prefix"
	 */
	public function optionExists($option) {
		if (!is_string($option)) {
			throw new InvalidArgumentException("Argument must be a string.");
		}

		// Explode path to option
		$path = explode(".", $option);

		// Create a reference to our existing settings
		$s =& $this -> config;

		// Search through nested arrays until we find what we need
		foreach ($path as $node) {
			if (isset($s[$node])) {
				$s =& $s[$node];
			} else {

				// The option we're searching for doesn't exist
				return false;
			}
		}

		// If we reach this point, it means we found find what we're
		// looking for.
		return true;
	}

	/**
	 * Returns the value of the given option if it exists, NULL otherwise.
	 * Return type is mixed; could be array, string, number, or whatever else
	 *   the YAML parser returns.
	 */
	public function getOption($option) {
		if (!is_string($option)) {
			throw new InvalidArgumentException("Argument must be a string.");
		}

		// Explode path to option
		$path = explode(".", $option);

		// Create a reference to our existing settings
		$s =& $this->config;

		// Search through nested arrays until we find what we need
		foreach ($path as $node) {
			if (isset($s[$node])) {
				$s =& $s[$node];
			} else {

				// The option we're searching for doesn't exist; return null
				return NULL;
			}
		}

		// If we reach this point, it means we found what we're
		// looking for. $s contains the value we need to return.
		return SimpleConfig::deepClone($s);
	}

	/**
	 * Checks if an error was encountered while parsing files.
	 * If an exception occured, returns the exception itself.
	 * If an exception did not occur, returns FALSE.
	 */
	public function error() {
		return $this->error;
	}



	// PUBLIC STATIC INSTANTIATION FUNCTIONS

	/**
	 * Creates and fills a new instance of SimpleConfig with content from an XML
	 * file.
	 */
	public static function fromXMLFile($file) {
		if (!is_string($file)) {
			throw new InvalidArgumentException("Argument must be string of path to file.");
		}
		$instance = new SimpleConfig();
		try {
			$input = file_get_contents($file);
			$content = new SimpleXMLElement($input);
			$content = SimpleConfig::convertXMLToArray($content);
			$instance -> config = $content;
			$instance -> file = realpath($file);
		}
		catch (Exception $e) {
			$instance -> error = $e;
		}
		return $instance;
	}

	/**
	 * Creates and fills a new instance of SimpleConfig with content from a YAML
	 * file.
	 */
	// public static function fromYAMLFile($file) {
	// 	if (!is_string($file)) {
	// 		throw new InvalidArgumentException("Argument must be string of path to file.");
	// 	}
	// 	$instance = new SimpleConfig();
	// 	try {
	// 		$input = file_get_contents($file);
	// 		$content = yaml_parse($input);
	// 		$instance -> config = $content;
	// 		$instance -> file = realpath($file);
	// 	}
	// 	catch (Exception $e) {
	// 		$instance -> error = $e;
	// 	}
	// 	return $instance;
	// }

	/**
	 * Creates and fills a new instance of SimpleConfig with content from a JSON
	 * file.
	 */
	public static function fromJSONFile($file) {
		if (!is_string($file)) {
			throw new InvalidArgumentException("Argument must be string of path to file.");
		}
		$instance = new SimpleConfig();
		try {
			$input = file_get_contents($file);
			$content = json_decode($input, true);
			$instance -> config = $content;
			$instance -> file = realpath($file);
		}
		catch (Exception $e) {
			$instance -> error = $e;
		}
		return $instance;
	}



	// PRIVATE HELPER FUNCTIONS

	/**
	* Recursive function to completely clone an object, included nested arrays.
	*/
	private static function deepClone($object) {
		$object = is_object($object) ? clone($object) : $object;
		if (is_array($object)) {
			foreach ($object as $key => $value) {
				$object[$key] = SimpleConfig::deepClone($value);
			}
		}
		return $object;
	}

	/**
	* Converts a SimpleXML object to an array recursively.
	*/
	private static function convertXMLToArray($xml) {
		$array = array();
		foreach ((array) $xml as $key => $value) {
			$array[$key] = is_object($value) ? SimpleConfig::convertXMLToArray($value) : $value;
		}
		return $array;
	}

}
?>
