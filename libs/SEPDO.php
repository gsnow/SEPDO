<?php
class SEPDO
{
	/**
	 * To hold the PDO instance object
	 *
	 * @var [object] int_db
	 */
	private $int_db;
	/**
	 * To hold the PDO Prepare Query
	 * 
	 * @var [object] db_instance
	 */
	private $db_instance;

    /**
     * @var $db_arc
     * Must be set to change the Database Type EG: POSTGRESSQL, MYSQL, MSSQLE, MarionDB Etc...
     */
    public $db_arc;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
        // if db_arc is not set assign default value of mysql
        if($this->db_arc == null){ $this->db_arc='mysql';}

        // build connection string
        $dns = 'mysql'.':dbname='.lc_database.';host='.lc_host;

       	// Initiate class PDO
       	$this->int_db = new PDO($dns, lc_username, lc_password);

       	// set attributes
        $this->int_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	/**+========================================================+
	 * @Private @Function   build
	 * @param               [type] $var
	 *=========================================================+*/
	private function build($var)
	{

		// check if 'the_query' is presant and in an array
		if(isset($var['the_query']))
		{
			$query = $var['the_query'];
		}

		/*
		 * prepare the query and set the private variable 'db_instance' to the pdo
		 * prepare object
		 */
		$this->db_instance = $this->int_db->prepare($query);
	}

    /**
     *
     */
	private function send_query()
	{

		$this->db_instance->execute();

	}

    /**
     * [retreive description]
     * @param $var
     * @return array [type] $data_array
     */
	public function retrieve ($var)
	{
		$data_array = [];
		self::build($var);
		self::send_query();
		$data_array['the_number_of_rows']	 = $this->db_instance->rowCount();
		$data_array['the_query_results'] 	 = $this->db_instance->fetchAll(PDO::FETCH_ASSOC);

		return $data_array;
	}

    /**
     * @param $var : varibale containing the inset query
     */
    public function send ($var)
    {
        self::build($var);
        self::send_query();
    }

	/**
	 * [rowcount description]
	 * @return [type]
     * @return rowCount()
	 */
	private function rowcount()
	{

		return rowCount($this->db_instance);

	}
}
