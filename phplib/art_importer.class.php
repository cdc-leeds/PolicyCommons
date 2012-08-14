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
  private $agent_link_type;
  private $circumstance_link_type;
  private $consequence_link_type;
  private $value_link_type;
	private $premise_link_type;
	private $conclusion_link_type;
  private $privatedata;
  private $connectionset;
  private $pdo;


  public function __construct() {
    global $USER, $CFG;

    // Add new node-types (i.e. roles) if they don't exist
    $this->issue_node_type = addRole('Issue');
    $this->statement_node_type = addRole('Statement');
    $this->argument_node_type = addRole('Argument');

    // Add new link-types if they don't exist
    $this->addresses_link_type = addLinkType('addresses', 'Neutral');
    $this->agent_link_type = addLinkType('agent', 'Neutral');
    $this->circumstance_link_type = addLinkType('circumstance', 'Neutral');
    $this->consequence_link_type = addLinkType('consequence', 'Neutral');
    $this->value_link_type = addLinkType('value', 'Neutral');
    $this->premise_link_type = addLinkType('has_premise', 'Neutral');
    $this->conclusion_link_type = addLinkType('has_conclusion', 'Neutral');

    $this->privatedata = $USER->privatedata;

    // Temp DB file for storing ART ID to Cohere ID mappins
    $db_file = $CFG->dirAddress . 'tmp/impact_art_cohere_mappings.sqlite';

    $this->pdo = new PDO('sqlite:' . $db_file);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  }

  public function __destruct() {
    $this->pdo = null;
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
    $num_imported = 0;

    foreach ($responses as $response) {
      if ($response->argument->scheme === 'practical_reasoning_as' ||
          $response->argument->scheme === 'Practical Reasoning') {
        $connections = array_merge(
          $connections, $this->importArgument($response->argument, $issue));
        $num_imported += 1;
      }
    }

    $this->connectionset = new ConnectionSet($connections);

    // XXX Add new attribute to ConnectionSet that gives count of arguments
    // imported
    $this->connectionset->num_imported = $num_imported;

    return $this->connectionset;
  }

  private function importArgument($argument, $issue) {
    $conclusion = $argument->conclusion;
    $statement = $conclusion->statement;
    $connections = array();

    // If we have already imported this argument then erase Cohere data and
    // reimport
    $cohere_id = $this->findCohereIdByArtId($argument->id);
    if ($cohere_id) {
      deleteNode($cohere_id);
      $this->deleteIdMapping($argument->id, $cohere_id);
    }

    $argument_node = addNode(
      $statement->text, $statement->quote, $this->privatedata,
      $this->argument_node_type->roleid);

    $this->storeIdMapping($argument->id, $argument_node->nodeid, $issue->id);

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

    // If we have already imported this argument then erase Cohere data and
    // reimport
    $cohere_id = $this->findCohereIdByArtId($statement->id);
    if ($cohere_id) {
      deleteNode($cohere_id);
      $this->deleteIdMapping($statement->id, $cohere_id);
    }

    $node = addNode(
      $statement->text, $statement->quote, $this->privatedata,
      $this->statement_node_type->roleid);

    $this->storeIdMapping($statement->id, $node->nodeid);

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

    // XXX ART incorrectly has 'agent' as a role type in Practical Reasoning
    // Argument Scheme
    $premise_role_to_link_type_id = array(
      'agent'=>$this->agent_link_type,
      'circumstance'=>$this->circumstance_link_type,
      'circumstances'=>$this->circumstance_link_type,
      'consequence'=>$this->consequence_link_type,
      'consequences'=>$this->consequence_link_type,
      'value'=>$this->value_link_type,
      'values'=>$this->value_link_type);

    return (isset($premise_role_to_link_type_id[$premise_role])) ?
      $premise_role_to_link_type_id[$premise_role] :
      $this->premise_link_type;
  }


  /**
   * Method to persistently store mapping between ART ID and Cohere ID
   *
   * @private
   * @param string $art_id ART ID, which is stored as an INTEGER
   * @param string $cohere_id Cohere ID, which is stored as TEXT
   * @param string $issue_id Cohere ID, which is stored as TEXT
   */
  private function storeIdMapping($art_id, $cohere_id, $issue_id = null) {

    $this->pdo->exec('CREATE TABLE IF NOT EXISTS Mappings (' .
               '  id INTEGER PRIMARY KEY,' .
               '  art_id TEXT,' .
               '  cohere_id TEXT,' .
               '  issue_id TEXT)');

    $stmnt = $this->pdo->prepare('INSERT INTO Mappings' .
                           '  (art_id, cohere_id, issue_id)' .
                           '  VALUES' .
                           '  (:art_id, :cohere_id, :issue_id)');

    $stmnt->bindParam(':art_id', $art_id, PDO::PARAM_STR);
    $stmnt->bindParam(':cohere_id', $cohere_id, PDO::PARAM_STR);
    $stmnt->bindParam(':issue_id', $issue_id, PDO::PARAM_STR);
    $stmnt->execute();
  }

  private function findCohereIdByArtId($art_id) {
    $stmnt = $this->pdo->prepare('SELECT cohere_id FROM Mappings' .
                                 '  WHERE art_id=:art_id');
    $stmnt->bindParam(':art_id', $art_id, PDO::PARAM_STR);
    $stmnt->execute();

    return ($row = $stmnt->fetch()) ? $row['cohere_id'] : null;
  }

  private function findArtIdsByIssue($issue_id) {
    $stmnt = $this->pdo->prepare('SELECT art_id FROM Mappings' .
                                 '  WHERE issue_id=:issue_id');
    $stmnt->bindParam(':issue_id', $issue_id, PDO::PARAM_STR);
    $stmnt->execute();
    $records = $stmnt->fetchAll();

    $art_ids = array();
    foreach ($records as $row) {
      $art_ids[] = $row['art_id'];
    }

    return $art_ids;
  }

  /**
   * Method to delete a given ART-to-Cohere mapping from DB table
   *
   * @access private
   * @param string $art_id ART ID
   * @param string $cohere_id Cohere ID
   */
  private function deleteIdMapping($art_id, $cohere_id) {

    $stmnt = $this->pdo->prepare('DELETE FROM Mappings' .
                                 '  WHERE art_id=:art_id' .
                                 '  AND cohere_id=:cohere_id');
    $stmnt->bindParam(':art_id', $art_id, PDO::PARAM_STR);
    $stmnt->bindParam(':cohere_id', $cohere_id, PDO::PARAM_STR);
    $stmnt->execute();
  }

  /**
   * Method to delete ART ID and Corresponding Cohere argument data
   *
   * Method for deleting argument data if it has been removed from ART tool.
   *
   * @param string $art_id ID of argument in ART
   * @todo TODO Need to delete all statements of argument.
   */
  private function deleteArtId($art_id) {
    $cohere_id = $this->findCohereIdByArtId($art_id);
    deleteNode($cohere_id);

    $stmnt = $this->pdo->prepare('DELETE FROM Mappings' .
                                 '  WHERE art_id=:art_id');
    $stmnt->bindParam(':art_id', $art_id, PDO::PARAM_STR);
    $stmnt->execute();
  }
}

?>