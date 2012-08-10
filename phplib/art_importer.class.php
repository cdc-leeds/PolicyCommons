<?php
/**
 * Importer for data from Argument Reconstruction Tool (ART) in IMPACT project
 *
 * This class holds the behaviour for importing argumentation data from the
 * Argument Reconstruction Tool (ART) in the IMPACT project.
 *
 * @author Neil Benn
 * @todo XXX This is a temporary hack for IMPACT. Remove from core Cohere.
 */
class ArtImporter {

	private $issue_node_type;
	private $statement_node_type;
	private $argument_node_type;
  private $circumstance_link_type;
  private $consequence_link_type;
  private $value_link_type;
	private $premise_link_type;
	private $conclusion_link_type;
  private $privatedata;


  public function __construct() {
    global $USER;

    // Add new node-types (i.e. roles) if they don't exist
    $this->issue_node_type = addRole('Issue');
    $this->statement_node_type = addRole('Statement');
    $this->argument_node_type = addRole('Argument');

    // Add new link-types if they don't exist
    $this->addresses_link_type = addLinkType('addresses', 'Neutral');
    $this->circumstance_link_type = addLinkType('circumstance', 'Neutral');
    $this->consequence_link_type = addLinkType('consequence', 'Neutral');
    $this->value_link_type = addLinkType('value', 'Neutral');
    $this->premise_link_type = addLinkType('has_premise', 'Neutral');
    $this->conclusion_link_type = addLinkType('has_conclusion', 'Neutral');

    $this->privatedata = $USER->privatedata;

  }

  /**
   * Method to import given JSON string of argument data
   *
   * The argumentation data represents the arguments that respond to a single
   * issue. This issue should already be stored in the Cohere database,
   * otherwise an Exception is thrown.
   *
   * @param string $json_string JSON string of argument data
   * @return ConnectionSet A ConnectionSet object of imported connections
   * @throws Exception
   */
  public function import($json_string) {

    $connections = array();
    $json_object = json_decode($json_string);


    $issue = $json_object->issue;

    if (! getNode($issue->id) instanceof CNode) {
      throw new Exception('The Issue object is not recognised.');
    }

    $responses = $json_object->responses;

    foreach ($responses as $response) {
      $connections = array_merge(
        $connections, $this->importArgument($response->argument, $issue));
    }

    return new ConnectionSet($connections);
  }

  private function importArgument($argument, $issue) {
    $conclusion = $argument->conclusion;
    $statement = $conclusion->statement;
    $connections = array();

    $argument_node = addNode(
      $statement->text, $statement->quote, $this->privatedata,
      $this->argument_node_type->roleid);

    $this->storeIdMapping($argument->id, $argument_node->nodeid);

    $connections[] = addConnection(
      $argument_node->nodeid, $this->argument_node_type->roleid,
      $this->addresses_link_type->linktypeid, $issue->id,
      $this->issue_node_type->roleid);

    foreach ($argument->premises as $premise) {
      $connections[] = $this->importPremise($premise, $argument_node);
    }

    return $connections;
  }

  private function importPremise($premise, $argument_node) {
    $statement = $premise->statement;

    $node = addNode(
      $statement->text, $statement->quote, $this->privatedata,
      $this->statement_node_type->roleid);

    $premise_role = $statement->scheme_role;

    $link_type = $this->getLinkTypeFromPremiseRole($premise_role);

    return addConnection(
      $argument_node->nodeid, $this->argument_node_type->roleid,
      $link_type->linktypeid, $node->nodeid,
      $this->statement_node_type->roleid);
  }

  /**
   * Method to retrieve Cohere link-type for given premise-role label
   *
   * Method looks up hard-coded mapping (in assocative array) of premise-roles
   * such as 'circumstance' and 'consequence' and returns corresponding Cohere
   * link-type object. If premise-role isn't mapped then it returns Premise
   * link-type as a default.
   *
   * @private
   * @param string $premise_role Name of the premise role e.g. 'circumstance'
   * @return LinkType Cohere link-type for the given premise role label
   */
  private function getLinkTypeFromPremiseRole($premise_role) {
    $premise_role = strtolower($premise_role);

    $premise_role_to_link_type_id = array(
      'circumstance'=>$this->circumstance_link_type,
      'consequence'=>$this->consequence_link_type,
      'value'=>$this->value_link_type);

    return (isset($premise_role_to_link_type_id[$premise_role])) ?
      $premise_role_to_link_type_id[$premise_role] :
      $this->premise_link_type;
  }

  /**
   * Method to persistently store mapping between ART ID and Cohere ID
   *
   * Method creates SQLite DB in a flat file
   *
   * @private
   * @param string $art_id ART ID, which is stored as an INTEGER
   * @param string $cohere_id Cohere ID, which is stored as TEXT
   */
  private function storeIdMapping($art_id, $cohere_id) {
    global $CFG;

    $db_file = $CFG->dirAddress . 'tmp/impact_art_cohere_mappings.sqlite';

    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec('CREATE TABLE IF NOT EXISTS Mappings (' .
               '  id INTEGER PRIMARY KEY,' .
               '  art_id INTEGER,' .
               '  cohere_id TEXT)');

    $stmnt = $pdo->prepare('INSERT INTO Mappings' .
                           '  (art_id, cohere_id)' .
                           '  VALUES' .
                           '  (:art_id, :cohere_id)');

    $stmnt->bindParam(':art_id', $art_id, PDO::PARAM_INT);
    $stmnt->bindParam(':cohere_id', $cohere_id, PDO::PARAM_STR);
    $stmnt->execute();

    $pdo = null;
  }
}

?>