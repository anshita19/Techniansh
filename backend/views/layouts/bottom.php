<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;

?>
<div class="footer text-muted">
    &copy; <?php echo date('Y');?>. Powered by <a href="#" target="_blank">Techniansh</a>
</div>
<?php
$msgAnimationJs = <<<JS
      $(document).ready(function () {
     if ($(".alert").length) {
      setTimeout(function(){ $('.alert').fadeOut() }, 5000);
     }
});  
JS;
$this->registerJs($msgAnimationJs);
?>