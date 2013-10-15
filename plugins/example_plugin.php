<?php

/*
 * Example for creating your own php class
 * allowing you to add your own engines to the system
 * and therby customize you system 100%
 *
 * note this only an example, you can test it out
 * by adding $engine->example_plugin->GreetWorld();
 * anywhere in your system.
 * also allowing you to use all main core functions
 * such as mysql example: $this->cms->Sql->query("your sql command"); 
 * -
 * - $this->cms->Sql->function()
 * - $this->cms->Session->function()
 * - $this->cms->Config->function()
 * - $this->cms->Mail->function()
 * - $this->cms->Users->function()
 *
 * For a complete command list check out,
 * http://acid-evo.com/functions.txt
 */


/* begin our class */
class example_plugin {

      var $cms;

      /* Load the main core functions */
      function example_plugin(&$cms){
        $this->cms = $cms;
      }

     function GreetWorld(){
       return "Hello world! - Your class has succesfully loaded in to the main core! Enjoy!";
     }
}
