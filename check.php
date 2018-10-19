			<?php
			$link = mysqli_connect("server", "xsonicin", "Br02q6769Br02q6769", "xsonicin_rail");
		    $sql="SELECT * FROM test";
		    $result = mysqli_query($link, $sql);
		    if(mysqli_num_rows($result)){
		    	while($row = mysqli_fetch_assoc($result)) {
		    		$st_code = $row['code'];
		    		$sql2="SELECT * FROM stations WHERE stat_code='$st_code'";
		    		$query = mysqli_query($link, $sql2);
		    		if(mysqli_num_rows($query) ==0){
		    			echo $row['name'];
		    			echo "<br";
		    		}
                }
            }
		   /* $sql="INSERT INTO train_stats(t_no,time_of_occurence,response_err) VALUES('$t_no','$time','$res')";
		    $query = mysqli_query($link, $sql);
		    $sql="SELECT * FROM trains WHERE train_number='$t_no'";
		    $result = mysqli_query($link, $sql);
		    if(mysqli_num_rows($result)){
		        while($row = mysqli_fetch_assoc($result)) {
                    $prior = $row["priority"];
                    $prior = $prior + 1;
                    $sql = "UPDATE trains SET priority='$prior' WHERE train_number='$t_no'";
                    $result2 = mysqli_query($link, $sql);
                }
		    }
		    */
		    ?>