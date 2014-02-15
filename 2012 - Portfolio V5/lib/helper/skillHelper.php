<?php

function skill($techno, $nb=5) {
  echo '<strong>'.$techno.'</strong><span style="display:inline-block"><img width="81" height="8" alt="'.$nb.'" src="/images/skill-'.$nb.'.gif"></span>';
}