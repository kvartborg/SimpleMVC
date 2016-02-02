<?php

class TestEvent extends Event {

  public function fire(){
    $this->info('running TestEvent');
    $data = ['data' => 'cool stuff!', 'test' => true];

    $this->debug($this->data);

  }

}