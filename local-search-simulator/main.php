<?php 
	
function show_local_simulator()
{
ob_start();
include('stateArray.php');
$city = '';
$state = '';
$stateValue = '';
$country = '';
$searchterm = '';
$m = '';


if($_SERVER['REQUEST_METHOD'] == 'POST')
{

   $err_msg ='We could not find the ';  
   $err = Array();
    $n = 0;
	if(!empty($_POST['searchterm']))
    {
		$searchterm = $_POST['searchterm'];
	}
    else
    {
		$err[$n] = 'Search Term';
		$n++;
	}
	// if(!empty($_POST['city'])){
	// 	$city= $_POST['city'];
	// }
	if(empty($_POST['state']))
    {
	
		 $err[$n] = 'State';
		 $n++;
	}
    else
    {		
		
		$state = $_POST['state'];
	//echo $state;
	}
	if(empty($_POST['city']))
    {
		
		 $err[$n] = 'City';
		 $n++;
	}
    else
    {
		 $city= $_POST['city'];
	}

	if(!empty($_POST['country']))
    {
		$country= $_POST['country'];
	}
	

}

?>
<div style="">

	<h1>Check Google local search results from any location</h1>
	<form method="POST">
		<div><label>Search Term</label></div>
		<?php $searchterm_value = isset($_POST['searchterm'])? $_POST['searchterm']:'';$city_value = isset($_POST['city'])? $_POST['city']:''; ?>
		<div>
			<input type="text" name="searchterm" style="width:100%;" value="<?php echo $searchterm_value; ?>">
		</div>
		<div><label>City</label></div>
		<div><input type="text" style="width:100%;" name="city" style="width:100%;" value="<?php echo $city_value; ?>"></div>
		<div>State</div>
		<div>
			<select name="state" style="width:100%;padding:10px;margin-bottom:10px;" >
				<!-- <option value="">Select State</option> -->
				<?php
				$key = '';
					foreach ($states as $key => $value)
                    {		
						$selected = '';
						if(isset($_POST['state'])){
						if( $_POST['state'] == 'Select State')
                        {
							$selected = 'selected="selected"'; 
						}
						if ($_POST['state'] == $key) {
							$selected = 'selected="selected"';
						}
						}
                  
						 echo "<option value=".  $key  . " $selected>". $value  . "</option>";
						
					}

					// echo '<option value="'.$row['id'].'"'.$selected.'>'.$row[''data'].'</option>';

					foreach($states as $k => $value)
					{
						if($k == $state){
							$stateValue = $value;
							//echo 	$stateValue . ' =ppp= ';
						}
					
					}
					
				?>

			</select> 

	    </div>
		<!-- <div><label>Country</label></div> -->
		<div><input type="hidden" name="country" value="United States" readonly></div>
		<!-- <div><label>Language</label></div> -->
		<div><input type="hidden" name="language" value="English" readonly ></div>
		<div><input type="submit" name="Submit" value="Check search results"></div>

	</form>

</div>

<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){

$uule_value = '';
	if(count($err) > 0 ){
		//echo $err_msg . $err;
	
		for ($i=0; $i < count($err); $i++)
         { 
				if($i == 0)
                {
					$m .= $err[$i];
				}
                else
                {
					$m .= ', '.$err[$i];
				}
		}
		echo '<p style="color:red;">' . $err_msg . $m .' you entered. Please check your spelling and try again </p>';
	}else{
	echo '<h1>Here are your localize search results:</h1>';
$secret_key= '';

$uule = 'CAIQICI';
$canonical_name = $city.','.$stateValue .','.$country;
//echo $canonical_name.' == ';
$canonical_len = strlen($canonical_name);
	

$h = fopen('geotargets-2021-04-16.csv', 'r', 1);
$ctr = 1;

$res = 0;
$arrtmp = Array();
$t=0;
while (($str = fgets($h)) != false ) 
{

	$r = str_getcsv($str);
		$arrtmp[$t] = $r; 
		$t++;	
	$ctr++;
}

		for ($i=0; $i < count($arrtmp) ; $i++)
        { 
			for ($x=0; $x < count( $arrtmp[$i]) ; $x++) 
            { 
				# code...
				if(strtolower($arrtmp[$i][$x]) ==strtolower($canonical_name))
                {
					$res = 1 ;
					
				}
			}
		}
//var_dump($_POST);
if($res == 0)
{
	echo '<p style="color:red;">' . $err_msg . $m .' you entered. Please check your spelling and try again </p>';
	die();
}

   $arr = [
   		'4' => 'E','5' => 'F','6' => 'G','7' => 'H','8' => 'I','9'=> 'J','10'=>'K','11'=>'L','12'=>'M','13'=>'N','14'=>'O','15'=>'P','16'=>'Q','17'=>'R','18'=>'S','19'=>'T','20'=>'U','21'=>'V','22'=>'W','23'=>'X','24'=>'Y','25'=>'Z','26'=>'a','27'=>'b','28'=>'c','29'=>'d','30'=>'e','31'=>'f','32'=>'g','33'=>'h','34'=>'i','35'=>'j','36'=>'k','37'=>'l','38'=>'m','39'=>'n','40'=>'o','41'=>'p','42'=>'q','43'=>'r','44'=>'s','45'=>'t','46'=>'u','47'=>'v','48'=>'w','49'=>'x','50'=>'y','51'=>'z','52'=>'0','53'=>'1','54'=>'2','55'=>'3','56'=>'4','57'=>'5','58'=>'6','59'=>'7','60'=>'8','61'=>'9','62'=>'-','63'=>'','64'=>'A','65'=>'B','66'=>'C','67'=>'D','68'=>'E','69'=>'F','70'=>'G','71'=>'H','72'=>'I','73'=>'J','76'=>'M','83'=>'T','89'=>'L',
   ];
   
	foreach ($arr as $key => $value) 
    {
		
		if($key == $canonical_len)
      {
			$secret_key = $value;
		}
	}
 $uule_value = 'w+'. $uule.$secret_key.base64_encode($canonical_name);

?>
<h3>
<a href="<?php echo "https://www.google.com/search?q=".strtolower($searchterm) ."&uule=".$uule_value .""; ?>" target="_new"> <?=strtolower($searchterm);?></a>
</h3>
</div>

<?php 

} 
}

$ReturnString = ob_get_contents(); 	ob_end_clean(); 	return $ReturnString; 
}
?>