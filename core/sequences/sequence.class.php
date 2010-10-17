<?php 
/**
 * a sequence is a finite collection of elements which can be traversed one way
 * there also may be infinite implementations like the TriRunWorkoutSequence 
 * @author clemens
 *
 */
abstract class Sequence implements Iterator {
	protected $position = -1;
    protected $sequence = array();

    /**
	 * reset the iterator
     */
    public function rewind() {
        $this->position = 0;
    }

    /**
	 * get the current item
     */
    public function current() {
        if ($this->position == -1) {
        	$this->position = 0;
        }
    	return $this->sequence[$this->position];
    }

    /**
	 * get the current key
     */
    public function key() {
        return $this->position;
    }

    /**
	 * step forward
     */
    public function next() {
        ++$this->position;
    }

    /**
	 * is the position valid?
     */
    public function valid() {
        return isset($this->sequence[$this->position]);
    }	
}

?>