<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model{
    
    /*public $data = array();
    public $param = array();
    public $param_seo;
    public $param_upload;
    public $resizeImg;
    */
    
    protected $data = array();
    protected $param = array();
    protected $param_seo;
    protected $param_upload;
    protected $resizeImg;
    
    public function getAssetPath(){
        $path = $this->config->item('base_imagePath');
        return $path;
    }
    
    public function setData($data){
        $this->data = $data;
        //var_dump($this->data );
    }
    
    public function addData($data){
        if (is_array($data)){
           
            foreach ( $data as $key => $value ){
                
                $this->data[$key] = $value;
            }
           
        }
	}
	
	public function cekUniq($param){
		if (is_array($param)){
			$this->db->select('id');
			$this->db->where($param);	
			$query=$this->db->get(static::$table);
        
			return $query->row();
		}else{
			return 0;
		}
	}

	public function getGroupConcat($key,$id){
		$Where = " WHERE ";
		if (is_array($id)){
			$c = count($id);
			for($x=0; $x < $c; $x++){
				$wh[] = "id=".$id[$x];
			}
			$Where.= implode(" OR ",$wh);
		}elseif ( $id > 0 ){
			$Where.= "id=".$id;
		}else{
			return false;
		}
		$q = "SELECT GROUP_CONCAT($key) as group_name FROM ".static::$table . $Where;
		
		$res = $this->db->query($q);
		return $res->row();
	}
	public function getById($id){
		$param = array('id' => $id );
		$this->db->where($param);	
		$query=$this->db->get(static::$table);
	
		return $query->row();
	}
    
    public function setParam($data){
        $this->param = $data;
    }
    
    public function getParam(){
        return $this->param;
    }
    
    public function getData($row=false){
        if (!empty($this->param)){            
            
            $config = $this->param;
        
            if( !empty($config['where'])){
    			$this->db->where($config['where']);	
                
                if (!empty($config['or_where'])){
                    $this->db->or_where($config['or_where']);	
                }
                
    		}
    		if( !empty($config['whereQuery'])){
    			$this->db->where($config['whereQuery'],'',FALSE);	
    		}
    		if( !empty($config['whereid'])){
    			$this->db->where(static::$pid,$config['whereid']);	
    		}
    		
            
    		if( !empty($config['like'])){
    			$this->db->like($config['like'],'both');	
    		}
    		if( !empty($config['group_by'])){
    			$this->db->group_by($config['group_by']);	
    		}
    		
    		if( ( !empty($config['limit']) ) ){
    		    if (empty($config['start']) || !isset($config['star']) ){
    				$start='0';
    			}else{
    				$start=$config['start']; 
    			}
    			$this->db->limit($config['limit'],$start);	
    		}
    		
            
            if( !empty($config['select'])){
    			$this->db->select($config['select']);	
    		}
            
            if ( !empty($config['order_by'])){
                $this->db->order_by($config['order_by']);
            }  
        }
        
        $query=$this->db->get(static::$table);
        
        if ($row){
            return $query->row();
        }else{
            return $query->result();    
        }
        
        
    }
    
    public function input($input){
        if (is_array($input)){
            
            foreach ( $input as $key => $value ){
                $this->data[$key] = $this->input->post($key, true);
            }
        }        
    }
    
    public function getLastId(){
		$q = "SELECT id FROM ".static::$table." ORDER BY id DESC LIMIT 1";
		$res = $this->db->query($q);

		return $res->row();
	}
    
    public function cleanInput($input){
        if (is_array($input)){
            
            foreach ( $input as $key => $value ){
                $myinput[$key] = $this->input->post($key, true);
            }
        }     
        
        return $myinput;   
    }
    
    public function setWhereId($id){
        if( !empty($id)){
            $where = array('id'=>$id);
 			$this->param['where'] = $where;	
  		}
    }
    
    public function save(){
       
     
        $con = isset($this->param['where']) ? $this->param['where'] :"" ;
                        
        if (empty($con)){
            $this->db->insert(static::$table,$this->data);
        }else{
            $this->db->where($con);
            $this->db->update(static::$table,$this->data);
        }
		
		$this->param = array();
		
        return $this->db->affected_rows();
    }
    
    public function lastInsert(){
        return $this->db->insert_id();
    }
    
    public function delete(){
        $where = isset($this->param['where']) ? $this->param['where'] :"" ;
        
        if (is_array($where)){
            $this->db->where($where);
            $this->db->delete(static::$table);
            
            return $this->db->affected_rows();    
        }else{
            return 0;    
        }
    }
    
    public function deleteByIdPermanent($id){
        $where = array('id'=>$id) ;
        
        $this->db->where($where);
        if ( $this->db->delete(static::$table)){
            return $this->db->affected_rows();
        }
            
        return 0;
    }
    
    
    
    
    public function deleteById($id){
        $where = array('id'=>$id) ;
        
        $this->db->where($where);
        $data = array('isdelete'=>'1');
        if ( $this->db->update(static::$table,$data) ){
            return $this->db->affected_rows();
        }
            
        return 0;
    }
    public function getTotalRow(){
        $query = "SELECT COUNT(id) as totalRow FROM ".static::$table;
        $res = $this->db->query($query);
        
        return $res->row();
    }
    
    /**/
    
    public function setQuery($query){
        
    }
    
    
    
    /**/
    
    public function clearParam(){
        $this->param = array();
    }
    
    public function setSlug($p){
        $this->param_seo = $p;
    }
    public function getSlug($title, $key){
       
        
        $tabel = static::$table;
        $label = $key;
        $url_title = url_title($title, "-", TRUE);
        
       
        /*$title_seo = strtolower( $title);
        
        $patern = "/[^a-zA-Z0-9 ]/";
        $title_seo = trim( preg_replace($patern," ",$title_seo));
        $title_seo = str_replace(' ','-',$title_seo);
        
        $title_seo = preg_replace('/-+/',"-",trim($title_seo));*/
        
        $where  =array($label=>$url_title);
        $this->db->like($where);
        $seo = $this->db->get($tabel)->result();
        
        $j = count($seo);
        
        if ($j > 0){
            $j += 1;
            $url_title = $url_title."-".$j;
        }
       
        return $url_title;
    }
    
    // Data ttable 
    
    /**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	static function data_output ( $columns, $data )
	{
		$out = array();

		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();

			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];

				// Is there a formatter?
				if ( isset( $column['formatter'] ) ) {
					$row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
				}
				else {
					$row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
				}
			}

			$out[] = $row;
		}

		return $out;
	}

	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	static function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}
        
		return $limit;
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	static function order ( $request, $columns )
	{
		$order = '';

		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = self::pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';

					$orderBy[] = '`'.$column['db'].'` '.$dir;
				}
			}

			$order = 'ORDER BY '.implode(', ', $orderBy);
		}

		return $order;
	}


	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	static function filter ( $request, $columns, &$bindings,$condition='' )
	{
		$globalSearch = array();
		$columnSearch = array();
        $columnFilter = array();
        
		$dtColumns = self::pluck( $columns, 'dt' );
        $suffix    = self::pluck( $columns, 'suffix' );
        $filtered  = self::pluck( $columns, 'filtered' );
       
		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) {
					$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                    
                    $mySuffix = '';
                    if (isset($suffix[$i])){
                        $mySuffix = $suffix[$i].".";
                    }
                    $COL = $column['db'];
                    if (isset($column['searchC'])){
                        $COL = $column['searchC'];
                    }
                    
                    $hasFiltered = true;
                    if (isset($filtered[$i])){
                        $hasFiltered = $filtered[$i];                                                               
                    }
                    $columnFilter[] = $hasFiltered;
                   
                    if ($hasFiltered){
                       // echo $hasFiltered." => " . $mySuffix."`".$COL."` LIKE '%".$str."%' <br/>";
                        $globalSearch[] = $mySuffix."`".$COL."` LIKE '%".$str."%'";
                       
                    }                    
                    
					
				}
			}
            
		}
        
		// Individual column filtering
      
		if ( isset( $request['columns'] ) ) {
			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				$str = $requestColumn['search']['value'];
               
                $hasFiltered = true;
                if (isset($filtered[$i])){
                    $hasFiltered = $filtered[$i];                       
                }
                //var_dump($hasFiltered);
                if ( $hasFiltered ){
    				if ( $requestColumn['searchable'] == 'true' &&
    				 $str != '' ) {
    					$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
    					$columnSearch[] = "`".$column['db']."` LIKE '%".$str."%'";
    				}
                }
                
			}
            
            //exit();
		}

		// Combine the filters into a single string
		$where = '';
        // var_dump($globalSearch);
		if ( count( $globalSearch ) ) {
			$where = '('.implode(' OR ', $globalSearch).')';
		}

		if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
            if (empty($condition)){
                $where = 'WHERE '.$where;
            }else{
                $where = ' AND'.$where;
            }
			
            
		}
        //var_dump($where);
		return $where;
	}


	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
    
    public function simple ( $request, $table, $primaryKey, $columns, $query = "",$condition="" )
	{
		$bindings = array();
		//$db = self::db( $conn );

		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings, $condition );
        
		// Main query to actually get the data
       
        
        if (empty($query)){
            $query = "SELECT `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`";
             
        }else{
            $query2 = $query;
        }
        
        $query.= "
			 $where
			 $order
			 $limit";
        
        $data = $this->db->query($query);
		$data = $data->result_array();
        /*$data = self::sql_exec( $db, $bindings,
			"SELECT `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);*/

		// Data set length after filtering
        
             
        if (!isset($query2)){
            //$query = $query2;
            $query = "SELECT COUNT(`{$primaryKey}`) as count
			 FROM   `$table`
			 $where";
            
            $resFilterLength = $this->db->query($query)->result();
        }     
        
		/*$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`
			 $where"
		);*/
        
        if (isset($query2)){
            $res = $this->db->query($query2);
            $res = $res->num_rows();
            $recordsFiltered = $res;
        }else{
            $recordsFiltered = $resFilterLength[0]->count;// $resFilterLength[0][0];    
        }
		

		// Total data set length
		/*$resTotalLength = self::sql_exec( $db,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`"
		);*/
        
        if (isset($query2)){
            $res = $this->db->query($query2);
            $res = $res->num_rows();
            //var_dump($res);
            $recordsTotal = $res;
        }else{
            $recordsTotal = count($data);
        }
        
		//$recordsTotal = count($data);//$resTotalLength[0][0];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}
     
	public function simplex ( $request, $table, $primaryKey, $columns, $query = "",$condition="" )
	{
		$bindings = array();
		//$db = self::db( $conn );

		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings, $condition );

		// Main query to actually get the data
       
        
        if (empty($query)){
            $query = "SELECT `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`";
             
        }else{
            $query2 = $query;
        }
        
        $query.= "
			 $where
			 $order
			 $limit";
        //var_dump($query);
        $data = $this->db->query($query);
		$data = $data->result_array();
        /*$data = self::sql_exec( $db, $bindings,
			"SELECT `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);*/

		// Data set length after filtering
        
             
        if (!isset($query2)){
            //$query = $query2;
            $query = "SELECT COUNT(`{$primaryKey}`) as count
			 FROM   `$table`
			 $where";
            // var_dump($query2);
            $resFilterLength = $this->db->query($query)->result();
        }     
        
		/*$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`
			 $where"
		);*/
        
        if (isset($query2)){
            $recordsFiltered = count($data);
        }else{
            $recordsFiltered = $resFilterLength[0]->count;// $resFilterLength[0][0];    
        }
		

		// Total data set length
		/*$resTotalLength = self::sql_exec( $db,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`"
		);*/
		$recordsTotal = count($data);//$resTotalLength[0][0];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}


	/**
	 * The difference between this method and the `simple` one, is that you can
	 * apply additional `where` conditions to the SQL queries. These can be in
	 * one of two forms:
	 *
	 * * 'Result condition' - This is applied to the result set, but not the
	 *   overall paging information query - i.e. it will not effect the number
	 *   of records that a user sees they can have access to. This should be
	 *   used when you want apply a filtering condition that the user has sent.
	 * * 'All condition' - This is applied to all queries that are made and
	 *   reduces the number of records that the user can access. This should be
	 *   used in conditions where you don't want the user to ever have access to
	 *   particular records (for example, restricting by a login id).
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array|PDO $conn PDO connection resource or connection parameters array
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @param  string $whereResult WHERE condition to apply to the result set
	 *  @param  string $whereAll WHERE condition to apply to all queries
	 *  @return array          Server-side processing response array
	 */
	static function complex ( $request, $conn, $table, $primaryKey, $columns, $whereResult=null, $whereAll=null )
	{
		$bindings = array();
		$db = self::db( $conn );
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';

		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings );

		$whereResult = self::_flatten( $whereResult );
		$whereAll = self::_flatten( $whereAll );

		if ( $whereResult ) {
			$where = $where ?
				$where .' AND '.$whereResult :
				'WHERE '.$whereResult;
		}

		if ( $whereAll ) {
			$where = $where ?
				$where .' AND '.$whereAll :
				'WHERE '.$whereAll;

			$whereAllSql = 'WHERE '.$whereAll;
		}

		// Main query to actually get the data
		$data = self::sql_exec( $db, $bindings,
			"SELECT `".implode("`, `", self::pluck($columns, 'db'))."`
			 FROM `$table`
			 $where
			 $order
			 $limit"
		);

		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`
			 $where"
		);
		$recordsFiltered = $resFilterLength[0][0];

		// Total data set length
		$resTotalLength = self::sql_exec( $db, $bindings,
			"SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table` ".
			$whereAllSql
		);
		$recordsTotal = $resTotalLength[0][0];

		/*
		 * Output
		 */
		return array(
			"draw"            => isset ( $request['draw'] ) ?
				intval( $request['draw'] ) :
				0,
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}




	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	static function sql_exec ( $db, $bindings, $sql=null )
	{
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}

		$stmt = $db->prepare( $sql );
		//echo $sql;

		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];
				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
			}
		}

		// Execute
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			self::fatal( "An SQL error occurred: ".$e->getMessage() );
		}

		// Return all
		return $stmt->fetchAll( PDO::FETCH_BOTH );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	static function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );

		exit(0);
	}

	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	static function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );

		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);

		return $key;
	}


	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	static function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            if (isset($a[$i][$prop])){
                $out[] = $a[$i][$prop];
            }
			
            
		}
        //var_dump($a);
       
		return $out;
	}


	/**
	 * Return a string from an array or a string
	 *
	 * @param  array|string $a Array to join
	 * @param  string $join Glue for the concatenation
	 * @return string Joined string
	 */
	static function _flatten ( $a, $join = ' AND ' )
	{
		if ( ! $a ) {
			return '';
		}
		else if ( $a && is_array($a) ) {
			return implode( $join, $a );
		}
		return $a;
	}
    
    public function uploadImage2($directory, $fileinput="userfile", $thumbs = true, $unlink = false ){        
        
        $setting = array(
				"upload_path"	=> "../assets/images//".$directory,
                "allowed_types" => "gif|jpg|png|jpeg|swf",
                "encrypt_name"  => true,
                "max_size"	    => '2048',
                "remove_spaces" => true
			);
        $this->upload->initialize($setting);
		
        //exit();
        if($this->upload->do_upload($fileinput)){
		      $dataFile = $this->upload->data();
              $data     =  array('upload_data' => $this->upload->data());
              $dir      = "../assets/images/".$directory;
              $path     = $dir."/".$data['upload_data']['file_name'];
              $dataImg  = array(
                                'error'=>false,   
                                );
              $file   = $setting['upload_path']."/".$data['upload_data']['file_name'];   
                               
              if ($thumbs){
                  $resize = $this->load->helper('image_lib');         
                    
                  $resize = new Image_lib($file);              
                                    
                  $thumb_namanya = "thumb_".$data['upload_data']['file_name'];
                  $newpath1        = $dir."/thumbs/".$thumb_namanya;
                  $resize = new Image_lib($file);
                  
                  
                  $resize->resizeTo(120,0, 'maxwidth');
                  
                  $resize->saveImage($newpath1);
                  
                  $dataImg['thumb_path'] = $newpath1;
              }  
              
              if ( $unlink ){
                  unlink($file);
              }else{
                  $dataImg['image_path'] = $path;
              } 
                
              // unlink($file);
                
		}else{
		      $dataImg = array(
                            'error'=>true,
                            'errdata'=>$this->upload->display_errors()
                            );
		}
        return $dataImg;
    }
    
    public function mypaging($url, $totalrow=10, $perpage=10){
        $this->load->library('pagination');

        $config['base_url']   = $url;
        $config['total_rows'] = $totalrow;
        $config['per_page']   = $perpage;
        
        $this->pagination->initialize($config);
        
        $paging = $this->pagination->create_links();
        
        return $paging;
    }
    
}