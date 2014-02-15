<?php





define('ALL', 'all');
class HDAcalendar extends HDAdate_lang {

        var $month;
        var $year;
        var $Cal;
        var $days;
        var $tab;
        var $LetterDays;
        var $bold;
        var $YearMonth;
        var $title;
        var $Tlink;
        var $html;
		var $style_table;
		var $lien1;
		var $lien2;


        function HDAcalendar($month='', $year='') {

                if($month)
                $this->month = $month;
                else
                $this->month = date('n');

                if($year)
                $this->year = $year;
                else
                $this->year = date('Y');

                $this->Cal = array();
                $this->Tlink = array();

                $this->html = '';

                // French Language :)
                parent::Set_lang('fr');
        }


        /**
        * @return array $Cal
        * @param month
        * @param year
        * @desc build the Month array
        */
        function Calendar($month, $year) {

                if($month < 1 || $month > 12) {
                        $this->error_log = "Le mois $month est invalide ";
                        return false;
                }
                if($year < 1970 || $year > 2034) {
                        $this->error_log = "L' année  $year est invalide ";
                        return false;
                }

                $this->month = $month;
                $this->year = $year;

                // Get the first day of month Timestamp
                $this->timestamp = mktime(0, 0, 0, $this->month, 1, $this->year);
                //$this->timestamp = $this->Get_timestamp($year, $month, 1);
                // spaces
                $add_day1 = date('w', $this->timestamp);
                for($i=0; $i< $add_day1; $i++) {
                        $Cal[] = '' ;
                }

                for($i=1; $i<= date('t', $this->timestamp); $i++) {
                        $Cal[] = $i;
                }

                // Days after
                $count = count($Cal);
                $add_day2 = (ceil($count/6)*6)-$count;

                for($i=0; $i<$add_day2; $i++) {
                        $Cal[] = '';
                }

                $C = count($Cal);
                if($C < 42) $Cal = array_pad($Cal, 42, '');

                return $Cal;
        }





        /**
        * @return string
        * @param current current date
        * @param page
        * @param params :: If you have GET $vars to pass ...
        * @param date format (D)D
        * @desc
        * @access private
        */
        function Set_link($date, $current, $page, $title='', $class='', $rel=''){

                $ret  = '<a href="'.$page.'" title="'.$title.'" class="'.$class.'" rel="'.$rel.'">'.$current.'</a>';
                return $ret;

        }

	
		function definir_style($style) {
			$this->style_table=$style;
		}
		
		function definir_liens($lien1, $lien2) {
			$this->lien1=$lien1;
			$this->lien2=$lien2;
		}
		



        /**
        * @return array from a date like 03 or 03-12 or 2003-03-12
        * @param var
        * @desc
        * @access private
        */
        function return_date_arr($var) {
                $y = date('Y');
                $m = date('m');
                $T = array();
                $T = explode('-', $var);
                $count = count($T);
                if($count === 3){
                        // ** TODO date like 03 or 2003
                        $y = $T[0];
                        $m = $T[1];
                        $d = $T[2];
                }
                elseif($count === 2) {
                        $m = $T[0];
                        $d = $T[1];
                }
                else $d = $var;

                return array($y, $m, $d);
        }

        /**
        * @return html
        * @desc return an HTML array
        */
        function Create_calendar() {

                $month = sprintf('%02d', $this->month);
                $year = $this->year;
                $YM = $year.'-'.$month;


                $Cal = $this->Calendar($month, $year);
                if(empty($Cal)) return false;


                $ret  = "<table class='".$this->style_table."'>";

				$ret .= '<thead><tr>';
				$ret .= '<td>'.$this->lien1.'</td>';
				$ret .= '<td colspan="5">'.$this->lg['M'][date('n', $this->timestamp)].' '.$year.'</td>';
				$ret .= '<td>'.$this->lien2.'</td>';
				$ret .= '</tr></thead>';
                
                $ret .= '<tr class="jours">';

                // Days in letters
                for($i=0; $i<7; $i++) {
                    $ret .= '<td>' . $this->lg['SD'][$i] . '&nbsp;</td>';
                }

                $ret .= '</tr>';
                $ret .= '<tr class="main">';


                $i = 0;
                $cols_nb = 7;
                $Mtmp = sprintf('%02d', $this->month);

                foreach($Cal as $val) {
					$tmp = $val;
					$end = ($i)%$cols_nb ? '' : '</tr><tr class="main">';
					$i++;

					$Dtmp = sprintf('%02d', $tmp);

					if(array_key_exists($tmp, $this->Tlink))
						$val = $this->Set_link(
									$tmp, 
									$val,
									$this->Tlink[$tmp]['page'],
									$this->Tlink[$tmp]['title'],
									$this->Tlink[$tmp]['class'],
									$this->Tlink[$tmp]['rel']);
									
					/*case remplie?*/(empty($val)) ? $class="" : $class="remplis";
					/*Aujourd'hui?*/ if ($val==date('j') && $this->month==date('n') && $this->year==date('Y')) $class="aujourdhui";
					$ret .= '<td class="'.$class.'"><div>'. $val .'</div></td>'."\n".$end;
                }

                $ret .= '<td></td></tr></table>';

                $this->html = $ret;
        }



        /**
        * @return
        * @param date format : (D)D
        * @param page URL destination
        * @param params :: If you have GET $vars to pass ...
        * @desc build link array
        * @acces public
        */
        function link($date, $page, $title, $class, $rel) {
                $T = array();

                if($date === ALL) {
                        for($i=0; $i<31;$i++) {
							$T['page']       = $page;
							$T['title']         = $title;
							$T['class']         = $class;
							$T['rel']         = $rel;
							$this->Tlink[$i] = $T;
                        }
                }
                elseif(is_array($date)) {
                        foreach($date as $val) {
							$T['page']         = $page;
							$T['title']         = $title;
							$T['class']         = $class;
							$T['rel']         = $rel;
							$this->Tlink[$val] = $T;
                        }
                }
                else {
                        $T['page']          = $page;
                        $T['title']         = $title;
						$T['class']         = $class;
						$T['rel']         = $rel;
                        $this->Tlink[$date] = $T;
                }
        }


        /**
        * @return boolean
        * @desc Output the HTML calendar to browser
        */
        function Output($afficher=false) {

                $this->Create_calendar();

                if($this->html !== '') {
                        if ($afficher) echo $this->html;
                        return $this->html;
                }
                else {
                        $this->error_log .= 'Une erreur est survenue !';
                        return false;
                }
        }
		


} // end class







class HDAdate extends HDAdate_lang {

	var $date;
	var $date_elements;
	var $timestamp;
	var $format;
	var $error_log;
	var $date_lang;
	
	function HDAdate() {
	
		$this->date_elements = array();
		$this->format = array();
		$this->date_lang = 'en';
		
		// get the prefered language
		// en , fr
		parent::Set_lang('fr');
	}
	
	function Get_date_elements($date, $lg='en') {
	
		// is it a Timestamp ?
		if(preg_match('`^[0-9]+$`', $date)) {
			$this->timestamp = $date;
			$this->format[] = 'TS';
			return TRUE;
		}
	
		$this->date_elements = array();
		$this->format = array();
		
		// DO You like REGsEXe ?
	
		// Delimiter 
		$d = '[-.,;:/_# ]*';
	
		// EN ::: An English format like 2003-12-25
		if($this->date_lang === 'en'){
			$start = 	'([a-z]* *)?((?:19|20)?[0-9]{1,2})('.$d.')'.
						'([0-1][0-9])('.$d.')'.
						'([0-3][0-9])';}
			
		// FR ::: A French format like 25-12-2003
		else		
			$start = 	'([a-z]* *)?([0-3][0-9])('.$d.')'.
						'([0-1][0-9])('.$d.')'.
						'((?:19|20)?[0-9]{1,2})';
					
		// hours, minutes & seconds
		// if necessary
		$end = 	' *(([0-2][0-9])('.$d.')([0-5][0-9])('.$d.')([0-5][0-9]))?';
		
		/**
		 The Complete MASK of the REGEX
		 
		 	([a-z]* *)? => match optiannly the day write in letters like Sunday or DIM
			EN version :
			((?:19|20)?[0-9]{1,2}) => match the Complete Year --- *1
				- (?:19|20)? => start with 19 or 20 optiannaly, non capturant (?:)
				- (..[0-9]{1,2}) => so,  Year like 03 for 2003
			FR version :
				- ([0-3][0-9]) match the DAY like 01 or 31 --- *2
			('.$d.') => it breaks date -> [-.,;:/_# ]*, can be found later
			([0-1][0-9]) => match the MONTH like 01 or 12
			EN version :
				- ([0-3][0-9]) --- *2
		 	FR version 
				((?:19|20)?[0-9]{1,2}) --- *1
				
			---------------------------------
			Hours, Minutes & Seconds .... Optiannals (?)
			
			([0-2][0-9]) => match Hours like 01 to 23
			([0-5][0-9]) => match minutes like 00 to 59
			([0-5][0-9]) => match seconds like 00 to 59
			
			
			it' s done, we get all :)
		 */
		
		preg_match(	'`^' . $start . $end . '$`i', $date, $regs);
		
		// Mask was found :)
		if(isset($regs[0])) {
		
			// Day in letters (optionnal)
			if(isset($regs[1]) && !empty($regs[1])) 
				$this->format[] = strlen($regs[1]) <= 3 ? 'SD ' : 'LD ';
			else $this->format[] = '';
			
			if($this->date_lang === 'en'){
			
				$this->date_elements['year'] = $regs[2];
				$this->format[] = strlen($regs[2]) <= 3 ? 'SY' : 'LY';
			}
			else {
				$this->date_elements['day'] = $regs[2];
				$this->format[] = 'ND';
			}
				
				$this->format[] = $regs[3];
			
				$this->date_elements['month'] = $regs[4];
				$this->format[] = 'NM';
			
				$this->format[] = $regs[5];
				
			if($this->date_lang === 'en'){
					$this->date_elements['day'] = $regs[6];
					$this->format[] = 'ND';
				}
			else {
					$this->date_elements['year'] = $regs[6];
					$this->format[] = strlen($regs[6]) <= 3 ? 'SY' : 'LY';
				}
				
			// Hours, minutes & seconds are found
			if(isset($regs[7])) {
			
				// put a space to separe
				// match it ????
				$this->format[] = ' ';
			
				$this->date_elements['hour'] = $regs[8];
				$this->format[] = 'LH';
				
				$this->format[] = $regs[9];
				
				$this->date_elements['minute'] = $regs[10];
				$this->format[] = 'NI';
				
				$this->format[] = $regs[11];
				
				$this->date_elements['second'] = $regs[12];
				$this->format[] = 'NS';
				
			
			}
			else {
			
				$this->date_elements['hour'] 	= 0;
				$this->date_elements['minute'] 	= 0;
				$this->date_elements['second'] 	= 0;
					
			}
			

			
			
			
			/*
			
			For debugs ...
			
			echo '<pre>';
			echo print_r($regs);
			
			echo '<pre>';
			echo print_r($this->date_elements);
			
			echo '<pre>';
			echo print_r($this->format);
			*/
			
			
			$this->timestamp = $this->Get_timestamp(
											$this->date_elements['year'],
											$this->date_elements['month'],
											$this->date_elements['day'],
											$this->date_elements['hour'],
											$this->date_elements['minute'],
											$this->date_elements['second']
											);
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	/**
	 *
	 * Return timestamp
	 *
	 * @ACCESS Private
	 *
	 */
	function Get_timestamp($years=0, $mon=0, $days=0, $hours=0, $min=0, $sec=0) {
	
		return  mktime($hours, $min, $sec, $mon, $days, $years);
	}
	
	
		
	/**
	 * Return Date formated from a Timestamp
	 *
	 * *** Second Parameter :::
	 *
	 * lexic :
	 * FIRST Letter (N:numeric : S:short : L:long) 
	 * SECOND Letter (D:day : M:month : Y:year : H:hour : I:minutes : S:seconds)
	 * OTHERS :
	 * TS => timestamp
	 *
	 * - ND - Day of month like 12, 03
	 * - SD - Short Day in 3 letters & in the specified lang like Sat (saturday) or Lun (Lundi)
	 * - LD - Long Day in letters like Saturday or Dimanche
	 * - NM - Month like 03
	 * - SM - Short Month in 3 letters
	 * - LM - Long Month in 3 letters
	 * - SY - Year like 03 (for 2003)
	 * - LY - Year like 2001
	 *
	 * - SH - Hour 0 -> 12
	 * - LH - Hour 0 -> 24
	 * - NI - Minutes
	 * - NS - Seconds
	 *
	 * - TS - Timestamp
	 *
	 * @ACCESS Private
	 *
	 */
	function Convert($ts, $format) {
		
			$D = getdate($ts);
			
			$in = array(
						'ND', 
						'SD', 
						'LD',
						'NM',
						'SM',
						'LM',
						'SY',
						'LY',
						'LH',
						'SH',
						'NI',
						'NS',
						'TS'
						);
						
			$out = array(
						date('d', $ts), 
						$this->lg['SD'][number_format($D['wday'])], 
						$this->lg['D'][number_format($D['wday'])],
						date('m', $ts), 
						$this->lg['SM'][number_format($D['mon'])], 
						$this->lg['M'][number_format($D['mon'])],
						date('y', $ts), 
						date('Y', $ts),
						date('H', $ts),
						date('h', $ts),
						date('i', $ts),
						date('s', $ts),
						$ts
						);

			return str_replace($in, $out, $format);
	
	}
	
	function Add_Sub_time($date, $ops, $days=0, $hours=0, $minutes=0, $seconds=0) {
	
		if($this->Get_date_elements($date, $this->date_lang)) {
		
			$tmp =  strtotime(	$ops.
								$days.'days '.$ops.
								$hours.'hours '.$ops.
								$minutes.'minutes '.$ops.
								$seconds.'seconds', 
								$this->timestamp
							);
		
			return $this->Convert($tmp, implode('', $this->format));
		}
		
	return FALSE;
	}
	
	
	/****************************
	*							*
	* 		PUBLIC ACCESS       *
	*							*
	****************************/
	
	
	/**
	 * 
	 * Set the date format
	 *
	 * (YY)YY MM DD ==> en
	 * DD MM (YY)YY ==> fr
	 *
	 * en | fr
	 *
	 * @ACCESS Public
	 *
	 */
	function Set_date_lang($lg) {
	
		$this->date_lang = $lg;
	}
	
	/**
	 * LIKE date() function
	 *
	 * expects than the second parameter accepts date STRING format
	 *
	 */
	function _Date($format, $date=0) {
	
		if($date !== 0) {
			if($this->Get_date_elements($date, $this->date_lang))		
				$date = $this->timestamp;	
		}
		else $date = time();

		$ret = date($format, $date);
		return $ret;
	}
	
	
	/**
	 *
	 * Return date formated
	 * Arguments may be left out in order from right to left;
	 *
	 *
	 * @ACCESS Public
	 *
	 */
	function Add_time($date, $days=0, $hours=0, $minutes=0, $seconds=0) {
	
		$tmp = $this->Add_Sub_time($date, '+', $days, $hours, $minutes, $seconds);
		if($tmp)
			return $tmp;
			
		else {
			$this->error_log = "La date $date n' est pas au bon format!!";
			return FALSE;
		}
	}
		
	/**
	 *
	 * Return date formated
	 * Arguments may be left out in order from right to left;
	 *
	 *
	 * @ACCESS Public
	 *
	 */
	function Sub_time($date, $days=0, $hours=0, $minutes=0, $seconds=0) {
	
		$tmp = $this->Add_Sub_time($date, '-', $days, $hours, $minutes, $seconds);
		if($tmp)
			return $tmp;
			
		else {
			$this->error_log = "La date $date n' est pas au bon format!!";
			return FALSE;
		}		
	}




} // end class





















class HDAdate_lang {

	var $lang;
	var $lg;
	
	function HDAdate_lang() {
	
		//$this->lang = 'fr';
		//$this->lg = array('M' => array(), 'D' => array() );
		
	}
	
	function Set_lang($lang='fr') {
	
		switch($lang) {
		
			case 'fr' :
				$this->lg['M'][1] = 'Janvier';
				$this->lg['M'][2] = 'Fevrier';
				$this->lg['M'][3] = 'Mars';
				$this->lg['M'][4] = 'Avril';
				$this->lg['M'][5] = 'Mai';
				$this->lg['M'][6] = 'Juin';
				$this->lg['M'][7] = 'Juillet';
				$this->lg['M'][8] = 'Aout';
				$this->lg['M'][9] = 'Septembre';
				$this->lg['M'][10] = 'Octobre';
				$this->lg['M'][11] = 'Novembre';
				$this->lg['M'][12] = 'Decembre';
				
				$this->lg['SM'][1] = 'Jan';
				$this->lg['SM'][2] = 'Fev';
				$this->lg['SM'][3] = 'Mar';
				$this->lg['SM'][4] = 'Avr';
				$this->lg['SM'][5] = 'Mai';
				$this->lg['SM'][6] = 'JuiN';
				$this->lg['SM'][7] = 'Juil';
				$this->lg['SM'][8] = 'Aou';
				$this->lg['SM'][9] = 'SeP';
				$this->lg['SM'][10] = 'Oct';
				$this->lg['SM'][11] = 'Nov';
				$this->lg['SM'][12] = 'Dec';
				
				$this->lg['D'][] = 'Lundi';
				$this->lg['D'][] = 'Mardi';
				$this->lg['D'][] = 'Mercredi';
				$this->lg['D'][] = 'Jeudi';
				$this->lg['D'][] = 'Vendredi';
				$this->lg['D'][] = 'Samedi';
				$this->lg['D'][] = 'Dimanche';
				
				$this->lg['SD'][] = 'Lun';
				$this->lg['SD'][] = 'Mar';
				$this->lg['SD'][] = 'Mer';
				$this->lg['SD'][] = 'Jeu';
				$this->lg['SD'][] = 'Ven';
				$this->lg['SD'][] = 'Sam';
				$this->lg['SD'][] = 'Dim';
				
				
			break;
			
			case 'en' :
			default :
				$this->lg['M'][1] = 'January';
				$this->lg['M'][2] = 'Februray';
				$this->lg['M'][3] = 'March';
				$this->lg['M'][4] = 'April';
				$this->lg['M'][5] = 'May';
				$this->lg['M'][6] = 'June';
				$this->lg['M'][7] = 'July';
				$this->lg['M'][8] = 'August';
				$this->lg['M'][9] = 'September';
				$this->lg['M'][10] = 'October';
				$this->lg['M'][11] = 'November';
				$this->lg['M'][12] = 'December';
				
				$this->lg['SM'][1] = 'Jan';
				$this->lg['SM'][2] = 'Feb';
				$this->lg['SM'][3] = 'Mar';
				$this->lg['SM'][4] = 'Apr';
				$this->lg['SM'][5] = 'May';
				$this->lg['SM'][6] = 'Jun';
				$this->lg['SM'][7] = 'Jul';
				$this->lg['SM'][8] = 'Aug';
				$this->lg['SM'][9] = 'Sep';
				$this->lg['SM'][10] = 'Oct';
				$this->lg['SM'][11] = 'Nov';
				$this->lg['SM'][12] = 'Dec';
				
				$this->lg['D'][] = 'Sunday';
				$this->lg['D'][] = 'Monday';
				$this->lg['D'][] = 'Tuesday';
				$this->lg['D'][] = 'Wednesday';
				$this->lg['D'][] = 'Thursday';
				$this->lg['D'][] = 'Friday';
				$this->lg['D'][] = 'Saturday';
				
				$this->lg['SD'][] = 'Sun';
				$this->lg['SD'][] = 'Mon';
				$this->lg['SD'][] = 'Tue';
				$this->lg['SD'][] = 'Wed';
				$this->lg['SD'][] = 'Thu';
				$this->lg['SD'][] = 'Fri'; 
				$this->lg['SD'][] = 'Sat';
				
				
			break;
		
		}
	}


} // End class

?>