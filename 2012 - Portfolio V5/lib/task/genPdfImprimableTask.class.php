<?php

class genPdfImprimableTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
     
    ));
    
    $this->addArguments(array(
        new sfCommandArgument('in', sfCommandArgument::REQUIRED, 'Fichier pdf en entrée'),
        new sfCommandArgument('out', sfCommandArgument::OPTIONAL, 'Fichier pdf en sortie'),
    ));

    $this->namespace        = '';
    $this->name             = 'genPdfImprimable';
    $this->briefDescription = 'Ajoute la propriété auto-imprimable à un document PDF';
    $this->detailedDescription = <<<EOF
The [genPdfImprimable|INFO] task does things.
Call it with:

  [php symfony genPdfImprimable|INFO] --in fichier_entree.pdf --out fichier_sortie.pdf
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    
    $in = $arguments['in'];
    $out = (isset($arguments['out'])) ? $arguments['out'] : "web/uploads/gen/".time().".pdf";
    
    // Cré un PDF vierge
    $pdf = new PDF_AutoPrint(); 
  
    // Ouvre le PDF modèle et charge la première page en mémoire
    $pagecount = $pdf->setSourceFile($in); 
    $tplidx = $pdf->importPage(1, '/MediaBox'); 
 
    // Ajoute la page chargée au pdf vierge
    $pdf->addPage(); 
    $pdf->useTemplate($tplidx); 
    
    // Active l'auto-impression sur le document
    $pdf->autoPrint(true);
     
    $pdf->Output($out, 'F'); 

  }
}
