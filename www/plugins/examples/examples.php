
////Stages in order - one at a time

"Timer",
"prop(Timer,+1)
filter(%Timer%>2, Stage 1, %Timer%>3, Stage 2, %Timer%>4, Stage 3,%Timer%>5, Stage 4)
toggle(Stage 5)
prop(Timer,0)",

"Stage 1",
"say(%this%)",

"Stage 2",
"say(%this%)",

"Stage 3",
"say(%this%)",

"Stage 4",
"say(%this%)",

"Stage 5",
"say(%this%)"


//listen example
 "start",
 "bind(listen, owner, return)",
 
 "return",
 "filter(%chatmsg%~%MyName%)
  rfilter(%chatmsg%~come, come, %chatmsg%~home, home) 
  say(Say my name plus \"home\" or \"come\" for more options!)"
  
 "home",
 "move(%actionpos%, <0.2i,0.2i,0>, walk)",
 
 "come",
 "move(%chatpos%, null, walk)"


//listen wander/come/home/stop
 "start",
 "bind(listen, owner, return)",
 
 "return",
 "filter(%chatmsg%~%MyName%,not)
  rfilter(%chatmsg%~come, come, %chatmsg%~home, home, %chatmsg%~stop, disable_wander, %chatmsg%~wander, start_wander) 
  say(Say my name plus \"home\", \"stop\", \"wander\" or \"come\" for more options!)",
 
 "home",
 "unbind(end-wander)
  move()
  move(%actionpos%, <0.2i,0.2i,0>, walk)",
 
 "come",
 "unbind(end-wander)
  move()
  move(%ownerpos%, null, walk)",
  
 "wander",
 "move(%actionpos%, <5i,5i,-0.25>, nonphys, normal, null, 3, avoid)",

 "avoid",
 "toggle(wander)",
   
 "start_wander",
 "bind(timer, 10r, wander, end-wander)",
  
 "disable_wander",
 "unbind(end-wander)
  move()"
  
  
//menu wander/come/home
 "start",
 "unbind()
  prop(Wander, Wander OFF)
  bind(timer, 10r, wander, end-wander)",
 
 "home",
 "unbind(end-wander)
  move()
  move(%actionpos%, <0.2i,0.2i,0>, walk)",
 
 "come",
 "unbind(end-wander)
  move()
  move(%ownerpos%, null, walk)",
  
 "wander",
 "move(%actionpos%, <5i,5i,-0.25>, nonphys, normal, null, 3, avoid)",

 "avoid",
 "toggle(wander)",
  
 "touch-num-0",
 "filter(%action-touchkey%=%ownerkey%, public-menu)
  @menu(%ownerkey%, This is a test menu!, Come Here=come, %Wander%=wander_toggle, Go Home=home)",
  
  "public-menu",
  "@menu(%action-touchkey%, Test public menu!, Okay=null)",
  
 "wander_toggle",
 "filter(%Wander%=Wander ON, disable_wander)
  prop(Wander, Wander OFF)
  bind(timer, 10r, wander, end-wander)",
  
 "disable_wander",
 "unbind(end-wander)
  move()
  prop(Wander, Wander ON)"


//test default

"start",
"say(Hello, Eco!)
 text(eco-breed v 0.216)
 toggle(text)
 unbind()
 bind(timer,10,text)
 ",
 
 "text",
 "text(
Species: %MySpecies%
Family: %MyFamily% 
Owner: %owner%
Name: %MyName%
Age: %MyAge%
Key: %MyKey%
Gender: %MyGender%
Generation: %MyGeneration% 
Parents: %MyParents%
Skins: %Type%
)"



//stress test

 "start",
 "say(Hello, Eco!)
  bind(touch, owner, touched)
  bind(timer, 5, test)",
  
  "touched",
  "ownersay(%MyAge%)",
  
  "test",
  "ownersay(%this%)
  text(authenticated!\n %MyName% \n %MyGender% \n %MyPartner%)"