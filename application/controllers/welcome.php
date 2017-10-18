<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$curl = curl_init('https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c'); 
curl_setopt($curl, CURLOPT_FAILONERROR, true); 
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   
$result = curl_exec($curl); 
$result=json_decode($result,true);
/*echo "<pre>";
print_r($result);die();*/

$TabData= array();
$Tabt= array();
$TabCards= array();

 $tmp1= array();


foreach ($result as $key=>$value) {	

	if ($key=="data") {
		$TabData[]=$value;


		foreach ($TabData as $key1 => $value1) {
			$Tabt=$value1;

					foreach ($Tabt as $keyCards => $valueCards) {
						if ($keyCards=="cards") {
						$TabCards=$valueCards;
					}
					elseif ($keyCards=="categoryOrder") {
						$TabCategoryOrder[]=$valueCards;
					}
					elseif ($keyCards=="valueOrder") {
						$TabValueOrder[]=$valueCards;
					}
					}
			
		}
		
	}	

}


for ($j=0; $j <4 ; $j++) { 
   
			foreach($TabCategoryOrder as $keyCategory=> $category) {

					    for ($k=0; $k < 13; $k++) { 
							    foreach($TabValueOrder as $keyvaleur=> $valeur) {  
							 
							  $tmp = array();
							  $i=0;
									  foreach($TabCards as $keyCards=> $cards) {
									    
									    	 
											    if(($category[$j] == $TabCards[$i]['category']) && ($valeur[$k] == $TabCards[$i]['value'])) {
											    	
											    	 $tmp1[$i]['category'] = $TabCards[$i]['category'];
											    	 $tmp1[$i]['value'] = $TabCards[$i]['value'];
											    }  
									    
									     $i++;
									  }
							}
					}
			}

}

$result = array_merge($tmp1);

$jsontab=json_encode(['cards',$result]);
$data = array('jsontab' => $jsontab);

		$this->load->view('welcome_message',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */