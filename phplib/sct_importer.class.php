<?php
/**
 * Importer for data from Structured Consultation Tool in IMPACT project
 *
 * This class holds the behaviour for importing survey-results data from the
 * SCT in the IMPACT project.
 *
 * @author Neil Benn
 * @todo XXX This is a temporary hack for IMPACT. Remove from core Cohere.
 */
class SctImporter {

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
    global $USER, $CFG, $DB;

    // Create temp DB tables for storing SCT ID to Cohere ID mappings
    $dbhost = $CFG->databaseaddress;
    $dbname = $CFG->databasename;
    $dbuser = $CFG->databaseuser;
    $dbpass = $CFG->databasepass;
    $dsn = "mysql:host={$dbhost};dbname={$dbname}";

    $this->pdo = new PDO($dsn, $dbuser, $dbpass);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $this->pdo->exec('CREATE TABLE IF NOT EXISTS IMPACT_SCT_Votes (' .
               '  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,' .
               '  cohere_id TEXT,' .
               '  agree_votes INTEGER,' .
               '  disagree_votes INTEGER)');

  }

  public function __destruct() {
    $this->pdo = null;
  }

  /**
   * Method to import given JSON string of SCT results
   *
   * The SCT results represent the number of agree-votes and disagree-votes for
   * each statement in a given argument.
   *
   * @param string $json_string JSON string of argument data
   * @return Result
   * @throws Exception
   */
  public function import($json_string) {

    $connections = array();
    $json_object = json_decode($json_string);

    $premises = $json_object->premises;

    foreach ($premises as $premise) {
      $id = $premise->statement->id;
      $cohere_id = $this->_findCohereIdByArtId('proposition-'.$id);

      if($cohere_id) {
        $agree_votes = $premise->statement->agree_votes;
        $disagree_votes = $premise->statement->disagree_votes;
        $this->_storeStatementVotes($cohere_id, $agree_votes, $disagree_votes);
      }
    }

    return new Result('Import SCT data', 'success');
  }

  private function _storeStatementVotes(
    $cohere_id, $agree_votes, $disagree_votes) {
    
    $stmnt = $this->pdo->prepare('INSERT INTO IMPACT_SCT_Votes' .
                           '  (cohere_id, agree_votes, disagree_votes)' .
                           '  VALUES' .
                           '  (:cohere_id, :agree_votes, :disagree_votes)');

    $stmnt->bindParam(':cohere_id', $cohere_id, PDO::PARAM_STR);
    $stmnt->bindParam(':agree_votes', $agree_votes, PDO::PARAM_INT);
    $stmnt->bindParam(':disagree_votes', $disagree_votes, PDO::PARAM_INT);
    $stmnt->execute();
  }

  private function _findCohereIdByArtId($art_id) {
    $stmnt = $this->pdo->prepare('SELECT DISTINCT cohere_id FROM Mappings' .
                                 '  WHERE art_id=:art_id');
    $stmnt->bindParam(':art_id', $art_id, PDO::PARAM_STR);
    $stmnt->execute();

    return ($row = $stmnt->fetch()) ? $row['cohere_id'] : null;
  }
}

?>