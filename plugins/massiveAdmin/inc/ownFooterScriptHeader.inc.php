<?php 
	$filename = GSDATAOTHERPATH.'/massiveOwnFooter/OwnFooter.json';
	$datee = @file_get_contents($filename);
	$data = json_decode($datee);

	if(file_exists($filename)){
		echo $data->ownheader;

		if($data->turncolor == "true"){
			echo'<style>';
			echo':root{--main-color:'.$data->maincolor.'}';
			echo'body{background:'.$data->bgcolor.'}';
			echo'</style>';
		};
	};
?>

<?php ;?>