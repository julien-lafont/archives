<?php
if (!empty($_POST['search'])) {

    $search = $_POST['search'];

            echo '<table border="0" cellpadding="0" cellspacing="0" width="95%" >';
                //include("conex.php");
                //mysql_select_db('geektoolbox_fr_geektoolbox_db') or die ('Base de données incorrecte');
				
				$whereExamen="";
				if (isset($_POST["examen"]) && $_POST["examen"]!="")
				{
					$whereExamen='AND examen="'.$_POST["examen"].'"';
				}
				
                $requete = "SELECT question, reponses, examen, MATCH (question,reponses) AGAINST ('".$search."' IN BOOLEAN MODE) AS score FROM ccna WHERE MATCH (question,reponses) AGAINST ('".$search."' IN BOOLEAN MODE) ".$whereExamen." ORDER BY score DESC";

                $result = mysql_query($requete);
                while($com_courant = mysql_fetch_assoc($result)){
                    echo '<tr>
                                <td valign="top" style="border-top:1px dotted #EEE">['.$com_courant['examen'].'] '. utf8_encode ( $com_courant['question']).'</td>
                                <td valign="top" style="border-top:1px dotted #EEE"><b>'. utf8_encode ( nl2br($com_courant['reponses'])).'</b></td>
                        </tr>';
                }
                echo '</table>';
                mysql_close();

} else {
?>

    <html>
        <head>

            <script type='text/javascript' src='http://code.jquery.com/jquery-1.5.2.min.js'></script>

            <script type="text/javascript">

                $(document).ready(function () {

                    $("a:#x").click(function () {
                        $("div:#all").toggle();
                    });

					
                    $("input:#search").change(function () {
                        rechercher();
                    });
					$("input:#examen").change(function () {
                        rechercher();
                    });
					
					
					$("body").hover(function() {
						$("body").css("color", "#888888");
					}, function() {
						$("body").css("color", "#EEE");
					});
					
					
					function rechercher() {
						if($("input:#search").val() != ''){
                            $.ajax({
                                type: "POST",
                                url: "ajax.php",
                                data:  { search: $("input:#search").val(), examen:$("#examen").val() },
                                success: function(msg){
                                    $("div:#result").html(msg);
                                }
                            });
                        }
					}

                });
            </script>
			
			<style>
				body, input { color: #EEE; }
			</style>
			
        </head>

        <body>

            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr><td width="95%">

                        <div id="all">
                            <input id="search" type="text" style=" background-color: white; border: white;" value="" />
							<input id="examen" type="text" style=" background-color: white; border: white; width:20px" value="" />

                            <div id="result">
                                HACK cisco  by Y&A :)                          
                            </div>
                        </div>

                    </td>
					<td valign="top"><a href="#" style="color: #ccc;" id="x" >X</a></td></table>
        </body>
    </html>


<?php
}
?>