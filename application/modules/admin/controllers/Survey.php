<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends Admin_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
	}

	public function index()
		{
			$udata = $this->custom_model->my_where('survey','*',array('deleted_at'=>NULL),array(),"","","","","",array(),"",false);
			$this->mViewData['udata'] = $udata;
			$this->render('survey/list');
			
		}
	
	public function create()
		{
			$survey_data = $this->custom_model->my_where('survey','*','');
			$this->render('admin/survey/create');
		}




	public function store()
		{
			$genrated_id = "RIL_".time().rand(10000,99999);
			$post_data = $this->input->post();
			
			if(!empty(@$post_data['id']))
				{
					$update_data = array(
									'survey_name'=>@$post_data['survey_name'],
									'rewards'=>@$post_data['rewards'],
									'type'=>@$post_data['type'],
									'survey_time'=>@$post_data['survey_time']
							       );
					$update_id = $this->custom_model->my_update($update_data,array('survey_id',@$post_data['id']),'survey');
					if($update_id)
						{
							$return_data['status']="success";
							$return_data['survey_id']= @$post_data['id'];
							$return_data['msg']="Survey updated successfully";
							echo json_encode($return_data);
							die();
						}
					else
						{
							$return_data['status']="error";
							$return_data['survey_id']= @$post_data['id'];
							$return_data['msg']="Survey update failed";
							echo json_encode($return_data);		
							die();
						}	
				}
			else
				{
					$insert_data = array(
							'survey_name'=>@$post_data['survey_name'],
							'rewards'=>@$post_data['rewards'],
							'type'=>@$post_data['type'],
							'survey_time'=>@$post_data['survey_time'],
							'survey_id'=>$genrated_id
						   );
					$insert_id = $this->custom_model->my_insert($insert_data,'survey');
					if($insert_id)
						{
							$return_data['status']="success";
							$return_data['survey_id']=$genrated_id;
							$return_data['msg']="Survey created successfully";
							echo json_encode($return_data);
							die();
						}
					else
						{
							$return_data['status']="error";
							$return_data['survey_id']=$genrated_id;
							$return_data['msg']="Survey create failed";
							echo json_encode($return_data);		
							die();
						}	
				}		
			
		}	

	public function getQuestion($question_id)
		{
			$survey_questions= array();
			$qid = en_de_crypt($question_id,'d');
			$survey_questions =  $this->custom_model->my_where('survey_questions','*',array('id'=>$qid,'deleted_at'=>NULL));
			@$survey_questions[0]['en_id'] =en_de_crypt(@$survey_questions[0]['id'],'e');
			$return_data['status']="success";
			$return_data['survey']= @$survey_questions[0];
			$return_data['msg']="Survey created successfully";
			echo json_encode($return_data);
		}

	public function questions($row)
		{
			$html = '<tr>
			
						<td>'.(@$row['qc1']+1).'</td>
	      				<td>'.@$row['question'].'</td>
	      				<td>'.@$row['option_1'].'</td>
	      				<td>'.@$row['option_2'].'</td>
	      				<td>'.@$row['option_3'].'</td>
	      				<td>'.@$row['option_4'].'</td>
	      				<td>'.@$row['answer'].'</td>
	      				<td>'.@$row['description'].'</td>
	      				<td>'.@$row['time'].'</td>
	      				<td class="actions">
	         			<a style="width: 30px;" onclick="questionEdit('.en_de_crypt(@$row['survey_id'],'e').')" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"> <i class="glyphicon glyphicon-pencil"></i></a>
	         			<a style="width: 30px;" onclick="questionDelete('.en_de_crypt(@$row['survey_id'],'e').')" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"> <i class="glyphicon glyphicon-trash"></i></a>
	         			</td>
         			</tr>';

         	return $html;		
		}

	public function store_question()
		{
			$post_data = $this->input->post();
			$insert_data = array(
							'question'=>@$post_data['question'],
							'a'=>@$post_data['option_1'],
							'b'=>@$post_data['option_2'],
							'c'=>@$post_data['option_3'],
							'd'=>@$post_data['option_4'],
							'answer'=>@$post_data['answer'],
							'description'=>@$post_data['description'],
							'time'=>@$post_data['time'],
							'survey_id'=>@$post_data['survey_id']
								);
			$insert_id = $this->custom_model->my_insert($insert_data,'survey_questions');
			if($insert_id)
				{
					$survey_data = $this->custom_model->my_where('survey_questions','*',array('survey_id'=>@$post_data['survey_id'],'deleted_at'=>NULL));
					if(!empty($survey_data))
						{
							$count_records = count($survey_data);
							$updates = array('question_count'=>$count_records);
							$this->custom_model->my_update($updates,array('survey_id'=>@$post_data['survey_id']),'survey');	
						}
					$return_data['status']="success";
					$return_data['id']=$insert_id;
					$return_data['msg']="Survey question added successfully";
					$return_data['html']=$this->questions($post_data);
					echo json_encode($return_data);
					die();
				}
			else
				{
					$return_data['status']="error";
					$return_data['id']=$insert_id;
					$return_data['msg']="Survey question create failed";
					echo json_encode($return_data);		
					die();
				}	
		}


	public function store_question_edit()
		{
			$post_data = $this->input->post();
			$id = en_de_crypt(@$post_data['en_id'],'d');
			$insert_data = array(
							'question'=>@$post_data['question'],
							'a'=>@$post_data['option_1'],
							'b'=>@$post_data['option_2'],
							'c'=>@$post_data['option_3'],
							'd'=>@$post_data['option_4'],
							'answer'=>@$post_data['answer'],
							'time'=>@$post_data['time']
								);
			$insert_id = $this->custom_model->my_update($insert_data,array('id'=>$id),'survey_questions');
			if($insert_id)
				{
					$return_data['status']="success";
					$return_data['id']=$insert_id;
					$return_data['msg']="Survey question added successfully";
					echo json_encode($return_data);
					die();
				}
			else
				{
					$return_data['status']="error";
					$return_data['id']=$insert_id;
					$return_data['msg']="Survey question create failed";
					echo json_encode($return_data);		
					die();
				}	

		}	
	
	public function edit($survey_id)
		{
			$survey_id_d = en_de_crypt($survey_id,'d');
			$survey_data = $this->custom_model->my_where('survey','*',array('id'=>@$survey_id_d,'deleted_at'=>NULL));
			if(!empty($survey_data))
				{
					foreach ($survey_data as $key => $value) 
						{
							$survey_questions = $this->custom_model->my_where('survey_questions','*',array('survey_id'=>@$value['survey_id'],'deleted_at'=>NULL),'','id','desc');
							if(!empty($survey_questions))
								{
									foreach ($survey_questions as $skey => $svalue) 
										{
											$survey_data[$key]['survey'][$skey]=$svalue;
										}
								}
						}
				}
			$this->mViewData['survey_data'] = $survey_data;
			// echo "<pre>";
			// print_r($survey_data);die();
			$this->render('survey/detail');		
		}

	
	public function deleteSurvey($survey_id)
		{
			$survey_id_d = en_de_crypt($survey_id,'d');
			$updates = array('deleted_at'=>date('Y-m-d H:i:s'));
			$this->custom_model->my_update($updates,array('id'=>@$survey_id_d),'survey');
			$survey_data = $this->custom_model->my_where('survey','*',array('id'=>@$survey_id_d));		
			$this->custom_model->my_update($updates,array('survey_id'=>@$survey_data[0]['survey_id']),'survey_questions');
			redirect('admin/survey');
		}	

	public function deleteQuestion($question_id)
		{
			$question_id_d = en_de_crypt($question_id,'d');
			$updates = array('deleted_at'=>date('Y-m-d H:i:s'));
			$this->custom_model->my_update($updates,array('id'=>@$question_id_d),'survey_questions');		
			$return_data['status']="success";
			$return_data['msg']="Survey question deleted successfully";
			echo json_encode($return_data);
			die();
		}
}