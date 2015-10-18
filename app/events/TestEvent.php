<?php

class TestEvent extends Event {

  public function fire(){
    $this->info('fireing TestEvent');
    sleep(10);
    $this->info('stopping TestEvent');
  }

}