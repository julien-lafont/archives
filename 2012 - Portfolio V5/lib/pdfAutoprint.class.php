<?php

class PDF_AutoPrint extends FPDI
{
  
  /**
   * Lance la boîte d'impression ou imprime immediatement sur l'imprimante par défaut
   * @param boolean $dialog : Ouvrir la fenêtre d'impression ?
   */
  public function autoPrint($dialog=false)
  {
      $param=($dialog ? 'true' : 'false');
      $script="print($param);";
      $this->IncludeJS($script);
  }
  
  /**
   * Imprime sur une imprimante partagée (requiert Acrobat 6 ou supérieur)
   * @param unknown_type $server
   * @param unknown_type $printer
   * @param unknown_type $dialog
   */
  public function autoPrintToPrinter($server, $printer, $dialog=false)
  {
      $script = "var pp = getPrintParams();";
      if($dialog)
          $script .= "pp.interactive = pp.constants.interactionLevel.full;";
      else
          $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
      $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
      $script .= "print(pp);";
      $this->IncludeJS($script);
  }
}

