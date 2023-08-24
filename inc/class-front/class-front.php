<?php 
/**
* Main class for Front mini controller class
*/
class Front {

	/*
	* Load view file with attached data
	* params: $file = name of file, $data = array of data
	*
	*/
	public function load_view( $file, $data = array() ) {
		global $post; $main_post = $post;
		extract( $data );
		$rfl = new ReflectionClass($this);
		$dir_path = dirname( $rfl->getFilename() );
		include( $dir_path . '/' . $file . '.php' );
		// reset za svaki slucaj
		$post = $main_post;
	}


	/*
		* Retrive the instance of the class
		*
	*/
    final public static function get_instance() {
        static $instances = array();

        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $instances[$calledClass] = new $calledClass();
        }

        return $instances[$calledClass];
    }


    final private function __clone()
    {
    }


}