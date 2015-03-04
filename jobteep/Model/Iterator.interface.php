<?php

interface Iterator extends Transversable {
	
	abstract public function current ();
	abstract public function key ();
	abstract public function next ();
	abstract public function rewind ();
	abstract public function valid ();
}