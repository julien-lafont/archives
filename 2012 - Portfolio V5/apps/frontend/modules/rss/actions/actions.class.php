<?php 

class rssActions extends sfActions
{
  public function executeDerniersArticles()
  {
    $feed = new sfAtom1Feed();
  
    $feed->setTitle('Blog Studio-dev');
    $feed->setLink($this->generateUrl('blog', array(), true));
    $feed->setAuthorEmail('contact@studio-dev.fr');
    $feed->setAuthorName('Julien Lafont');
  
    $feedImage = new sfFeedImage();
    $feedImage->setFavicon('http://www.studio-dev.fr/images/favicon.png');
    $feedImage->setImage('http://www.studio-dev.fr/images/icone_100.png');
    $feedImage->setTitle('Blog Technique Studio-Dev.fr par Julien Lafont');
    $feedImage->setLink('http://www.studio-dev.fr/blog/');
    $feed->setImage($feedImage);
  
    $articles = ArticleTable::getInstance()->getDerniersArticles(30);
  
    foreach ($articles as $post)
    {
      $item = new sfFeedItem();
      $item->setTitle($post->getTitre());
      $item->setLink($this->generateUrl('article', $post, true));
      $item->setAuthorName('Julien Lafont');
      $item->setAuthorEmail('contact@studio-dev.fr');
      
      $item->setUniqueId($post->getSlug());
      $item->setDescription($post->getChapeau());
      $item->setContent($post->getContenu());
  
      if ($post->getDate() != null && $post->getDate()!='')
      {
        $dates = explode(' ', $post->getDate());
        list($year,$month,$day) = explode('-', $dates[0]);
        list($hour,$minut,$second)= explode(':', $dates[1]);
        $item->setPubdate(mktime($hour,$minut,$second,$month,$day,$year));
      }

      $feed->addItem($item);
    }
  
    $this->feed = $feed;
  }
}
?>