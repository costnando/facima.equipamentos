<?php

/*!
 * All Functions
 * Designer & Programmer by Night Web (www.nightweb.com.br)
 */

// Date Default

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Maceio');

// Session Start

session_name('user');
session_start();

// Function Logged

if(empty($_SESSION['logged'])) {
	$_SESSION['logged'] = "no-logged";
}

// Connect MySQL

$connect = new PDO("mysql:host=localhost; dbname=facima", "root", "");
$connect->query("SET NAMES utf8;");

	// Function validate E-mail

	function val_email($string) {
		if(filter_var($string, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function validate CPF
	
	function val_cpf($string) {
		$string = preg_replace( '/[^0-9]/is', '', $string);
		if(strlen($string) != 11) {
			return false;
		}
		if(preg_match('/(\d)\1{10}/', $string)) {
			return false;
		}
		for($t = 9; $t < 11; $t++) {
			for($d = 0, $c = 0; $c < $t; $c++) {
				$d += $string{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if($string{$c} != $d) {
				return false;
			}
		}
		return true;
	}
	
	// Function validate existing User
	
	function existing_user($string) {
		global $connect;
		$select = $connect->prepare('SELECT * FROM user WHERE name_user=:user LIMIT 1');
		$select->bindValue("user", $string);
		$select->execute();
		if(!$select->rowCount() <= 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function validate existing Email
	
	function existing_email($string) {
		global $connect;
		$select = $connect->prepare('SELECT * FROM user WHERE email_user=:email LIMIT 1');
		$select->bindValue("email", $string);
		$select->execute();
		if(!$select->rowCount() <= 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Function validate existing CPF
	
	function existing_cpf($string) {
		global $connect;
		$select = $connect->prepare('SELECT * FROM user WHERE cpf_user=:cpf LIMIT 1');
		$select->bindValue("cpf", $string);
		$select->execute();
		if(!$select->rowCount() <= 0) {
			return true;
		} else {
			return false;
		}
	}

	function delete() {

		global $connect;

		$del_id	= $_GET['del_id'];

		$delete  = $connect->prepare("DELETE FROM user WHERE id_user='$del_id'");
		$delete -> execute();

		header("location:logado/lib/user.php");
	}
	

	function login($email, $password) {
		global $connect;
		$res = new stdClass();
		$login = $connect->prepare("SELECT * FROM user WHERE (email_user = :email_user AND password_user = :password_user) LIMIT 1");
		$login->bindValue("email_user", $email, PDO::PARAM_STR);
		$login->bindValue("password_user", $password, PDO::PARAM_STR);
		$login->execute();
		if(!$login->rowCount() <= 0) {
			$res->status = "ok";
			$res->dados = $login->fetchObject();
			
			if($res->dados->status == "false") {
				$res->status = "inative";
			} else {
				$_SESSION['email_user'] = $email;
				$_SESSION['logged'] 	= "logged";
			}
			
		} else {
			$res->status = "error-login";
			$_SESSION['logged'] = "no-logged";
		}
		return $res;
	}
	
	function dataUser() {
		global $connect;
		$email = $_SESSION['email_user'];
		if(!empty($email)) {
			$dataUser = $connect->prepare("SELECT * FROM user WHERE email_user = :email LIMIT 1");
			$dataUser->bindValue("email", $email, PDO::PARAM_STR);
			$dataUser->execute();
			if(!$dataUser->rowCount() <= 0) {
				return $dataUser->fetchObject();
			} else {
				return false;
			}
		}
	}
	
	function userPerfil($usuario, $nome, $cpf, $email, $senha) {
		global $connect;
		$dataUser = dataUser();
		$senhaEncrypt = sha1(md5($senha));
		if(empty($senha)) {
			$query = "UPDATE user SET name_user=:usuario, full_name_user=:nome, cpf_user=:cpf, email_user=:email WHERE id_user=:id";
		} else {
			$query = "UPDATE user SET name_user=:usuario, full_name_user=:nome, cpf_user=:cpf, email_user=:email, password_user=:senha WHERE id_user=:id";
		}
		$userPerfil = $connect->prepare($query);
		$userPerfil->bindValue("id", $dataUser->id_user);
		$userPerfil->bindValue("usuario", $usuario);
		$userPerfil->bindValue("nome", $nome);
		$userPerfil->bindValue("cpf", $cpf);
		$userPerfil->bindValue("email", $email);
		if(!empty($senha)) {
			$userPerfil->bindValue("senha", $senhaEncrypt);
		}
		$userPerfil->execute();
	}
	
	function dataUserforEmail($email) {
		global $connect;
		if(!empty($email)) {
			$dataUser = $connect->prepare("SELECT * FROM user WHERE email_user = :email LIMIT 1");
			$dataUser->bindValue("email", $email, PDO::PARAM_STR);
			$dataUser->execute();
			if(!$dataUser->rowCount() <= 0) {
				return $dataUser->fetchObject();
			} else {
				return false;
			}
		}
	}
	
	
	function forgotPassword($email) {
		global $connect;
		
		$dataUser = dataUserforEmail($email);
		
		// Acesso email SMTP
		$hostsystem  = "mail.nightweb.com.br";
		$portsystem  = 465;
		$nomesystem  = "Night Web Developer";
		$emailsystem = "developer@nightweb.com.br";
		$senhacrypt  = "QE1hODcwMzE0MDAu";
		$senhasystem = base64_decode($senhacrypt);
		
		// Caracteres para nova senha
		$caracteres = "0123456789abcdefghijklmnopqrstuvwxyz+-/()";
		
		// Senha aleatória com os caracteres da variavél ($caracteres).
		$newpass = substr(str_shuffle($caracteres),0,10);
		
		// Inclui o arquivo class.phpmailer.php
		require_once("phpmailer/class.phpmailer.php");

		$emailbody ="<div style=\"text-transform:uppercase;font-size:16px;font-weight:bold;\">Recuperar Senha - Facima</div><br/>";
		$emailbody .="<div style=\"font-size:14px;\">Olá $dataUser->full_name_user,<br/>";
		$emailbody .="Segue abaixo sua nova senha de acesso para o e-mail $email<br/>";
		$emailbody .="Sua nova senha é: <b>$newpass</b><br/><br/></div>";
		$emailbody .="<div style=\"font-size:12px;\">Tecnologia de e-mail desenvolvida por <b>NightWeb!</b></div>";

		$mail= new PHPMailer;
		$mail->CharSet= "UTF-8";
		$mail->SMTPDebug = false;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = $hostsystem;
		$mail->Port = $portsystem;
		$mail->Username = $emailsystem;
		$mail->Password = $senhasystem;
		$mail->SetFrom($emailsystem, $nomesystem);
		$mail->addAddress($email, $dataUser->full_name_user);
		$mail->Subject = 'Recuperar Senha - Facima';
		$mail->msgHTML($emailbody);
		$mail->send();
		
		$forgotPassword = $connect->prepare("UPDATE user SET password_user=:newpass WHERE email_user=:email");
		$forgotPassword->bindValue("email", $email);
		$forgotPassword->bindValue("newpass", sha1(md5($newpass)));
		$forgotPassword->execute();
	}

	function logout() {
		global $connect;
		session_name('user');
		session_destroy();
	}
	
	function register($nome, $usuario, $email, $cpf, $senha) {
		global $connect;
		$senhaEncrypt = sha1(md5($senha));
		$insert = $connect->prepare("INSERT INTO user (full_name_user, name_user, email_user, cpf_user, password_user) VALUES (:nome, :usuario, :email, :cpf, :senha)");
		$insert->bindValue("nome", $nome);
		$insert->bindValue("usuario", $usuario);
		$insert->bindValue("email", $email);
		$insert->bindValue("cpf", $cpf);
		$insert->bindValue("senha", $senhaEncrypt);
		$insert->execute();
	}
	
	function allUsers() {
		global $connect;
		$allUsers = $connect->prepare("SELECT * FROM user ORDER BY id_user ASC");
		$allUsers->execute();
		return $allUsers->fetchAll(PDO::FETCH_OBJ);
	}
	
	function getReserve($where = 0) {
		global $connect;
		$query  = "SELECT * FROM reserve";
		if($where != 0) {
			$query .= "WHERE ".$where;
		}
		$query .= " ORDER by id_reserve DESC";
		$getReserve = $connect->prepare($query);
		$getReserve->execute();
		return $getReserve->fetchAll(PDO::FETCH_OBJ);
	}
	
	function getDataStock($id) {
		global $connect;
		$getDataStock = $connect->prepare("SELECT * FROM stock WHERE id_item=:id LIMIT 1");
		$getDataStock->bindValue("id", $id, PDO::PARAM_STR);
		$getDataStock->execute();
		if(!$getDataStock->rowCount() <= 0) {
			return $getDataStock->fetchObject();
		} else {
			return false;
		}
	}
	
	function getDataUserStock($id) {
		global $connect;
		$getDataUserStock = $connect->prepare("SELECT * FROM user WHERE id_user=:id LIMIT 1");
		$getDataUserStock->bindValue("id", $id, PDO::PARAM_STR);
		$getDataUserStock->execute();
		if(!$getDataUserStock->rowCount() <= 0) {
			return $getDataUserStock->fetchObject();
		} else {
			return false;
		}
	}
	
	function getAllStock() {
		global $connect;
		$getAllStock = $connect->prepare("SELECT * FROM stock ORDER by id_item");
		$getAllStock->execute();
		if(!$getAllStock->rowCount() <= 0) {
			return $getAllStock->fetchAll(PDO::FETCH_OBJ);
		} else {
			return false;
		}
	}
	
	function dataStock($id) {
		global $connect;
		$dataStock = $connect->prepare('SELECT * FROM stock WHERE id_item=:id LIMIT 1');
		$dataStock->bindValue("id", $id);
		$dataStock->execute();
		if(!$dataStock->rowCount() <= 0) {
			return $dataStock->fetchObject();
		} else {
			return false;
		}
	}
	
	function reserveItem($item, $quantidade, $entrega, $horaentrega, $devolucao, $horadevolucao, $local) {
		global $connect;
		$datareserva = time();
		$user = dataUser()->id_user;
		$reserveItem = $connect->prepare('INSERT INTO reserve (delivery_reserve, date_reserve, local_reserve, item, quantidade, user, devolution, horaentrega, horadevolucao) VALUES (:delivery_reserve, :date_reserve, :local_reserve, :item, :quantidade, :user, :devolution, :horaentrega, :horadevolucao)');
		$reserveItem->bindValue('delivery_reserve', $entrega);
		$reserveItem->bindValue('date_reserve', $datareserva);
		$reserveItem->bindValue('devolution', $devolucao);
		$reserveItem->bindValue('local_reserve', $local);
		$reserveItem->bindValue('item', $item);
		$reserveItem->bindValue('quantidade', $quantidade);
		$reserveItem->bindValue('horaentrega', $horaentrega);
		$reserveItem->bindValue('horadevolucao', $horadevolucao);
		$reserveItem->bindValue('user', $user);
		$reserveItem->execute();
	}
	
	function dataReserve($id) {
		global $connect;
		$dataReserve = $connect->prepare('SELECT * FROM reserve WHERE id_reserve=:id LIMIT 1');
		$dataReserve->bindValue("id", $id, PDO::PARAM_STR);
		$dataReserve->execute();
		if(!$dataReserve->rowCount() <= 0) {
			return $dataReserve->fetchObject();
		} else {
			return false;
		}
	}
	
	function updateStockforReserve($item, $valor) {
		global $connect;
		$updateStockforReserve = $connect->prepare('UPDATE stock SET remaining=:valor WHERE id_item=:item');
		$updateStockforReserve->bindValue('valor', $valor);
		$updateStockforReserve->bindValue('item', $item);
		$updateStockforReserve->execute();
	}

	function getStock() {
		global $connect;
		$select = $connect->prepare("SELECT * FROM stock ORDER by id_item DESC");
		$select->execute();
		return $select->fetchAll(PDO::FETCH_OBJ);
	}

	function insertStock($code_item, $name_item, $amount_item, $description_item, $conteudo_item) {
		global $connect;
		$insertStock = $connect->prepare("INSERT INTO stock (code_item, name_item, amount_item, description_item, img_item, remaining) VALUES (:code, :name, :amount, :description, :img, :remaining)");
		$insertStock->bindValue("code", $code_item);
		$insertStock->bindValue("amount", $amount_item);
		$insertStock->bindValue("name", $name_item);
		$insertStock->bindValue("description", $description_item);
		$insertStock->bindValue("img", $conteudo_item);
		$insertStock->bindValue("remaining", $amount_item);
		$insertStock->execute();
	}
	
	function dataEditUser($id) {
		global $connect;
		$dataEditUser = $connect->prepare("SELECT * FROM user WHERE id_user=:id LIMIT 1");
		$dataEditUser->bindValue("id", $id);
		$dataEditUser->execute();
		if(!$dataEditUser->rowCount() <= 0) {
			return $dataEditUser->fetchObject();
		} else {
			return false;
		}
	}
	
	function verifyUser($id) {
		global $connect;
		$res = new stdClass();
		$verifyUser = $connect->prepare("SELECT * FROM user WHERE id_user=:id LIMIT 1");
		$verifyUser->bindValue("id", $id);
		$verifyUser->execute();
		if(!$verifyUser->rowCount() <= 0) {
			$res->status = "ok";
		} else {
			$res->status = "error";
		}
		return $res;
	}
	
	function editUser($id, $usuario, $nome, $cpf, $email, $status, $permissao, $senha) {
		global $connect;
		$senhaEncrypt = sha1(md5($senha));
		if(empty($senha)) {
			$query = "UPDATE user SET name_user=:usuario, full_name_user=:nome, cpf_user=:cpf, email_user=:email, status=:status, permission_user=:permissao WHERE id_user=:id";
		} else {
			$query = "UPDATE user SET name_user=:usuario, full_name_user=:nome, cpf_user=:cpf, email_user=:email, status=:status, permission_user=:permissao, password_user=:senha WHERE id_user=:id";
		}
		$editUser = $connect->prepare($query);
		$editUser->bindValue("id", $id);
		$editUser->bindValue("usuario", $usuario);
		$editUser->bindValue("nome", $nome);
		$editUser->bindValue("cpf", $cpf);
		$editUser->bindValue("email", $email);
		$editUser->bindValue("status", $status);
		$editUser->bindValue("permissao", $permissao);
		if(!empty($senha)) {
			$editUser->bindValue("senha", $senhaEncrypt);
		}
		$editUser->execute();
	}
	
	function deleteUser($id) {
		global $connect;
		$deleteUser = $connect->prepare("DELETE FROM user WHERE id_user=:id");
		$deleteUser->bindValue("id", $id);
		$deleteUser->execute();
	}
	
	function dataEditStock($id) {
		global $connect;
		$dataEditStock = $connect->prepare("SELECT * FROM stock WHERE id_item=:id LIMIT 1");
		$dataEditStock->bindValue("id", $id);
		$dataEditStock->execute();
		if(!$dataEditStock->rowCount() <= 0) {
			return $dataEditStock->fetchObject();
		} else {
			return false;
		}
	}
	
	function verifyStock($id) {
		global $connect;
		$res = new stdClass();
		$verifyStock = $connect->prepare("SELECT * FROM stock WHERE id_item=:id LIMIT 1");
		$verifyStock->bindValue("id", $id);
		$verifyStock->execute();
		if(!$verifyStock->rowCount() <= 0) {
			$res->status = "ok";
		} else {
			$res->status = "error";
		}
		return $res;
	}
	
	function updateStock($id, $codigo, $nome, $descricao) {
		global $connect;
		$updateStock = $connect->prepare("UPDATE stock SET code_item=:codigo, name_item=:nome, description_item=:descricao WHERE id_item=:id");
		$updateStock->bindValue("id", $id);
		$updateStock->bindValue("codigo", $codigo);
		$updateStock->bindValue("nome", $nome);
		$updateStock->bindValue("descricao", $descricao);
		$updateStock->execute();
	}
	
	function deleteStock($id) {
		global $connect;
		$deleteStock = $connect->prepare("DELETE FROM stock WHERE id_item=:id");
		$deleteStock->bindValue("id", $id);
		$deleteStock->execute();
	}
	
	function deleteReserveforStock($item) {
	    global $connect;
	    $deleteReserveforStock = $connect->prepare("DELETE FROM reserve WHERE item=:item");
	    $deleteReserveforStock->bindValue("item", $item);
	    $deleteReserveforStock->execute();
	}
	
	function verifyReserve($id) {
		global $connect;
		$res = new stdClass();
		$verifyReserve = $connect->prepare("SELECT * FROM reserve WHERE id_reserve=:id LIMIT 1");
		$verifyReserve->bindValue("id", $id);
		$verifyReserve->execute();
		if(!$verifyReserve->rowCount() <= 0) {
			$res->status = "ok";
		} else {
			$res->status = "error";
		}
		return $res;
	}
	
	function updateReserve($id, $status) {
		global $connect;
		$updateReserve = $connect->prepare("UPDATE reserve SET status=:status WHERE id_reserve=:id");
		$updateReserve->bindValue("id", $id);
		$updateReserve->bindValue("status", $status);
		$updateReserve->execute();
	}
	
	function dataEditReserve($id) {
		global $connect;
		$dataEditReserve = $connect->prepare("SELECT * FROM reserve WHERE id_reserve=:id LIMIT 1");
		$dataEditReserve->bindValue("id", $id);
		$dataEditReserve->execute();
		if(!$dataEditReserve->rowCount() <= 0) {
			return $dataEditReserve->fetchObject();
		} else {
			return false;
		}
	}

?>