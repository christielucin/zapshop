<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$json = file_get_contents('php://input'); 
		$arr = json_decode($json);
		//$this->grava('1- '.$json);	
		$output = print_r($arr, true);
		//$this->grava('2- '.$output);

		if(isset($arr->type) && $arr->type == 'MESSAGE'){
			$this->grava('1- '. $arr->type);
			$this->grava('2- '. $json);
			
			$data = [
				'from'=>'twisty-nose', 
				'to'=>'5553984556828',
				'contents' => [[
					'type' => 'text',
					'text' => "1. teste \n2. opção \n3. outra"
					]]
				];
	
				$this->getApi($data);
				//$this->grava($json);
		}
		

		if(isset($_POST)){
			//$this->grava($_POST);	

		}

		


	}
	//--------------------------------------------------------------------

	public function grava($dados){


		$filename = 'teste.txt';
		$conteudo = "\n------------------------------------------------\n";
		$conteudo .= $dados;
		
		// Primeiro vamos ter certeza de que o arquivo existe e pode ser alterado
		if (is_writable($filename)) {
		
		 // Em nosso exemplo, nós vamos abrir o arquivo $filename
		 // em modo de adição. O ponteiro do arquivo estará no final
		 // do arquivo, e é pra lá que $conteudo irá quando o 
		 // escrevermos com fwrite().
			if (!$handle = fopen($filename, 'a')) {
				 echo "Não foi possível abrir o arquivo ($filename)";
				 exit;
			}
		
			// Escreve $conteudo no nosso arquivo aberto.
			if (fwrite($handle, $conteudo) === FALSE) {
				echo "Não foi possível escrever no arquivo ($filename)";
				exit;
			}
		
			echo "Sucesso: Escrito ($conteudo) no arquivo ($filename)";
		
			fclose($handle);
		
		} else {
			echo "O arquivo $filename não pode ser alterado";
		}
	}

	public function getApi($data){
		//print_r($_POST);

		/* API URL */
		$url = 'https://api.zenvia.com/v1/channels/whatsapp/messages';
			
		/* Init cURL resource */
		$ch = curl_init($url);
			
		//print_r(json_encode($data));
		//exit;
			
		/* pass encoded JSON string to the POST fields */
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			
		/* set the content type json */
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type:application/json',
					'X-API-TOKEN:ZXY8U5yYtggVLsApotJUI6LGsfkJ0N5WbEha'
				));
			
		/* set return type json */
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
		/* execute request */
		$result = curl_exec($ch);
			
		/* close cURL resource */
		curl_close($ch);
		$this->grava('4- '.$result);		
	}

	//function get

}
