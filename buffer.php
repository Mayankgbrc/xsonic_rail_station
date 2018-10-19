<?php
	session_start();
?>
<?php
    if(!strlen($_GET['station_name'])){
        header("location: index.php");
        $_SESSION['err'] = 'Enter the station code';
    }
    else{
?>
<html>
	<head>
	    
		<title> Buffer </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	<body>
		<header class="w3-container w3-teal w3-center">
          <h1>Buffer</h1>
        </header>
        <div class="w3-row">
        	<div class="w3-col l3 s12">
        		&nbsp;
        	</div>
        	<div class="w3-col l8 s12">
		<?php 
			$station_name= $_GET['station_name'];
			$url="https://api.railwayapi.com/v2/arrivals/station/".$station_name."/hours/4/apikey/zpa7xe2y3v/";
		    $data=file_get_contents($url);
		    $jssson = json_decode($data, true);
		    $response = array(200=>"Success", 210=>"Train doesn’t run on the date queried", 211=>"Train doesn’t have journey class queried", 220=>"Flushed PNR", 221=>"Invalid PNR", 230=> "Date chosen for the query is not valid for the chosen parameters", 404=>"Data couldn’t be loaded on our servers. No data available.", 405=> "Data couldn't be loaded on our servers. Request couldn't go through.", 500=> "Unauthorised API key", 501 =>"Contact mayankgbrc@gmail.com", 502=> "Invalid arguments passed, may be you entered in back date");
		    $res = $jssson["response_code"];
		    if ($res!=200){
		    	$sql = "SELECT * FROM stations WHERE stat_name='$station_name'";
		    	$result = mysqli_query($link, $sql);
			    if(mysqli_num_rows($result)){
			        while($row = mysqli_fetch_assoc($result)==1) {
	                    $stat_fetch_name = $row['stat_code'];
	                }
	                $url="https://api.railwayapi.com/v2/arrivals/station/".$stat_fetch_name."/hours/4/apikey/zpa7xe2y3v/";
				    $data=file_get_contents($url);
				    $jssson = json_decode($data, true);
				    $res2 = $jssson["response_code"];
			    }
		    }

		    if ($res==200 or $res2==200){
			    $i=0;
			    echo "<h5 class=w3-container>You are searching for Stations: ".$station_name."</h5>" ;
			    ?>
				<table class="w3-table-all w3-hoverable w3-hide-small">
					<tr class="w3-green w3-large">
						<td>S. No.</td>
						<td>Train Number</td>
						<td>Train Name</td>
						<td>Scheduled Arrival / Actual Arrival</td>
						<td>Schedule Departure / Actual Departure</td>
						<td>Delay Arrival / Delay Departure</td>
					</tr>

		<?php
			    while(isset($jssson["trains"][$i]["name"])){
			    	echo "<tr><td>";
			    	echo $i+1;
			    	echo "</td><td>";
			      		echo ($jssson["trains"][$i]["number"]);
			      	echo "</td><td>";
			      		echo ($jssson["trains"][$i]["name"]);
			      	echo "</td><td>";
			      		if($jssson["trains"][$i]["scharr"]=='Source'){
			      			echo ($jssson["trains"][$i]["scharr"]);
			      		}
			      		else{
			      			echo ($jssson["trains"][$i]["scharr"]);
							echo " / ";
							echo ($jssson["trains"][$i]["actarr"]);
			      		}
			      	echo "</td><td>";
			      		if($jssson["trains"][$i]["schdep"]=='Destination'){
			      			echo ($jssson["trains"][$i]["schdep"]);
			      		}
			      		else{
			      			echo ($jssson["trains"][$i]["schdep"]);
							echo " / ";
							echo ($jssson["trains"][$i]["actdep"]);
			      		}
			      	echo "</td><td>";
			      		if($jssson["trains"][$i]["scharr"]=='Source'){
			      			echo "--";
			      		}
			      		elseif ($jssson["trains"][$i]["delayarr"] == 'RIGHT TIME'){
			      			echo "<span class=w3-text-green>On Time</span>";
			      		}
			      		else{
			      			$time = $jssson["trains"][$i]["delayarr"];
							echo "<span class=w3-text-red>".$time."</span>";
			      		}
						echo " / ";
						if($jssson["trains"][$i]["schdep"]=='Destination'){
			      			echo "--";
			      		}
						elseif($jssson["trains"][$i]["delaydep"] == 'RIGHT TIME'){
							echo "<span class=w3-text-green>On Time</span>";
						}
						else{
			      			$time = $jssson["trains"][$i]["delaydep"];
							echo "<span class=w3-text-red>".$time."</span>";
			      		}
			      	echo "</td></tr>";
			      	$i++;
			    }
			    echo "</table></div>";
			    $i =0;
			    ?>
			<table class="w3-table-all w3-hoverable w3-hide-large">
				<tr class="w3-green w3-large">
					<td>S. No.</td>
					<td>Train Number / Name</td>
					<td>Sch / Act Arrival</td>
					<td>Sch / Act Depart</td>
					<td>Delay Arr / Dep</td>
				</tr>

		<?php
			    while(isset($jssson["trains"][$i]["name"])){
			    	echo "<tr><td>";
			    	echo $i+1;
			    	echo "</td><td>";
			      		echo ($jssson["trains"][$i]["number"])."<br>";
			      		echo ($jssson["trains"][$i]["name"]);
			      	echo "</td><td>";
			      		if($jssson["trains"][$i]["scharr"]=='Source'){
			      			echo ($jssson["trains"][$i]["scharr"]);
			      		}
			      		else{
			      			echo ($jssson["trains"][$i]["scharr"]);
							echo " / ";
							echo ($jssson["trains"][$i]["actarr"]);
			      		}
			      	echo "</td><td>";
			      		if($jssson["trains"][$i]["schdep"]=='Destination'){
			      			echo "Dest";
			      		}
			      		else{
			      			echo ($jssson["trains"][$i]["schdep"]);
							echo " / ";
							echo ($jssson["trains"][$i]["actdep"]);
			      		}
			      	echo "</td><td>";
			      		if($jssson["trains"][$i]["scharr"]=='Source'){
			      			echo "--";
			      		}
			      		elseif ($jssson["trains"][$i]["delayarr"] == 'RIGHT TIME'){
			      			echo "<span class=w3-text-green>On Time</span>";
			      		}
			      		else{
			      			$time = $jssson["trains"][$i]["delayarr"];
							echo "<span class=w3-text-red>".$time."</span>";
			      		}
						echo " / ";
						if($jssson["trains"][$i]["schdep"]=='Destination'){
			      			echo "--";
			      		}
						elseif($jssson["trains"][$i]["delaydep"] == 'RIGHT TIME'){
							echo "<span class=w3-text-green>On Time</span>";
						}
						else{
			      			$time = $jssson["trains"][$i]["delaydep"];
							echo "<span class=w3-text-red>".$time."</span>";
			      		}
			      	echo "</td></tr>";
			      	$i++;
			    }
			    echo "</table>";
			    ?>
			</div></div>
			    <?php
		    }
		    else{
    			$_SESSION['err'] = $response[$res];
    			echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
		    }
		?>
		<br><br><br>
		<footer class="w3-container w3-teal w3-center" style="position:fixed;bottom:0;left:0;width:100%;">
          <h4>Developed with <span class="w3-text-red">&hearts;</span> by <a href="https://www.facebook.com/mayankgbrc" target="_blank">Mayank Gupta</a> </h4>
        </footer>
	</body>
</html>
<?php
    }
?>