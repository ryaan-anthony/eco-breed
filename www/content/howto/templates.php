		
        <!--FORMAT BREED SETTING-->
        <h3>Add or change these <span class='title inline sub-up'>breed.settings</span> values:</h3>
        <?php print breedSetting(
		'NAME',
		'DEFAULT',
		'DESCRIPTION',
		'CODE_EXAMPLE',
		'EXAMPLE_INFO'
		); ?>
		
        
        <?php print actions_code('');?>
        <?php print normal_code('');?>
        
		<?php print wtheadline('big','name'); ?>
		
        
       	<?php print method_profile(
			'METHOD',
			'VALUES',
			array(
				'VALUE','DESCRIPTION',
				'VALUE','DESCRIPTION'
			),
			actions_code(''),
			'DESCRIPTION'
			);?>