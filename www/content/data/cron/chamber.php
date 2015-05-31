<?php
putenv('TZ=PST'); 
ini_set('memory_limit', '-1');
ini_set('max_execution_time',300);
$start = microtime();

//functions
function getSettings($creator, $channel){
global $link;
$result=mysql_query("select * from species where species_creator='$creator' AND species_chan='$channel'", $link);
$row=mysql_fetch_array($result);
return explode(',',$row['species_chamber']);
}
function getBreedData($breed_id){
global $link;
$result=mysql_query("select * from breed where breed_id='$breed_id' and breed_notdead='1'", $link);
if(!$result){return array();}
return mysql_fetch_array($result);
}


//open link
$link = mysql_connect("localhost","takecopy", "devTR1420");
if(!mysql_select_db("takecopy_eco",$link)){die(mysql_error());}

//run simulation
$result=mysql_query("select * from chamber where breeds!=''", $link);
while($row=mysql_fetch_array($result)){
	$data = getSettings($row['creator'],$row['channel']);
	//Lifespan Settings
	$Lifespan=(int)$data[0];
	$Lifespan_Age_Min=(int)$data[1];
	$Lifespan_Age_Max=(int)$data[2];
	$Lifespan_Age_Start=(int)$data[3];
	$Lifespan_Year=(int)$data[4];
	$Lifespan_Survival_Odds=(int)$data[5];
	//Growth Settings
	$Growth_Stages=(int)$data[6];
	$Growth_Scale=(float)$data[7];
	$Growth_Timescale=(int)$data[8];
	$Growth_Stunted_Odds=(int)$data[9];
	//Hunger Settings
	$Hunger_Consume_Time=(int)$data[10];
	$Hunger_Consume_Odds=(int)$data[11];
	$Hunger_Consume_Min=(int)$data[12];
	$Hunger_Consume_Max=(int)$data[13];
	$Hunger_Death_Odds=(int)$data[14];
	$Hunger_Percent_Start=(int)$data[15];
	$Hunger_Percent_Lost=(int)$data[16];
	$Hunger_Percent_Min=(int)$data[17];
	$Food_Unit_Value=(int)$data[35];
	$Food_Level = (int)$row['food'];
	$Food_Consumed=0;
	//Breed Settings
	$Breed_Ready = array();
	$Breed_Time=(int)$data[18];
	$Breed_Failed_Odds=(int)$data[19];
	$Breed_Litter_Min=(int)$data[20];
	$Breed_Litter_Max=(int)$data[21];
	$Breed_Litter_Rare=(int)$data[22];
	$Breed_Litters=(int)$data[23];
	$Breed_Age_Min=(int)$data[24];
	$Breed_Age_Max=(int)$data[25];
	$Require_Partners=(int)$data[26];
	$Unique_Partner=(int)$data[27];
	$Keep_Partners=(int)$data[28];
	$Partner_Timeout=(int)$data[29];
	$Pregnancy_Timeout=(int)$data[30];
	$Genders=(int)$data[31];
	$Gender_Male=$data[32];
	$Gender_Female=$data[33];
	$Gender_Unisex=$data[34];
	
	$breeds = explode(',',$row['breeds']);
	for($i=0;$i<count($breeds);$i++){
		$data = getBreedData($breeds[$i]);
		if(count($data)){
			foreach($data as $key=>$value) { $$key = $value; }
			$breed_update=time();//reset timer
			//event: Age
			$elapsed = (time()-(int)$timer_age)/60;
			if($Lifespan && $elapsed>=$Lifespan_Year && (int)$breed_notdead){
				$breed_age=((time()-(int)$breed_born)/60)/$Lifespan_Year;//set new age
				$timer_age=time();//reset timer
				if($Lifespan_Survival_Odds!=-1 && (($breed_age>=$Lifespan_Age_Min && (int)rand(0,$Lifespan_Survival_Odds)==0) || ($breed_age>=$Lifespan_Age_Max && $Lifespan_Age_Max!=-1))){
					$breed_notdead=0;//dead
					$breed_dead=time();//set time of death
				}				
			}
			//event: Growth
			$elapsed = (time()-(int)$timer_grow)/60;
			if($Growth_Stages && $elapsed>=$Growth_Timescale && (int)$breed_notdead && (int)$growth_stages){
				$growth_stages--;//reduce growth stages
				$timer_grow=time();//reset timer
	        	if((int)rand(0,$Growth_Stunted_Odds)==0){
					$breed_growth_total=(float)$breed_growth_total*$Growth_Scale;//apply new growth
				}
			}
			//event: Hunger
			$elapsed = (time()-(int)$timer_hunger)/60;
			if($Hunger_Consume_Time && $elapsed>=$Hunger_Consume_Time && (int)$breed_notdead){
				$timer_hunger=time();//reset timer
	        	if((int)rand(0,$Hunger_Consume_Odds)==0){
					$breed_hunger=(int)$breed_hunger;
					if($breed_hunger<=$Hunger_Percent_Min && ($Hunger_Death_Odds!=-1 && (int)rand(0,$Hunger_Death_Odds)>0)){
						$breed_notdead=0;//dead
						$breed_dead=time();//set time of death
					}
					else{
    					$breed_hunger-=$Hunger_Percent_Lost;//reduce MyHunger
    					if($breed_hunger<0){$breed_hunger=0;}
						if(($Food_Level==-1 || $Food_Level>=$Hunger_Consume_Min) && $breed_hunger<100 && $Food_Unit_Value>0){
							$consume = (int)rand($Hunger_Consume_Min,$Hunger_Consume_Max);
							if($consume>$Food_Level && $Food_Level!=-1){//wants more than available
								$consume=$Hunger_Consume_Min;
							}
							$need = 100-$breed_hunger;
    						if($consume>0 && ($consume*$Food_Unit_Value)>($need/$Food_Unit_Value)){//more than it needs
            					$consume=$need/$Food_Unit_Value;
            					if($consume>$Hunger_Consume_Max){$consume=$Hunger_Consume_Max;}
            					else if($consume<$Hunger_Consume_Min){$consume=0;}								
							}
							if($consume>0){
								$breed_hunger+=($consume*$Food_Unit_Value);//update hunger and food levels
        						if($breed_hunger>100){$breed_hunger=100;}
								$Food_Consumed+=$consume;
								$Food_Level-=$consume;
								if($Food_Level<0){$Food_Level=0;}
							}	
    					}
					}
				}	
			}			
			//event: Breed
			$elapsed = (time()-(int)$timer_breed)/60;
			if($Breed_Time && $elapsed>=$Breed_Time && (int)$breed_notdead){
				$timer_breed=time();//reset timer
				if($breed_age>=$Breed_Age_Min && ($breed_age<=$Breed_Age_Max || $Breed_Age_Max==-1)){//is breeding age
					if(!$Require_Partners){goto breedingCall;}//asexual
					
					
					
					//Mating Calls
					if($MyGender!=$Gender_Female&&($breed_partner!=""||!$Keep_Partners)){//male w/partner or male polygamous
						if($breed_partner!="" && $Partner_Timeout && (++$partner_timeout)==$Partner_Timeout){$breed_partner="";}//partner timed out
						if($breed_parents!=""){$parent="&&".$breed_parents;}
						$Breed_Ready=array_merge($Breed_Ready,array($breed_id."|".$breed_name."|".$breed_generation."|".$breed_gender."||".$breed_skins.$parent.";/;".$breed_partner));
					}
					if($MyGender!=$Gender_Male&&$Keep_Partners){//monogamous female
						if($breed_partner==""){$Breed_Ready=array_merge($Breed_Ready,array("single;/;".$breed_id));}//single
						else if($Partner_Timeout && (++$partner_timeout)==$Partner_Timeout){$breed_partner="";}//partner timed out
					}
					
					
					
				}
	
	
	if(num==-10){
    list data = llParseStringKeepNulls(str,[";+;"],[]);
    if(llGetListLength(data)==3){//mating
        string self = llList2String(data,0);
        string partner = llList2String(data,1);
        string partnername = llList2String(data,2);
        if(MyPartner==""){
            if(self==MyKey){MyPartner=partner;_link(-49,MyPartner);_link(-124,partnername);}//set partner
            else if(self=="single"){FindPartner=partner;}
        }
    }
    else{//breeding
        data = llParseStringKeepNulls(str,[";"],[""]);
        if(llList2String(data,0)=="birthobject"){
            if(BREEDING){
                BREEDING=FALSE;
                BREEDING_EXPIRE=0;
                saved_breedstring=breedstring+"&+&"+llList2String(data,1)+"&+&"+MyKey+"&+&"+(string)llGetKey();
                if(Pregnancy_Timeout){
                    _DEBUG("Female: Pregnant");
                    Pregnancy_Time=Pregnancy_Timeout;
                    Timer_Pregnancy=llGetUnixTime();
                    _link(-172,(string)(Timer_Pregnancy+(Pregnancy_Time*60)));
                    _link(2,"pregnant;"+llList2String(data,1));
                }
                else{
                    _DEBUG("Female: Give birth at nest");
                    _link(5,saved_breedstring);//selectnest
                }
            }
            return;
        }
        if(str=="birth"){
            MyLitters++;
            _link(-60,(string)MyLitters);
            return;
        }
        if(MyAge<Breed_Age_Min||(MyAge>Breed_Age_Max&&Breed_Age_Max!=-1)){return;}//not breeding age
        list info = llParseStringKeepNulls(str,[";/;"],[""]);
        string add = llList2String(info,0);
        string self = llList2String(info,1);
        string saved = llList2String(info,2);
        if(!Keep_Partners||add==""){jump breedcall;}
        data = llParseStringKeepNulls(add,["|"],[]);
        //monogamy
        string partner=llList2String(data,0);
        string partnername=llList2String(data,1);
        if(MyPartner!=partner&&MyPartner!=""){return;}//not my partner
        if(MyPartner==partner){//my partner
            _link(-124,partnername);
            Partner_Timeout_Cycles=0;
            _DEBUG("Female: found my mate: "+partnername);
            jump breedcall;
        }
        //string s = "Partners : "+MyKey+" & "+partner;
        if(MyPartner==""&&Keep_Partners&&_isFamily(add)){return;}//stop incest////////////
        if(self==MyKey){
            MyPartner=partner;
            _link(-49,MyPartner);
            _link(-124,partnername);
            if((integer)saved==FALSE){
                _DEBUG("Female: Confirm my mate "+partnername);
                _link(5,"find-mate+;?"+partner+";+;"+MyKey+";+;"+MyName);
            }
        }
        else{//not looking for me
            return;
        }
        @breedcall;
        _breedingCall(add);
    }
} 
	
	
	
	
				
				breedingCall:
				
				
				
			
			}
	
	
	
			//update each breed
		}		
		else{
			print $breeds[$i]." not found or dead<br>";
		}
	}
	
	//update each chamber
}

////update | not used
//*owner_name
//*breed_update
//
////identification
//breed_id
//breed_name
//breed_chan
//breed_creator
//
////age
//*timer_age
//breed_born
//*breed_dead
//*breed_age
//*breed_notdead
//
////hunger
//*timer_hunger
//*breed_hunger
//
////breeding
//*timer_breed
//breed_gender
//breed_skins
//breed_parents
//*breed_partner
//*breed_litters
//*partner_timeout
//*pregnancy_timeout
//
////growth
//*timer_grow
//*breed_growth_total
//*growth_stages


//debug
print "execution time: ".(string)(microtime()-$start);
?>