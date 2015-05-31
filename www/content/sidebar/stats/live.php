<div align='center' id='stats'>
	<?php
		$result = mysql_query("
				
			SELECT 
				t1.beta_users,
				t2.active_users,
				t3.active_creators,
				t4.beta_breeds,
				t5.active_breeds,
				t6.beta_species,
				t7.active_species,
				t8.beta_owners,
				t9.active_owners,
				t10.active_actions
			FROM 
				(select count(*) as beta_users from user) as t1,
				(select count(*) as active_users from accounts) as t2,
				(select count(*) as active_creators from eco_creators) as t3,
				(select count(*) as beta_breeds from breed where concat('',breed_chan * 1) = breed_chan) as t4,
				(select count(*) as active_breeds from breed where concat('',breed_chan * 1) != breed_chan) as t5,
				(select count(*) as beta_species from species where concat('',species_chan * 1) = species_chan) as t6,
				(select count(*) as active_species from species where concat('',species_chan * 1) != species_chan) as t7,
				(select count(Distinct owner_name) as beta_owners from breed where concat('',breed_chan * 1) = breed_chan) as t8,
				(select count(Distinct owner_name) as active_owners from breed where concat('',breed_chan * 1) != breed_chan) as t9	,
				(select count(*) as active_actions from action_rules) as t10	
		",$link);
		if(!$result){
			echo("<p>The server is currently <a class='span' style='color:red;'>offline</a> and will be restored shortly.</p>");
		}
		else{
			$row=mysql_fetch_array($result);
			echo("
				<h3><a>eco breeds v1.x (3/19/2012)</a></h3>
				<p style='word-spacing: 2.2em;'>Hosting <a class='span'>".$row['active_species']."</a> species by <a class='span'>".$row['active_creators']."</a> creators.</p>
				<p style='word-spacing: 1em;'>With <a class='span'>".$row['active_breeds']."</a> breeds owned by <a class='span'>".$row['active_owners']."</a> avatars.</p>
				
				<h3><a>eco breeds v0.2x (1/25/2012)</a></h3>    
				<p style='word-spacing: 2.2em;'>Hosting <a class='span'>".$row['beta_species']."</a> species by <a class='span'>".$row['beta_users']."</a> creators.</p>
				<p style='word-spacing: 1em;'>With <a class='span'>".$row['beta_breeds']."</a> breeds owned by <a class='span'>".$row['beta_owners']."</a> avatars.</p>
			");
		}
    ?>
</div>