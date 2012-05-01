<?php
include_once("classes/tarefa.php");
$Tarefa = new Tarefa;

$action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : "" ;
$tarefa = isset($cursorShow['Tarefa']) ? $cursorShow['Tarefa'] : "" ;

switch($action){
	case "inserir":
		$Tarefa->UsuarioID  = 0;
		$Tarefa->Usuario    = 'todos';
		$Tarefa->Tarefa     = $_REQUEST["Tarefa"];
		$Tarefa->Tipo       = 'obrigatório';
		$Tarefa->Prioridade = 0;

		$Tarefa->inserir();
		break;
	case "alterar":
		$Tarefa->_id = $_REQUEST['_id'];
		$Tarefa->Tarefa = $_REQUEST['Tarefa'];
		$Tarefa->mudar_tarefa();
		
		$cursorShow = $Tarefa->consultar($_REQUEST['_id']);
		break;
	case "alterarPrioridade":
		$Tarefa->_id = $_REQUEST['_id'];
		$Tarefa->modo = $_REQUEST['p'];
		$Tarefa->mudar_prioridade();
		
		$cursorShow = $Tarefa->consultar($_REQUEST['_id']);
		break;
	case "excluir":
		$Tarefa->_id = $_REQUEST['_id'];
		$Tarefa->excluir();
		
		$cursorShow = $Tarefa->consultar($_REQUEST['_id']);
		break;
	default:
		$cursorShow = (isset($_REQUEST['_id'])) ? $Tarefa->consultar($_REQUEST['_id']) : "";
		$tarefa = isset($cursorShow['Tarefa']) ? $cursorShow['Tarefa'] : "" ;

}//fim switch

$filter = array();
$cursor = $Tarefa->listar($filter);
$cursor->sort(array('Prioridade' => -1))->limit(41)->skip(0);

foreach($cursor as $i => $item){
	$btn_deletar = "<a href='?action=excluir&_id=$i'>x</a>";
	$tarefa = "<a href='?_id=$i'>" . $item['Tarefa'] . "</a> ";
	$controles = "<span id='updown'>[<a href='?action=alterarPrioridade&_id=$i&p=up'>▲</a>
					   <a href='?action=alterarPrioridade&_id=$i&p=down'>▼</a>] 
	$item[Prioridade]</span><br/>";

	$tarefa_linha = "";
	$tarefa_linha .= $btn_deletar;
	$tarefa_linha .= " - ";
	$tarefa_linha .= $tarefa;
	$tarefa_linha .= $controles;

	echo $tarefa_linha;
}
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>iMasters - Sistema de Tarefas</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
</body>
</html>

	<br/><br/>
<form action='index.php' method='post'>
	<label>Nova tarefa</label>
    <input type='text' id='Tarefa' name='Tarefa' />
    <input type='hidden' name='_id' value='<?php echo $_REQUEST['_id'];?>' />
    <input type='hidden' name='action' value='inserir' />
    <input type='submit' value='Inserir' />
</form>
<form action='index.php' method='post'>
	<label>Alterar tarefa</label>
    <input type='text' id='Tarefa' name='Tarefa' value='<?=$tarefa?>' />
    <input type='hidden' name='_id' value='<?php echo $_REQUEST['_id'];?>' />
    <input type='hidden' name='action' value='alterar' />
    <input type='submit' value='Alterar' />
</form>
