# RAR Framework in PHP [ ![Codeship Status for aleDsz/rarframework](https://app.codeship.com/projects/037cc270-65b2-0135-dc38-623163ca562f/status?branch=master)](https://app.codeship.com/projects/240763)

## 1. Introdução

Quando eu tive de criar um site em PHP, percebi que eu demandava muito do meu tempo na construção do back-end, tendo de me preocupar com a conexão com o banco de dados e com o acesso às intruções SQL. Porém, se eu fizesse uma troca de banco de dados eu teria de mudar todo o meu site para que ele funcionasse neste novo banco de dados.

Pensando nisso, tive a ideia de criar um framework que me ajudasse toda vez que eu fosse desenvolver um site novo e que precisasse de acesso ao banco de dados.


## 2. Como Funciona

Através da classe PDO, é possível realizar uma conexão com vários tipos de banco de dados. Além disso, por meio do `Generics`, é possível acessar o conteúdo de um objeto e obter todas as informações necessárias para criar uma instrução SQL.

Neste caso, uma classe deve seguir o seguinte modelo:

```php
<?php

/**
 * @table nome_da_tabela
 */
class ClasseTeste {
	public function __construct() {}

	/**
	 * @field nome_do_campo
	 * @type varchar
	 * @pk False
	 * @size 30
	 */
	public $Campo;
}

?>
```

**OBS.:** Percebe-se que, acima da nomenclatura da propriedade `$Campo`, existe um comentário com 4 informações diferentes (*field*, *type*, *pk* e *size*). Além disso, acima da nomenclatura da classe, existe um comentário com a função de armazenar o nome da tabela na qual a classe em questão pertence.
Essas 4 informações acima da propriedade tem como objetivo, facilitar a criação de instrução SQL, visto que essas informações podem ser alteradas sem afetar o banco de dados em si, apenas para melhorar a performance do seu sistema.

## 3. Como Utilizar

Para que você possa utilizar todos as funcionalidades do framework no seu ambiente, você pode criar 1 (ou mais, dependendo da sua forma de trabalho) classe para acessar ao banco de dados de forma genérica.

```php
<?php

namespace DataAccess;

use RAR\Framework\Database\DatabaseFactory;
use RAR\Framework\Database\Data\DataContext;
use RAR\Framework\Database\Command\CommandContext;
use RAR\Framework\Database\Objects\ObjectContext;
use RAR\Framework\Database\SQL\SqlStatementInsert;
use RAR\Framework\Database\SQL\SqlStatementUpdate;
use RAR\Framework\Database\SQL\SqlStatementSelect;
use RAR\Framework\Database\SQL\SqlStatementDelete;

/**
 * Model's Data Access class
 */
class ModelDataAccess
{
	protected $dataContext    = null;
	protected $sqlStatement   = null;
	protected $objContext     = null;
	protected $commandContext = null;

	public function __construct()
	{
		$this->dataContext = DatabaseFactory::InstaceOfDataContext();
	}

	public function create($obj)
	{
		$this->sqlStatement   = new SqlStatementInsert($obj);
		$this->objContext     = new ObjectContext($obj);
		$this->commandContext = new CommandContext($this->sqlStatement->GetSQL());

		$this->commandContext->ExecuteQuery();
	}

	public function save($obj)
	{	
		$this->sqlStatement   = new SqlStatementUpdate($obj);
		$this->objContext     = new ObjectContext($obj);
		$this->commandContext = new CommandContext($this->sqlStatement->GetSQL());

		$this->commandContext->ExecuteQuery();
	}

	public function find($obj)
	{
		$this->sqlStatement   = new SqlStatementSelect($obj);
		$this->objContext     = new ObjectContext($obj);
		$this->commandContext = new CommandContext($this->sqlStatement->GetSQL());

		return $this->objContext->GetObject($this->commandContext->ExecuteReader());
	}

	public function findAll($obj)
	{
		$this->sqlStatement   = new SqlStatementSelect($obj);
		$this->objContext     = new ObjectContext($obj);
		$this->commandContext = new CommandContext($this->sqlStatement->GetSQL(true));

		return $this->objContext->GetObjects($this->commandContext->ExecuteReader());
	}

	public function remove($obj)
	{
		$this->sqlStatement   = new SqlStatementDelete($obj);
		$this->objContext     = new ObjectContext($obj);
		$this->commandContext = new CommandContext($this->sqlStatement->GetSQL());

		$this->commandContext->ExecuteQuery();
	}
}
```

**OBS.:** Você não precisa criar a classe de forma genérica, você pode criar uma classe de acesso a dados para cada entidade que você criar no modelo citado acima.

## 4. Como Contribuir

Para contribuir, você pode realizar um **fork** do nosso repositório e nos enviar um Pull Request.

## 5. Doação

Caso queria fazer uma doação para o projeto, você pode realizar [aqui](https://twitch.streamlabs.com/aleDsz)

## 6. Suporte

Caso você tenha algum problema ou uma sugestão, você pode nos contatar [aqui](https://github.com/aleDsz/rarframework/issues).

## 7. Licença

Cheque [aqui](LICENSE)
