<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
	public $uses = array('User',"Question","Reply","Event");
	public $core_url = "https://teratail.com/api";

	public function view(){
		//print_r($this->request->pass);

		$data=$this->User->findByDisplayName($this->request->pass[0]);
		$this->set("profile",$data);

		$question = $this->Question->find("all",array('conditions'=>array("display_name"=>$this->request->pass[0])));

		// $this->Reply->bindModel(
  //                       array(
  //                           'hasMany' => array('Question'),
  //                           )
  //                       );

		$reply = $this->Reply->find("all",array('conditions'=>array("Reply.display_name"=>$this->request->pass[0])));
		

		$margedata=array_merge($question,$reply);

		$event=$this->Event->find("all");
		$this->set("Event",$event);
		$this->set("TimelineData",$margedata);
	}	

	#userが投稿したquestionを登録する
	#kai ogita
	public function add_question(){
		$this->autoRender=false;
		//passによりdisplay_nameを取得し、APIを叩く
		#https://teratail.com/api/users/TaMaMhyu/replise?offset=1&limit=5
		#https://teratail.com/api/users/TaMaMhyu/replies?offset=0&limit=10
		$que_lists = "https://teratail.com/api/users/".$this->request->pass[0]."/questions?offset=1&limit=10";

		$Datas=@file_get_contents($que_lists);
		$encoded_data=json_decode($Datas,true);
		

		
		
		$data["Question"]=array();
		foreach ($encoded_data["questions"] as $key => $value) {
			$data["Question"][$key]=array(
				"title" => $value["title"],
				"id"=>$value["id"],
				"display_name"=>$this->request->pass[0],
				"tag" => $value["tags"][0],
				"created" => $value["created"],
				"modified" => $value["modified"]);
		}

		echo "<pre>";
		print_r($data);
		echo "</pre>";

		if($this->Question->saveAll($data["Question"])){
			echo "complete";
		}else{
			echo "plz try again";
		}

	}

	public function add_reply(){
		$this->autoRender=false;
		//passによりdisplay_nameを取得し、APIを叩く
		#https://teratail.com/api/users/TaMaMhyu/replise?offset=1&limit=10
		#https://teratail.com/api/users/TaMaMhyu/replies?offset=0&limit=10
		#https://teratail.com/api/users/TaMaMhyu/replies?offset=0&limit=10
		$que_lists = "https://teratail.com/api/users/".$this->request->pass[0]."/replies?offset=0&limit=10";
		echo $que_lists;
		$Datas=@file_get_contents($que_lists);
		$encoded_data=json_decode($Datas,true);
		
				
		
		$data["Reply"]=array();
		foreach ($encoded_data["replies"] as $key => $value) {
			$que_lists = "https://teratail.com/api/questions/".$value["question_id"];
			echo $que_lists;
			$Datas=@file_get_contents($que_lists);
			$endata=json_decode($Datas,true);

			$data["Reply"][$key]=array(
				#"title" => $value["title"],
				"question_id"=>$value["question_id"],
				"display_name"=>$this->request->pass[0],
				"tag" => $endata["question"]["tags"][0],
				"created" => $value["created"],
				"modified" => $value["modified"],
				);
		}

		

		if($this->Reply->saveAll($data["Reply"])){
			echo "complete";
		}else{
			echo "plz try again";
		}

		$dataa["Question"] = array();
		foreach ($data["Reply"] as $key => $value) {
			# code...
			$que_lists = "https://teratail.com/api/questions/".$value["question_id"];
			echo $que_lists;
			$Datas=@file_get_contents($que_lists);
			$endata=json_decode($Datas,true);

			$dataa["Question"][$key]=array(
				"id"=>$endata["question"]["id"],
				"title"=>$endata["question"]["title"],
				"body"=>$endata["question"]["body"],
				"display_name"=>$endata["question"]["display_name"],
				"tag"=>$endata["question"]["tags"][0],
				"created" => $value["created"],
				"modified" => $value["modified"]
				);

			
			//$this->Question->save($data);

		}
		$this->Question->saveAll($dataa["Question"]);
		echo "<pre>";
		print_r($dataa);
		echo "</pre>";
	}

	#userをDBに登録する
	#kai ogita
	public function add_user(){
		$this->autoRender=false;
		//passによりdisplay_nameを取得し、APIを叩く
		$user_profile = $this->core_url."/users/".$this->request->pass[0];

		$UserDatas=@file_get_contents($user_profile);
		$encoded_Userdata=json_decode($UserDatas,true);

		#dbに入れるため整形
		$data["User"]=array();
		foreach ($encoded_Userdata["user"] as $key => $value) {
			$data["User"]+=array($key => $value);
		}

		if($this->User->save($data)){
			echo "complete";
		}else{
			echo "plz try again";
		}
	}

}