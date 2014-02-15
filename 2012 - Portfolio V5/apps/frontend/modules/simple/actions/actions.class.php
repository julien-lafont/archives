<?php

/**
 * cv actions.
 *
 * @package    foliov4
 * @subpackage cv
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class simpleActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeBooks(sfWebRequest $request)
	{
		//$this->getResponse()->setFullwidth(true);
		$qualite = array(
			array(
				"src" 	=> "the-clean-coder.jpg",
				"titre" => "The clean coder",
				"url"	=> "http://www.amazon.fr/gp/product/0137081073/ref=as_li_ss_tl?ie=UTF8&tag=portfoliopers-21&linkCode=as2&camp=1642&creative=19458&creativeASIN=0137081073",
				"description"	=> "Un livre permettant de prendre conscience des responsabilités et des devoirs d'un développeur professionel, d'un 'Craftsman'. Je conseille vivement sa lecture !"
			),
			array(
				"src" 	=> "head-first-design-patterns.jpg",
				"titre" => "Head First Design Patterns",
				"url"	=> "http://www.amazon.fr/gp/product/0596007124/ref=as_li_ss_tl?ie=UTF8&tag=portfoliopers-21&linkCode=as2&camp=1642&creative=19458&creativeASIN=0596007124",
				"description"	=> "Un des meilleurs ouvrages que j'ai eu en ma possession traitant des Design-Pattern."
			),
			array(
				"src" 	=> "junit-in-action.jpg",
				"titre" => "Junit in action",
				"url"	=> "http://www.amazon.fr/gp/product/1935182021/ref=as_li_ss_tl?ie=UTF8&tag=portfoliopers-21&linkCode=as2&camp=1642&creative=19458&creativeASIN=1935182021",
				"description"	=> "Mise en place et utilisation du framework de tests unitaires JUnit."
			),
			array(
				"src" 	=> "developpements-ntiers-avec-javaee.jpg",
				"titre" => "Développement n-tiers avec Java EE",
				"url"	=> "https://www.amazon.fr/dp/2746062631/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=2746062631&adid=0F898S9V5JR8YE1HNYFS&",
				"description"	=> "Présentation des différentes technologies composant l'écosystème JavaEE, ainsi que des modèles d'architectures n-tiers liées."
			)
		);
		
		$agile = array(
			array(
				"src" 	=> "scrum.jpg",
				"titre" => "Scrum",
				"url"	=> "https://www.amazon.fr/dp/2100563203/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=2100563203&adid=16GNGNVXZ0YHR779R3XG&",
				"description"	=> "Présentation de la méthode Scrum par Claude Aubry. Un Must Have pour tout agiliste qui se respecte !"
			),
			array(
				"src" 	=> "agile-estimating-and-planning.jpg",
				"titre" => "Agile estimating and planning",
				"url"	=> "http://www.amazon.fr/gp/product/B0068HAV2G/ref=as_li_ss_tl?ie=UTF8&tag=portfoliopers-21&linkCode=as2&camp=1642&creative=19458&creativeASIN=B0068HAV2G",
				"description"	=> "A venir..."
			),
			array(
				"src" 	=> "gestion-de-projet-agile.jpg",
				"titre" => "Gestion de projet agile",
				"url"	=> "https://www.amazon.fr/dp/2212127502/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=2212127502&adid=1QAR5X44RZ8CFG2VNNEF&",
				"description"	=> "Présentation de différentes méthodes de gestions de projet, des enjeux et des difficultés liés au passage à l'agilité. Scrum, XP, Lean ..."
			),
			array(
				"src" 	=> "the-pragmatic-programmer.jpg",
				"titre" => "The Pragmatic Programmer",
				"url"	=> "https://www.amazon.fr/dp/020161622X/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=020161622X&adid=05XZXP29DQ58AMXAMEZY&",
				"description"	=> "A venir..."
			)
		);
		
		$dev = array(
			
			array(
				"src" 	=> "javaserver-faces-2.jpg",
				"titre" => "JavaServer Faces 2.0",
				"url"	=> "https://www.amazon.fr/dp/0071625097/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=0071625097&adid=0KM820C7RHC9GBBFHJY6&",
				"description"	=> ""
			),
			array(
				"src" 	=> "play-framework-cookbook.jpg",
				"titre" => "Play Framework cookbook",
				"url"	=> "https://www.amazon.fr/dp/1849515522/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=1849515522&adid=0YYH8G9HATEJ2Q9NJ651&",
				"description"	=> ""
			),
			array(
				"src" 	=> "programming-in-scala.jpg",
				"titre" => "Programming Scala",
				"url"	=> "https://www.amazon.fr/dp/0981531644/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=0981531644&adid=19J7XA0DCW7TKDANTP4K&",
				"description"	=> ""
			),/*
			array(
				"src" 	=> "seam-in-action.png",
				"titre" => "Seam in action",
				"url"	=> "https://www.amazon.fr/dp/1933988401/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=1933988401&adid=08TY3BCERMSADDZ05YXK&",
				"description"	=> ""
			),
			array(
				"src" 	=> "liferay-in-action.jpg",
				"titre" => "Liferay in action",
				"url"	=> "https://www.amazon.fr/dp/193518282X/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=193518282X&adid=1YBF3MJFHJPMW4VRC8Y0&",
				"description"	=> ""
			),
			array(
				"src" 	=> "symfony.jpg",
				"titre" => "Mieux développer avec Symfony 1.2",
				"url"	=> "https://www.amazon.fr/dp/2212124945/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=2212124945&adid=0JHN3NGKDYKVV2QC0R5Q&",
				"description"	=> ""
			),*/
			array(
				"src" 	=> "android.jpg",
				"titre" => "L'art du développement android",
				"url"	=> "https://www.amazon.fr/dp/2744024953/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=2744024953&adid=17VR8ETTJR18E08R8RM9&",
				"description"	=> ""
			),
			/*array(
				"src" 	=> "secrets-of-the-javascript-ninja.jpg",
				"titre" => "Secrets of the JavaScript Ninja",
				"url"	=> "http://www.amazon.fr/gp/product/193398869X/ref=as_li_ss_tl?ie=UTF8&tag=portfoliopers-21&linkCode=as2&camp=1642&creative=19458&creativeASIN=193398869X",
				"description"	=> ""
			),
			array(
				"src" 	=> "jquery.png",
				"titre" => "jQuery et jQuery UI",
				"url"	=> "https://www.amazon.fr/dp/2212128924/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=2212128924&adid=03Z3EDXBES73TGHSXPQK&",
				"description"	=> ""
			)
			array(
				"src" 	=> "97-things-every-programmer-should-know.jpg",
				"titre" => "97 Things Every Programmer Should Know",
				"url"	=> "https://www.amazon.fr/dp/0596809484/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=0596809484&adid=0BJQFF1CFB5AS078ZK5K&",
				"description"	=> ""
			)*/
		);
		
		$mobile = array (
		
		
		
		);
		
		$bdd = array(
			array(
				"src" 	=> "java-persistence-with-hibernate.jpg",
				"titre" => "Java persistence with Hibernate",
				"url"	=> "https://www.amazon.fr/dp/1932394885/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=1932394885&adid=1H6PD1PYXAYNVZH8566T&",
				"description"	=> ""
			),
			array(
				"src" 	=> "postgresql.jpg",
				"titre" => "Practical PostgreSQL",
				"url"	=> "https://www.amazon.fr/dp/1565928466/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=1565928466&adid=0X3HBCFWJRVPWB50B7F1&",
				"description"	=> ""
			),
			array(
				"src" 	=> "high-performance-mysql.jpg",
				"titre" => "High Performance MySQ",
				"url"	=> "https://www.amazon.fr/dp/0596101716/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=0596101716&adid=1HSPR55D5TWA922C4077&",
				"description"	=> ""
			),
			array(
				"src" 	=> "optimisation-des-bases-de-donnees-oracle.jpg",
				"titre" => "Optimisation des bases de données",
				"url"	=> "https://www.amazon.fr/dp/2744024120/ref=as_li_ss_til?tag=portfoliopers-21&camp=2910&creative=19482&linkCode=as4&creativeASIN=2744024120&adid=0VGQKEQPVCPX4Y788P6Q&",
				"description"	=> ""
			)
		);
		
		$this->livres = array(
			array(
				"titre" 		=> "Qualité et artisanat logiciel",
				"references" 	=> $qualite,
				"description"	=> "Poussé par le mouvement du <strong>Software Craftsmanship</strong>, le domaine de la qualité logiciel est aujourd'hui primordial à
									 mes yeux. <accronym title='Test Driven Development'>TDD</accronym>, 
									 <accronym title='Behavior Driver Development'>BDD</accronym>, <accronym title='Test Unitaire'>TU</accronym>, 
									 <accronym title='Test Fonctionnel'>TF</accronym>, <accronym title='Test de Non Régression'>TNC</accronym>, 
									 Intégration continue et Refactoring sont des pratiques que je m'emploie à mettre en oeuvre au quotidien."
			),
			array(
				"titre" 		=> "Culture Agile",
				"references" 	=> $agile,
				"description"	=> "J'ai découvert l'agilité en 2009 suite à l'arrivée d'un <strong>Scrum Master</strong> chez IOcean. 
									J'ai tout de suite été attiré par cette nouvelle culture mettant l'humain au centre des processus, privilégiant la collaboration, l'auto organisation et l'amélioration continue."
			),
			array(
				"titre" 		=> "Développement web, logiciel et mobile",
				"references" 	=> $dev,
				"description"	=> "Ma curiosité perpétuelle en matière de nouvelles technologies m'amène à découvrir régulièrement
									de nouvelles voies pour m'améliorer dans mon métier premier : développeur. Java, PHP, C++, Ruby, Closure, Dart [...], je m'efforce de rester
									ouvert à tout langage, ce qui me permet d'<strong>apprendre constamment</strong> en étudiant leurs concepts et leur architecture. <!--Les technologies
									du web forment aujourd'hui le coeur de mes compétences, notamment sur l'environnement <strong>JavaEE</strong>.-->"
			)/*,
			array(
				"titre" 		=> "Base de données et Business Intelligence",
				"references" 	=> $bdd,
				"description"	=> "&laquo;Qui détient l'Information détient le Pouvoir.&raquo;	A condition de savoir les analyser et d'en déduire les bonnes
									initiatives ! C'est pour cela que le domaine de l'<strong>informatique décisionnelle</strong> est important à mes yeux, basé sur différents
									socles technologiques : bases de données relationnelles, objets ou NoSql, Business Intelligence ou encore BigData."
			)*/
		);
		
		// SEO
		$this->getResponse()->addMeta('description', 'Domaines de compétences et dernières lectures : Qualité et architecture logicielle, Agilité, Développement web, logiciel et mobile, Base de données');
		$this->getResponse()->setTitle('Studio-dev : Domaines de compétences : Agilité, Gestion de projet, Développement et Software Craftsmanship');
    
	}

}
