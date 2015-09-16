<?php

class TestEvent extends Event {

  public function fire(){
    $this->info("Testing...");
    $this->error("Error");
    //var_dump(User::all());
  }
}