<?php include('preload.php');?>
<?php print wtheadline('Have a feature <strong>request</strong> or need <strong>support</strong>?','<br>&nbsp; Contact <strong>Dev Khaos</strong> in-world or send a message here:'); ?>

<p>
<label>SL name: <span class='description'>(optional)</span></label> 
<input style='padding:2px;font-size:1.05em;width: 50%;' id='emailname'/>
</p>
<p>
<label>Email: <span class='description'>(optional)</span></label> 
<input style='padding:2px;font-size:1.05em;width: 50%;' id='emailreply'/>
</p>
<p> 
<p class='description'>For a faster response, supply an email address.</p>
<textarea style='padding:2px;font-size:1.05em;width: 100%;height:250px;' id='emailinfo'></textarea>
</p>
<p id='emailerror' style='color:orangered;'></p>
<button id='emailsubmit' style='float:right;padding:5px 10px;font-size:1.2em;'>Submit</button>



