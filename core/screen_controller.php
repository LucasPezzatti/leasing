<?php 
$screen_mode="low";
$columnsize='style="width:80px"';
?>   
<script type="text/javascript">
    document.cookie = "Screen = "+window.innerWidth;
</script>
<?php 
if(isset($_COOKIE['Screen'])){
  $screensize =  $_COOKIE['Screen'];

  if($screensize > 1400){
    $screen_mode="high";
    $columnsize="";
  }
}
?>