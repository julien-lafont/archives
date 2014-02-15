<?php

class blogtumblrComponents extends sfComponents
{

  public function executeListeDerniersArticles()
  {
  		//$nb = $this->getVar('nb') ? $this->getVar('nb') : 5;
	
		if (isset($_GET['reset'])) {
			
			
			// Fetch depuis la source du blog
			$xml = new SimpleXMLElement('http://blog.studio-dev.fr/rss?reload='.time(), NULL, TRUE);
			$nodes = $xml->xpath('//item[position()<=5]');  
			
			// Met en forme
			$data ="";
			foreach($nodes as $node) {
				echo $node->title."<br />";
			  $data .= "<li>";  
			  $titre = $node->title;
			  $description = $node->description;
			  $link = $node->link;
			  
			  $data .= '<a href="'.$link.'" class="tip" title="'.$description.'">'.$titre.'</a>';
			  $data.="</li>";
			}
			
			// Enregistre en cache
			$cache = fopen('cache-rss.txt', 'w+');
			fputs($cache, $data);
			fclose($cache);
			
		} else {
			$data = file_get_contents('cache-rss.txt');
		}
		
		$this->rss = $data;
		
  }
  
}

?>
	