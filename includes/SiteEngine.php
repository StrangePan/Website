<?php
require_once "SimpleConfig.php";
require_once "parsedown/Parsedown.php";

// define("DEBUG", true);	// For debugging purposes

/**
 * @author Daniel Andrus
 *
 * PHP class designed to act as an engine for the entire site, including page
 * management, template handling, searching, and database handling.
 */
class SiteEngine
{
	// Property declarations
	private $config = NULL;		// Config file from which to pull basic config
	private $data_connection = NULL;	// Database connection maintained until instance is destructed
	
	
	
	/**
	 * @author Daniel Andrus
	 * 
	 * Constructor for the class. Loads up the config. Initializes engine in
	 * preparation for including documents and such. Connects to site database
	 * and maintains this connection until the instance is deallocated.
	 */
	function __construct()
	{
		// Initialize config
		$this -> config = SimpleConfig::fromXMLFile("config.xml");
		if ($this -> config -> error())
		{
			throw $this -> config -> error();
		}
		
		
		// Get database info from config
		$database_engine= $this -> config -> getOption("database.engine");
		$database_name	= $this -> config -> getOption("database.database");
		$database_host	= $this -> config -> getOption("database.host");
		$database_user	= $this -> config -> getOption("database.user");
		$database_pass	= $this -> config -> getOption("database.password");
		
		// Verify that we have what we need
		if (!$database_engine || !$database_name || !$database_host
		   || !$database_user || !$database_pass)
		{
			throw new Exception("Insufficient configuration; missing database connection info.");
		}
		
		// Initialize database connection
		try {
			$this -> data_connection = new PDO("$database_engine:host=$database_host;dbname=$database_name", $database_user, $database_pass);
			
			if (defined("DEBUG"))		// For debugging purposes
			{
				$this -> data_connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		} catch(PDOException $e) {
            
            if (defined("DEBUG"))
            {
                // For debugging purposes; will not reach unless "DEBUG" is defined
                echo $e->getMessage();
            }
            throw ($e);
		}
	}
	
	
	
	/**
	 * @author Daniel Andrus
	 * 
	 * Fetches a piece of non-executable content and converts it to HTML from
	 * whatever formatting language the content is formatted in.
	 * 
	 * @param[in]	content_id - The ID of the content to include into the page.
	 * @param[in]	parse - Allow formatting. Default value is true. Will
	 *				not convert to HTML if this parameter is false.
	 * 
	 * @returns	A string containing the formatted content, or NULL if no content
	 *			was found.
	 */
	public function getContent($content_id, $parse = true) {
		
		if (!is_int($content_id)) {
            
            // No useable data type; throw an error
			throw new InvalidArgumentException("Argument must be an integer.");
			return false;
        }
        
		$content = "";
		
		// Query database for page matching id
		$query = $this -> data_connection -> prepare(
			"SELECT `Content`.*, `Formats`.`Name` as 'Format' FROM `Content`
			LEFT JOIN `Formats` ON `Formats`.`ID` = `Content`.`Format`
			WHERE `Content`.`ID` = :id");
		$query -> bindParam(":id", $content_id, PDO::PARAM_INT);
		$query -> execute();
		$result = $query -> fetchAll();
		
		// Verify results
		if (count($result))
		{
			$content = $result[0]["Content"];
		}
		else	// No results, return null
		{
			return null;
		}
		
		// Perform HTML formatting on code if applicable
		if ($parse)
		{
			switch ($result[0]["Format"])
			{
			default:
			case NULL:			// No known format; no markup possible
			case "HTML":		// Already HTML; no markup necessary
				break;

			case "Markdown":	// Markdown
				$parser = new Parsedown();
				$content = $parser -> text($content);

			}
		}
		
		return $content;
	}
    
	
	
	/**
	 * @author Daniel Andrus
	 * 
	 * Fetches a script from the database and attempts to execute it.
	 * If an error is thrown during execution, the error will be treated
	 * like a regular PHP error. When doing this, exercise extreme caution!
	 * 
	 * @param[in]	code_id - The unique ID or Name of the script in the database.
	 * @param[in]	execute - Allow execution. Default set to true.
	 * 
	 * @returns	A string containing the unexecuted script.
	 */
    public function callCode($code_id, $execute = true) {
        
		if (!is_int($code_id)) {
            
            // No useable data type; throw an error
			throw new InvalidArgumentException("Argument must be an integer.");
			return false;
        }
        
		$content = "";
		
		// Query database for code matching id
		$query = $this -> data_connection -> prepare(
			"SELECT `Code`.*, `Languages`.`Name` as 'Language' FROM `Code`
			LEFT JOIN `Languages` ON `Languages`.`ID` = `Code`.`Language`
			WHERE `Code`.`ID` = :id");
		$query -> bindParam(":id", $code_id, PDO::PARAM_INT);
		$query -> execute();
		$result = $query -> fetchAll();
		
		// Verify results
		if (count($result))
		{
			$content = $result[0]["Content"];
		}
		else	// No results, return null
		{
			return NULL;
		}
		
		// Determine language and execute code accordingly
		if ($execute)
		{
			switch ($result[0]["Language"])
			{
			default:
			case NULL:			// No known language; no execution necessary
				break;

			case "PHP":
				$f = function($code) { eval($code); };
				$f("?>" . $content . "<?php ");
				break;

			}
		}
		
		// Return code, just in case someone else wants it.
		return $content;
		
    }
	
	
	
	/**
	 * @author Daniel Andrus
	 * 
	 * Fetches a snippet of text from the database. Will automatically attempt
	 * to parse it as Markdown and will attempt to execute it as PHP if the
	 * snippet's appropriate flags are set.
	 * 
	 * @param[in]	snippet_id - The unique ID or Name of the snippet in the
	 *   database.
	 * 
	 * @returns	TRUE if the content was fetch and processed successfull or FALSE
	 *   if something went wrong.
	 */
	public function insertSnippet($snippet_id) {
		
		// Verify arguments
		if (!assert('is_int($snippet_id)', "Argument must be an integer")) {
			return FALSE;
		}
        
		$content = "";
		$execute = FALSE;
		$markdown = FALSE;
		
		// Query database for snippet matching id
		$query = $this -> data_connection -> prepare(
			"SELECT * FROM Snippets
			WHERE `ID` = :id");
		$query -> bindParam(":id", $snippet_id, PDO::PARAM_INT);
		$query -> execute();
		$result = $query -> fetchAll();
		
		// Verify results
		if (count($result)) {
			$content = $result[0]["Content"];
			$markdown = $result[0]["ParseMarkdown"];
			$execute = $result[0]["ParsePHP"];
		}
		else {	// No results, return null
			return FALSE;
		}
		
		// Process as PHP if applicable
		if ($execute) {
			ob_start();
			
			$f = function($code) { eval($code); };
			$f("?>" . $content . "<?php ");
			
			$content = ob_get_clean();
		}
		
		// Process as markdown if applicable
		if ($markdown) {
			$parser = new Parsedown();
			$content = $parser -> text($content);
		}
		
		echo $content;
		return TRUE;
	}
	
}
?>
