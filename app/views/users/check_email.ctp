<?php

      $this->js_addon = <<<EOE
<script type="text/javascript">
EOE;

if ( $emailcheck_var == "true" )
{
   $this->js_addon .= <<<EOE
    \$('#UserEmailcheck').val("1");
EOE;

} else {

   $this->js_addon .= <<<EOE
   \$('#UserEmailcheck').val("0");
EOE;

}

      $this->js_addon .= <<<EOE
</script>
EOE;

echo $emailcheck;

?>