<?php
/**
 * ReportWriter class
 *
 * XXX Solely for the purposes of the IMPACT project. Remove as a core part of
 * the Cohere platform.
 */
class ReportWriter {
  private $_document;
  private $_content;
  private $_sections = array();
  private $_styles = array();
  private $_levels = array();

  /**
   * Constructor
   *
   * @var $document PHPRtfLite rtf document instance
   */
  public function __construct(PHPRtfLite $document) {
    $this->_content = $content;
    $this->_document = $document;

    $this->_styles['title']['font'] = new PHPRtfLite_Font(24, Arial);
    $this->_styles['title']['font']->setBold();
    $this->_styles['title']['par'] = new PHPRtfLite_ParFormat();
    $this->_styles['title']['par']->setSpaceBefore(24);
    $this->_styles['title']['par']->setSpaceAfter(24);

    $this->_styles['h1']['font'] = new PHPRtfLite_Font(16, 'Arial');
    $this->_styles['h1']['font']->setBold();
    $this->_styles['h1']['par'] = new PHPRtfLite_ParFormat();
    $this->_styles['h1']['par']->setSpaceBefore(16);
    $this->_styles['h1']['par']->setSpaceAfter(8);

    $this->_styles['h2']['font'] = new PHPRtfLite_Font(14, 'Arial');
    $this->_styles['h2']['font']->setBold();
    $this->_styles['h2']['par'] = new PHPRtfLite_ParFormat();
    $this->_styles['h2']['par']->setSpaceBefore(8);
    $this->_styles['h2']['par']->setSpaceAfter(4);

    $this->_styles['h3']['font'] = new PHPRtfLite_Font(13, 'Arial');
    $this->_styles['h3']['font']->setBold();
    $this->_styles['h3']['par'] = new PHPRtfLite_ParFormat();
    $this->_styles['h3']['par']->setSpaceBefore(4);
    $this->_styles['h3']['par']->setSpaceAfter(2);

    $this->_styles['body']['font'] = new PHPRtfLite_Font(12, 'Arial');
    $this->_styles['body']['par'] = new PHPRtfLite_ParFormat();
    $this->_styles['body']['par']->setSpaceBefore(1);
    $this->_styles['body']['par']->setSpaceAfter(2);

    $this->_styles['Issue'] = $this->_styles['h3'];
    $this->_levels = array('title', 'h1', 'h2', 'h3', 'body');
  }

  /**
   * Method to prepare the document
   *
   * @var $content ConnectionSet Contents of the consultation-debate
   */
  public function prepareDocument($content) {
    $this->_content = $content;

    // Get total number of issues and responses
    $num_issues = $content->num_issues;
    $num_responses = $content->num_responses;

    $content_tree = $this->_buildContentTree($content->connections);
    $content_elements = $this->_writeContentTree(
      $content_tree->root, 0, $content_tree);

    $title_page = array_shift($content_elements);
    $toc_page = $this->_newElement('Contents', $this->_styles['h1']);
    $exec_page = $this->_newElement('Executive Summary', $this->_styles['h1']);

    $this->_newSection(array($title_page));
    $this->_newSection(array($toc_page));
    $this->_newSection(array($exec_page));
    $this->_newSection($content_elements);

    $this->_writeSections();
  }

  private function _buildContentTree($connections) {
    // The root of the debate is the 'from' node in the first connection
    $root = $connections[0]->from;

    $node_index = array();
    $node_children_index = array();

    foreach ($connections as $connection) {
      $from_node = $connection->from;
      $to_node = $connection->to;

      if (! isset($node_index[$from_node->nodeid])) {
        $node_index[$from_node->nodeid] = $from_node;
      }

      if (! isset($node_index[$to_node->nodeid])) {
        $node_index[$to_node->nodeid] = $to_node;
      }

      if (! isset($node_children_index[$from_node->nodeid])) {
        $node_children_index[$from_node->nodeid] = array();
      }

      $node_children_index[$from_node->nodeid][] = $to_node->nodeid;
    }

    $tree = new stdClass();
    $tree->root = $root;
    $tree->node_index = $node_index;
    $tree->node_children_index = $node_children_index;

    return $tree;
  }

  private function _writeContentTree($root, $level, $tree) {
    $elements = array();

    $style = $this->_styles[$this->_levels[$level]];
    if (isset($this->_styles[$root->role->name])) {
      $style = $this->_styles[$root->role->name];
    }

    $elements[] = $this->_newElement($root->name, $style);

    $children = $tree->node_children_index[$root->nodeid];
    if (! empty($children)) {
      $next_level = $level + 1;

      foreach ($children as $child_id) {
        $child_node = $tree->node_index[$child_id];
        $elements = array_merge(
          $elements, $this->_writeContentTree($child_node, $next_level, $tree));
      }
    }

    return $elements;
  }

  private function _newSection(array $elements = array()) {

    $section = new PHPRtfLite_Container_Section($this->_document);

    foreach ($elements as $element) {
      $section->addElement($element);
    }

    $this->_sections[] = $section;
  }

  private function _newElement($text, $style) {
    return new PHPRtfLite_Element(
      $this->_document, $text, $style['font'], $style['par']);
  }

  private function _writeSections() {
    foreach ($this->_sections as $section) {
      $this->_document->addSection($section);
    }
  }

  /**
   * Method to send document as attachment to client browser
   *
   * @var $filename string Name of file that client will download
   */
  public function downloadDocument($filename = 'report') {
    return $this->_document->sendRtf($filename);
  }
}
?>