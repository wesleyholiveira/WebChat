<?

class DataBase{
	private $host;
	private $user;
	private $password;
	private $banco;

	public function __construct($host, $user, $password, $banco){
		mysql_connect($host, $user, $password) or die("Não foi possível conectar ao banco de dados com estes parâmetros");
		mysql_select_db($banco) or die("Não foi possível selecionar o banco de dados informado");
	}

	public function query($query){
		return mysql_query($query);
	}

	public function fetch_assoc($result){
		return mysql_fetch_assoc($result);
	}

	public function num_rows($result){
		return mysql_num_rows($result);
	}

	public function find($find, $table){
		switch ($find) {
			case 'last':
				$result = $this->query("SELECT * from $table order by id DESC LIMIT 1");
				break;

			case 'first':
				$result = $this->query("SELECT * from $table order by id ASC LIMIT 1");
				break;
			
			default:
				# code...
				break;
		}

		return $this->fetch_assoc($result);
	}

	public function trata($str){
		return addslashes($str);
	}
}

$m = new DataBase(HOST, USER, PASSWORD, BANCO);

?>