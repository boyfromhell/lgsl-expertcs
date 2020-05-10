<?php
require_once"header.php";
?>
<script type="text/javascript">
function cauta_server(str) {
    if (str == "") {
        document.getElementById("livesearch").innerHTML = "Se verifica datele";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","lgsl_files/cauta.php?term="+str,true);
        xmlhttp.send();
    }
}
</script>





  <div class='wrapper wrapper-content animated fadeInRight'>      
    <div class='row'>    
    <div class="col-lg-2"> <?php  require"stanga.php";  ?></div>
      <div class='col-lg-10'>    

  
<div class='ibox float-e-margins'> <div class='ibox-title'>   Cautare server </div>
  <div class='ibox-content'>
  


    <form action="#">


<input type="text" class="form-control" onkeyup="cauta_server(this.value)" /> <br />

</form>

 <div id="livesearch"></div>

</div>
</div>


            </div>
</div>
</div>

</div>

<?php
require "footer.php";
?>

