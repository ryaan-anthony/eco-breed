<button num='1a' class='sub-tab sub-howto'><span class='subCap'>a</span> New Account</button>
<button num='1b' class='sub-tab sub-howto'><span class='subCap'>b</span> Installation</button>
<button num='1c' class='sub-tab sub-howto'><span class='subCap'>c</span> Configuration</button>
<button num='1d' class='sub-tab sub-howto'><span class='subCap'>d</span> Register a Species</button>

<!--Start-->
<div class='sub-content sub-default'>
	<?php print subButton('1a','Get Started'); ?>
    <?php print wttabline('the <strong>eco </strong> user manual.','docs, demos, videos, and more..',TRUE); ?>
    <?php print insertlogo(); ?>
    
    <div class='sub-info'>
        <p>This section covers...</p>
        <ul>
            <li num='1a'>Setting up <strong>your account</strong>.</li>
            <li num='1b'><strong>Installing</strong> the scripts into your objects.</li>
            <li num='1c'>How to <strong>configure</strong> your breed.</li>
            <li num='1d'>How to create a new <strong>species</strong>.</li>
        </ul>
    </div>
</div>

<!--Account-->
<div num='1a' class='sub-content' style='display:none;'>
	<?php print subButton('1b','Set Up Your Object'); ?>
	<?php print wtheadline('Create a link','between your unique avatar and the takecopy.com webserver. This link will be used to give you remote access to configure and manage your breeds.'); ?>    
    <div style='padding:20px;'>
        <p><img src='img/howto/open_package.png' class='howto-img' style='float:right'/><strong>After <a href='http://eco.takecopy.com?e=purchase' target="_blank">purchasing</a> the eco-package,</strong> rez the package to receive a folder which contains the eco-project components. Select 'Keep' and this folder will now appear in your inventory labeled 'eco-project'.</p>  
        
        <p><strong>To authenticate your account,</strong> a link will be displayed in local chat when you first rez the eco-package.</p>
        <img src='img/howto/click_link.png' class='howto-img' style='max-width: 500px;'/>
        <p><strong>Click this link</strong> to create a takecopy.com password. If you need to validate manually or forgot your password, go to <a href='http://takecopy.com' target="_blank">http://takecopy.com</a> and follow the instructions.</p>
        
        <p>You should now be able to login to your <a href='http://eco.takecopy.com?e=myaccount' target="_blank">account</a>.</p>
    </div>
</div>

<!--Install-->
<div num='1b' class='sub-content' style='display:none;'>
	<?php print subButton('1c','Explore the Settings'); ?>
	<?php print wtheadline('First you\'ll need an object',"to install the breed scripts into. Make sure the primset is orientated <em>( upright and facing east )</em> when set to zero rotation, this is <span style='color:red;'>very important</span> for functions that produce movement and other behaviors. If the root prim cannot be correctly orientated, substitute another link or add an extra prim. Here is how you check for proper orientation:"); ?>
    <div style='padding:20px;'>
   		<?php print howToIMG('<strong>Set the primset</strong> to zero rotations:','zero_rot'); ?>  
   		<?php print howToIMG('<strong>Must be upright </strong> and facing east:','face_east'); ?>  
        
        <h1 style='display: inline;'>Next, copy the scripts </h1>
        <p style='display: inline;color: #666;font-size: 0.9em;'> from the default 'eco-Breeds' object into your own primset. <span style='color:red;'>All scripts are required</span> although most will remain dormant until triggered.</p>
   		<?php print howToIMG('<strong>Right click</strong> and select \'Open\':','copy_inv'); ?>  
   		<?php print howToIMG('<strong>Insert scripts</strong> into your object:','insert'); ?>  
        <p>You should now have an orientated and scripted breed object.</p>
    </div>
</div>

<!--Settings-->
<div num='1c' class='sub-content' style='display:none;'>
	<?php print subButton('1d','Register a Species'); ?>
	<?php print wtheadline('Configurations are easy','to manage and define by simply copy/paste or removing values entirely. By default, the values for <span style=\'color: black;font-size: 1.3em;\'>growth, breeding, skins, death, and hunger</span> are all disabled unless configured.'); ?>
    <div style='padding:20px;'>
        <p align='center' class='sub-in' style='color: #666;font-size: 0.9em;margin-top:40px;'>Throughout this walkthrough, you'll see <strong>color coded settings and values:</strong></p>
        <div align='center'>
            <div class='sample' style='background: #f8fffa;'>action.settings</div>
            <div class='sample' style='background: #FFE;'>breed.settings</div>
            <div class='sample' style='background: #FAFAFA;'>extension script</div>
        </div>
        <div style='padding:40px;'>
            <p class='sub-in sit'  style='color: #666;'>Inside of each 'settings' script is an <strong>'eco'</strong> class: </p>
            <?php print normal_code('eco(){  
        
// Settings go here

}');?>
    		<p class='sub-in hang' style='color: #666;'><strong>Double click</strong> any code box to highlight all text!</p>
        </div>   
        
        <p style='color: #666;font-size: 0.9em;'>To make changes, simply<span style='color: black;font-size: 1.3em;'> add, remove, or change </span>values.</p>
        <h3 class='sub-in sit'>Default <span class='title inline sub-up'>action.settings</span> configurations:</h3>
        <?php print normal_code('eco(){
	Species_Number =    -123456;
	Species_Creator =   "Dev Khaos";
	Actions = [
		"start",
		"say(hello, eco.)
		 text(eco v%Version%)"    
	];
}','action');?>
        <h3 class='sub-in sit'>Default <span class='title inline sub-up'>breed.settings</span> configurations:</h3>
        <?php print normal_code('eco(){
	Species_Number =    -123456;
	Species_Creator =   "Dev Khaos";
	Save_Records =      FALSE;
	Activation_Param =  1;
}','breed');?>	
		<p><strong>Don't make any changes yet</strong>, these values are covered in the next section.</p>
    </div>    
</div>

<!--Species-->
<div num='1d' class='sub-content' style='display:none;'>
	<?php print pageButton('e-howto2','Define the Breed'); ?>
    <?php print wtheadline('Each species created,','can spawn an unlimited variety of unique breeds. To register your breed, create a unique species number:'); ?>
    
    <div style='padding:20px;'>
    	<p>Open the 'action.settings' script from the contents of your action object.</p>
    	<p class='sub-in'>&bull; <strong>Create a number</strong> and set your name: </p>
    	<?php print big_code('Species_Number =    -123456;
Species_Creator =   "Dev Khaos";','action'); ?>
    
    	<hr />
    
    	<p>Open the 'breed.settings' script from the contents of your action object.</p>
    	<p class='sub-in'>&bull; <strong>USE SAME NUMBER AS ACTION</strong> and set your name: </p>
    	<?php print big_code('Species_Number =    -123456;
Species_Creator =   "Dev Khaos";','breed'); ?>
    	<p class='sub-in'>&bull; <strong>Enable remote access</strong> and storage: </p>
    	<?php print big_code('Save_Records = TRUE;','breed'); ?>
   		<p>Click <strong>Save</strong> and check for <strong>errors</strong>. If the breed authenticates and connects to the action object, continue defining the species:</p>
    	<hr />
    
    	<p>Login to <a href='http://eco.takecopy.com/?e=myaccount' target='_blank'>your account</a> to view your newly created species. Your page should look like this:</p>
   		<?php print howToIMG('<strong>Click on </strong>the <span class=\'bool\'>Undefined</span> species:','first_species'); ?>  
   		<?php print howToIMG('<strong>Set the</strong> species name:','set_species'); ?>  
    	
    	<p>You have now defined the species your breed belongs to!</p>
    </div>
</div>
    

    
    
    
