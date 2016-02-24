<?php

include_once "CallGraphNode.php";
include_once "FunctionSignature.php";
include_once(dirname(__FILE__) . '/../PHP-Parser-master/lib/bootstrap.php');

// Class representing an application's callgraph.
// The nodes of the graph represent function signatures,
// and an edge from f to g states that f calls g in its body.

class CallGraph {

      // Roots of the callgraph
      private $Roots;

      // Map from function signatures to nodes in the callgraph
      private $Nodes;
      
      public function __construct($roots = new SplObjectStorage(), $nodes = new SplObjectStorage()) {

      	     $this->Roots = $roots;
	     $this->Nodes = $nodes;
      }

      // Computes the callgraph of a file.
      public function constructFileCallGraph($filename) {
      	     
	     print "Constructing Call Graph for file " . $filename . "\n";
	     $file = fopen($filename, "r");
	     $parser = new PhpParser\Parser(new PhpParser\Lexer);
	     $contents = fread($file, filesize($filename));

	     try {
	     	 $stmts = $parser->parse($contents);
             } catch(PhpParser\Error $e) {
	         echo "ERROR: Could not parse file during call graph construction: " . $e->getMessage();
		 return NULL;
	     }

	     $className = "";
	     if(count($stmts) == 1 && $stmts[0] instanceof PhpParser\Node\Stmt\Class_) {
	         $callGraph = CallGraph::constructStmtsCallGraph($stmts[0]->stmts, $fileName, $className->name);
	     } else {
	         $callGraph = CallGraph::constructStmtsCallGraph($stmts, $fileName, $className);
	     }
	     
	     return $callGraph;
      }

      public function constructStmtsCallGraph($stmts, $fileName, $className) {
      	     $callGraph = new CallGraph();

	     // Add signature for main.
	     $mainSignature = new FunctionSignature($fileName, $className, "");
	     $mainCallGraphNode = new CallGraphNode($mainSignature);
	     $callGraph->addNode($mainCallGraphNode);
	     
	     // Add node for statements.
	     foreach($stmts as $stmt) {
	         if($stmt instanceof PhpParser\Node\Expr\MethodCall) {
			    	     
	         } else if($stmt instanceof PhpParser\Node\Expr\FuncCall) {
			    	     
	         }
	     }

	     return $callGraph;	     
      }

      // Add a node to the Nodes set if it doesn't exist already.
      public function addNode($mainCallGraphNode) {
      	     $functionRepresentation = $mainCallGraphNode->getFunctionRepresentation();

      	     if(!$Nodes->contains($functionRepresentation)) {
	     	  $Nodes->attach($functionRepresentation, $mainCallGraphNode);
	     }
      }
}
?>