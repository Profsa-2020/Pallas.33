<?php
     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "login.php"</script>');   
     }   
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = '**********'; }

?>
     <div class="row qua-2">
          <div class="col-md-2 text-center">
               <?php
                    if ($_SESSION['wrkcamlog'] == '' || $_SESSION['wrkcamlog'] == null) {
                         echo '<a href="menu05.php"> <img src="img/logo07.png"  title="Sistema Gestão de Mall - Vistoria de Lojas"></a>';
                    } else {
                         echo '<a href="menu05.php"> <img src="' . $_SESSION['wrkcamlog'] . '"  width="100px" title="Sistema Gestão de Mall - Vistoria de Lojas"></a>';
                    }
               ?>
          </div>
          <div class="col-md-8 text-center">
               <?php
                    echo '<div class="lit-5">';
                    echo '<h4>' . $_SESSION['wrknomemp'] . '</h4>';
                    echo '</div>';
               ?>
          </div>
          <div class="lit-1 col-md-2 text-center">
               <?php
                    echo '<strong>' . $_SESSION['wrknomusu'] . '</strong>' . '<br />' ;
                    echo '<div class="lit-2">' . $_SESSION['wrkemausu'] . '</div>' . '' ;
                    echo '<div class="lit-2">' . date('d/m/Y H:i:s')  . '</div>' . '';
                    echo '<a href="saida.php" title="Fecha sistema de Gestão em Mall">';
                    echo '<i class="fa fa-sign-out fa-2x" aria-hidden="true"></i>';
                    echo '</a>';
               ?>
          </div>
     </div>
