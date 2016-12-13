<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



use Omnipay\Omnipay;

class Invoice extends Admin_Controller {

/*

| -----------------------------------------------------

| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM

| -----------------------------------------------------

| AUTHOR:			INILABS TEAM

| -----------------------------------------------------

| EMAIL:			info@inilabs.net

| -----------------------------------------------------

| COPYRIGHT:		RESERVED BY INILABS IT

| -----------------------------------------------------

| WEBSITE:			http://inilabs.net

| -----------------------------------------------------

*/

	function __construct() {

		parent::__construct();

		$this->load->model("invoice_m");

		$this->load->model("feetype_m");

		$this->load->model('payment_m');

		$this->load->model("classes_m");

		$this->load->model("student_m");

		$this->load->model("parentes_m");

		$this->load->model("section_m");

		$this->load->model('user_m');

		$this->load->model("payment_settings_m");

		$language = $this->session->userdata('lang');

		$this->lang->load('invoice', $language);

		require_once(APPPATH."libraries/Omnipay/vendor/autoload.php");

	}



	public function index() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$month = htmlentities(mysql_real_escape_string($this->uri->segment(3)));
			if((int)$month){
				$this->data["month"] = $month;
				$this->data['invoices'] = $this->invoice_m->get_order_by_invoice(array('MONTH(date)'=>$month,'YEAR(date)'=>date("Y")));

				$this->data["subview"] = "invoice/index";

				$this->load->view('_layout_main', $this->data);
			}else{

				$this->data["subview"] = "invoice/search_invoice";

				$this->load->view('_layout_main', $this->data);
			}
		} elseif($usertype == "Student") {

			$username = $this->session->userdata("username");

			$student = $this->student_m->get_single_student(array("username" => $username));

			$this->data['invoices'] = $this->invoice_m->get_order_by_invoice(array('studentID' => $student->studentID));

			$this->data["subview"] = "invoice/index";

			$this->load->view('_layout_main', $this->data);

		} elseif($usertype == "Parent") {

			$username = $this->session->userdata("username");

			$parent = $this->parentes_m->get_single_parentes(array('username' => $username));

			$this->data['students'] = $this->student_m->get_order_by_student(array('parentID' => $parent->parentID));

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$checkstudent = $this->student_m->get_single_student(array('studentID' => $id));

				if(count($checkstudent)) {

					if($checkstudent->parentID == $parent->parentID) {

						$classesID = $checkstudent->classesID;

						$this->data['set'] = $id;

						$this->data['invoices'] = $this->invoice_m->get_order_by_invoice(array('studentID' => $id));

						$this->data["subview"] = "invoice/index_parent";

						$this->load->view('_layout_main', $this->data);

					} else {

						$this->data["subview"] = "error";

						$this->load->view('_layout_main', $this->data);

					}

				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "invoice/search_parent";

				$this->load->view('_layout_main', $this->data);

			}

		} else {

			$this->data["subview"] = "error";

			$this->load->view('_layout_main', $this->data);

		}

	}



	protected function rules() {

		$rules = array(

				array(

					'field' => 'classesID',

					'label' => $this->lang->line("invoice_classesID"),

					'rules' => 'trim|required|xss_clean|max_length[11]|numeric|callback_unique_classID'

				),

				array(

					'field' => 'studentID',

					'label' => $this->lang->line("invoice_studentID"),

					'rules' => 'trim|required|xss_clean|max_length[11]|numeric|callback_unique_studentID'

				),

				/*array(

					'field' => 'feetype',

					'label' => $this->lang->line("invoice_feetype"),

					'rules' => 'trim|required|xss_clean|max_length[128]'

				),*/

				/*array(

					'field' => 'amount',

					'label' => $this->lang->line("invoice_amount"),

					'rules' => 'trim|required|xss_clean|max_length[20]|numeric|callback_valid_number'

				),*/

				array(

					'field' => 'date',

					'label' => $this->lang->line("invoice_date"),

					'rules' => 'trim|required|xss_clean|max_length[10]|callback_date_valid'

				),

				array(

					'field' => 'item_no',

					'label' => "Item Number",

					'rules' => 'trim|required|xss_clean|numeric'

				),

				/*array(

					'field' => 'invoice_no',

					'label' => "Invoice No",

					'rules' => 'trim|required|xss_clean'

				),

				array(

					'field' => 'account_no',

					'label' => "Account No",

					'rules' => 'trim|required|xss_clean'

				),*/



			);

		return $rules;

	}



	protected function payment_rules() {

		$rules = array(

				array(

					'field' => 'amount',

					'label' => $this->lang->line("invoice_amount"),

					'rules' => 'trim|required|xss_clean|max_length[11]|numeric|callback_valid_number'

				),

				array(

					'field' => 'payment_method',

					'label' => $this->lang->line("invoice_paymentmethod"),

					'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_paymentmethod'

				)

			);

		return $rules;

	}

	public function invoice_list() {

		$month = $this->input->post('month');

		if((int)$month) {

			$string = base_url("invoice/index/$month");

			echo $string;

		} else {

			redirect(base_url("invoice/index"));

		}

	}

	public function add() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$this->data['classes'] = $this->classes_m->get_classes();

			$this->data['feetypes'] = $this->feetype_m->get_feetype();

			$classesID = $this->input->post("classesID");

			if($classesID != 0) {

				$this->data['students'] = $this->student_m->get_order_by_student(array("classesID" => $classesID));

			} else {

				$this->data['students'] = "empty";

			}

			$this->data['studentID'] = 0;

			if($_POST) {

				$this->data['studentID'] = $this->input->post('studentID');

				$rules = $this->rules();

				$this->form_validation->set_rules($rules);

				if ($this->form_validation->run() == FALSE) {

					$this->data["subview"] = "invoice/add";

					$this->load->view('invoice/add', $this->data);

				} else {

					if($this->input->post('studentID')) {

						$classesID = $this->input->post('classesID');

						$getclasses = $this->classes_m->get_classes($classesID);

						$studentID = $this->input->post('studentID');

						$item_no = $this->input->post('item_no');

						$getstudent = $this->student_m->get_student($studentID);

						$amount = 0;
						$t_code = "";
						$i_data = array();
						$set_feetype_arr = array();
						if($this->input->post("feetype")){
							$feetype_arr = $this->input->post("feetype");
							$amount_arr = $this->input->post("amount");
							$quantity_arr = $this->input->post("quantity");
							$tax_code_arr = $this->input->post("tax_code");
							$fp_arr = array();
							$t_code = $tax_code_arr[0];
							if (count($amount_arr)>0) {
								foreach ($amount_arr as $key => $value) {
									if($quantity_arr[$key]!=""){
										$value = ($value*$quantity_arr[$key]);
									}
									$amount+=$value;

									if($feetype_arr[$key]!=""){
										$ft_ar = explode("::", $feetype_arr[$key]);
										$fpd_ar = explode('_', $ft_ar[0]);
										$fpid = $fpd_ar[0];
										$fptype = $fpd_ar[1];
										if ($fptype==0) {
											$pack_data = $this->feetype_m->get_feetype($fpid);
											$fp_arr[$key] = $pack_data->note;
										}else{
											$pack_data = $this->student_m->get_package($fpid);
											$fp_arr[$key] = $pack_data->description;
										}
										$set_feetype_arr[$key] = $ft_ar[1];
									}else{
										$fp_arr[$key] ="";
										$set_feetype_arr[$key] = "";
									}
								}
							}
							$i_data = array("feetype_arr"=>$feetype_arr,"amount_arr"=>$amount_arr,"quantity_arr"=>$quantity_arr,"tax_code_arr"=>$tax_code_arr,"fp_arr"=>$fp_arr);
						}
						$invoce_data =serialize($i_data);
						$array = array(

							'classesID' => $classesID,

							'classes' => $getclasses->classes,

							'studentID' => $studentID,

							'student' => $getstudent->name,

							'roll' => $getstudent->roll,

							'feetype' => serialize($set_feetype_arr),

							'amount' => $amount,

							'status' => 0,

							'date' => date("Y-m-d", strtotime($this->input->post("date"))),

							'year' => date('Y'),

							'invoce_type' =>0,

							//'tax_code' => $t_code,
							
							//'invoice_no' => $this->input->post("invoice_no"),

							'invoce_data' => $invoce_data,

							'item_no' => $item_no

							//'account_no' => $this->input->post("account_no")

						);

						$oldamount = $getstudent->totalamount;

						$nowamount = $oldamount+$amount;

						$this->student_m->update_student(array('totalamount' => $nowamount), $getstudent->studentID);

						$returnID = $this->invoice_m->insert_invoice($array);

						$this->session->set_flashdata('success', $this->lang->line('menu_success'));

					 	// redirect(base_url("invoice/view/$returnID"));
					 	echo "ok";

					} else {

						$classesID = $this->input->post('classesID');

						$item_no = $this->input->post('item_no');

						$getclasses = $this->classes_m->get_classes($classesID);

						$getstudents = $this->student_m->get_order_by_student(array("classesID" => $classesID));

						$amount = 0;
						$t_code = "";
						$i_data = array();
						$set_feetype_arr = array();
						if($this->input->post("feetype")){
							$feetype_arr = $this->input->post("feetype");
							$amount_arr = $this->input->post("amount");
							$quantity_arr = $this->input->post("quantity");
							$tax_code_arr = $this->input->post("tax_code");
							$fp_arr = array();
							$t_code = $tax_code_arr[0];
							if (count($amount_arr)>0) {
								foreach ($amount_arr as $key => $value) {
									if($quantity_arr[$key]!=""){
										$value = ($value*$quantity_arr[$key]);
									}
									$amount+=$value;

									if($feetype_arr[$key]!=""){
										$ft_ar = explode("::", $feetype_arr[$key]);
										$fpd_ar = explode('_', $ft_ar[0]);
										$fpid = $fpd_ar[0];
										$fptype = $fpd_ar[1];
										if ($fptype==0) {
											$pack_data = $this->feetype_m->get_feetype($fpid);
											$fp_arr[$key] = $pack_data->note;
										}else{
											$pack_data = $this->student_m->get_package($fpid);
											$fp_arr[$key] = $pack_data->description;
										}
										$set_feetype_arr[$key] = $ft_ar[1];
									}else{
										$fp_arr[$key] ="";
										$set_feetype_arr[$key] = "";
									}
								}
							}
							$i_data = array("feetype_arr"=>$feetype_arr,"amount_arr"=>$amount_arr,"quantity_arr"=>$quantity_arr,"tax_code_arr"=>$tax_code_arr,"fp_arr"=>$fp_arr);
						}
						$invoce_data =serialize($i_data);

						foreach ($getstudents as $key => $getstudent) {

							$array = array(

								'classesID' => $classesID,

								'classes' => $getclasses->classes,

								'studentID' => $getstudent->studentID,

								'student' => $getstudent->name,

								'roll' => $getstudent->roll,

								'feetype' => serialize($set_feetype_arr),

								'amount' => $amount,

								'status' => 0,

								'date' => date("Y-m-d", strtotime($this->input->post("date"))),

								'year' => date('Y'),

								'invoce_type' =>0,

								//'tax_code' => $t_code,
								
								//'invoice_no' => $this->input->post("invoice_no"),

								'invoce_data' => $invoce_data,

								'item_no' => $item_no,

								//'account_no' => $this->input->post("account_no"),

								"subcategory" => 2

							);

							$oldamount = $getstudent->totalamount;

							$nowamount = $oldamount+$amount;

							$this->student_m->update_student(array('totalamount' => $nowamount), $getstudent->studentID);

							$this->invoice_m->insert_invoice($array);

						}

						$this->session->set_flashdata('success', $this->lang->line('menu_success'));

					 	// redirect(base_url("invoice/index"));
					 	echo "ok";

					}

				}

			} else {

				$this->data["subview"] = "invoice/add";

				$this->load->view('invoice/add', $this->data);

			}

		} else {

			$this->data["subview"] = "error";

			$this->load->view('error', $this->data);

		}

	}



	public function edit() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data['invoice'] = $this->invoice_m->get_invoice($id);

				$this->data['classes'] = $this->classes_m->get_classes();

				$this->data['feetypes'] = $this->feetype_m->get_feetype();

				$this->data['packages'] = $this->student_m->get_package($this->data['invoice']->classesID);

				$invoce_data = $this->data['invoice']->invoce_data;
				$this->data["item_no"] = $this->data['invoice']->item_no;
				if($invoce_data!=""){
					$this->data["invoce_data"] = unserialize($invoce_data);
				}
				
				if($this->data['invoice']) {



					if($this->data['invoice']->classesID != 0) {

						$this->data['students'] = $this->student_m->get_order_by_student(array("classesID" => $this->data['invoice']->classesID));

					} else {

						$this->data['students'] = "empty";

					}

					$this->data['studentID'] = $this->data['invoice']->studentID;



					if($_POST) {

						$this->data['studentID'] = $this->input->post('studentID');

						$rules = $this->rules();

						$this->form_validation->set_rules($rules);

						if ($this->form_validation->run() == FALSE) {

							$this->data["subview"] = "invoice/edit";

							$this->load->view('invoice/edit', $this->data);

						} else {

							$status = 0;

							$oldstudent = $this->student_m->get_student($this->data['invoice']->studentID);

							$osoldamount = $oldstudent->totalamount;

							$oldnowamount = ($osoldamount)-($this->data['invoice']->amount);

							$this->student_m->update_student(array('totalamount' => $oldnowamount), $oldstudent->studentID);



							$classesID = $this->input->post('classesID');

							$getclasses = $this->classes_m->get_classes($classesID);

							$studentID = $this->input->post('studentID');

							$item_no = $this->input->post('item_no');

							$getstudent = $this->student_m->get_student($studentID);

							$amount = 0;
							$t_code = "";
							$i_data = array();
							$set_feetype_arr = array();
							if($this->input->post("feetype")){
								$feetype_arr = $this->input->post("feetype");
								$amount_arr = $this->input->post("amount");
								$quantity_arr = $this->input->post("quantity");
								$tax_code_arr = $this->input->post("tax_code");
								$fp_arr = array();
								$t_code = $tax_code_arr[0];
								if (count($amount_arr)>0) {
									foreach ($amount_arr as $key => $value) {
										if($quantity_arr[$key]!=""){
											$value = ($value*$quantity_arr[$key]);
										}
										$amount+=$value;

										if($feetype_arr[$key]!=""){
											$ft_ar = explode("::", $feetype_arr[$key]);
											$fpd_ar = explode('_', $ft_ar[0]);
											$fpid = $fpd_ar[0];
											$fptype = $fpd_ar[1];
											if ($fptype==0) {
												$pack_data = $this->feetype_m->get_feetype($fpid);
												$fp_arr[$key] = $pack_data->note;
											}else{
												$pack_data = $this->student_m->get_package($fpid);
												if (count($pack_data)) {
													$fp_arr[$key] = $pack_data->description;
												}
											}
											$set_feetype_arr[$key] = $ft_ar[1];
										}else{
											$fp_arr[$key] ="";
											$set_feetype_arr[$key] = "";
										}
									}
								}
								$i_data = array("feetype_arr"=>$feetype_arr,"amount_arr"=>$amount_arr,"quantity_arr"=>$quantity_arr,"tax_code_arr"=>$tax_code_arr,"fp_arr"=>$fp_arr);
							}
							$invoce_data =serialize($i_data);



							if(empty($this->data['invoice']->paidamount)) {

								$status = 0;

							} elseif($this->data['invoice']->paidamount == $amount) {

								$status = 2;

							} else {

								$status = 1;

							}



							$array = array(

								'classesID' => $classesID,

								'classes' => $getclasses->classes,

								'studentID' => $studentID,

								'student' => $getstudent->name,

								'roll' => $getstudent->roll,

								'feetype' => serialize($set_feetype_arr),

								'amount' => $amount,

								'status' => $status,

								'invoce_type' =>0,

								'tax_code' => $t_code,
								
								'invoice_no' => $this->input->post("invoice_no"),

								'invoce_data' => $invoce_data,

								'item_no' => $item_no,

								'account_no' => $this->input->post("account_no")

							);

							$oldamount = $getstudent->totalamount;

							$nowamount = $oldamount+$amount;



							$this->student_m->update_student(array('totalamount' => $nowamount), $getstudent->studentID);

							$this->invoice_m->update_invoice($array, $id);

							$this->session->set_flashdata('success', $this->lang->line('menu_success'));

						 	// redirect(base_url("invoice/index"));
							
							echo "ok";

						}

					} else {

						$this->data["subview"] = "invoice/edit";

						$this->load->view('invoice/edit', $this->data);

					}

				} else {

					$this->data["subview"] = "error";

					$this->load->view('error', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('error', $this->data);

			}

		} else {

			$this->data["subview"] = "error";

			$this->load->view('error', $this->data);

		}

	}


	public function cloneInvoice(){
		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {
			$invoiceID = $this->input->post("id");
			$invoice_date = $this->input->post("date");
			$invoice = $this->invoice_m->get_single_invoice(array("invoiceID"=>$invoiceID));
			$array = array();
			foreach ($invoice as $key => $value) {
				if($key != "invoiceID"){
					if($key == "date"){
						$array[$key] = date("Y-m-d", strtotime($invoice_date));
					}else{
						$array[$key] = $value;
					}
				}
			}
			$this->invoice_m->insert_invoice($array);

			$this->session->set_flashdata('success', $this->lang->line('menu_success'));
		}
		echo "ok";
	}


	public function delete() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));
			$month = htmlentities(mysql_real_escape_string($this->uri->segment(4)));

			if((int)$id) {

				$this->data['invoice'] = $this->invoice_m->get_invoice($id);

				if($this->data['invoice']) {

					$oldstudent = $this->student_m->get_student($this->data['invoice']->studentID);

					$osoldamount = $oldstudent->totalamount;

					$oldnowamount = ($osoldamount)-($this->data['invoice']->amount);

					$this->student_m->update_student(array('totalamount' => $oldnowamount), $oldstudent->studentID);

					$this->invoice_m->delete_invoice($id);

					$this->session->set_flashdata('success', $this->lang->line('menu_success'));

					redirect(base_url('invoice/index/'.$month));

				} else {

					redirect(base_url('invoice/index/'.$month));

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		} else {

			$this->data["subview"] = "error";

			$this->load->view('_layout_main', $this->data);

		}

	}



	public function view() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);

				if($this->data["invoice"]) {

					$this->data["student"] = $this->student_m->get_student($this->data["invoice"]->studentID);
					if(count($this->data["student"])){
						$this->data['parentes'] = $this->parentes_m->get_parentes($this->data["student"]->parentID);
					}

					$this->data["subview"] = "invoice/view";

					$this->load->view('invoice/view', $this->data);

				} else {

					$this->data["subview"] = "error";

					$this->load->view('error', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('error', $this->data);

			}

		} elseif($usertype == "Student") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$username = $this->session->userdata("username");

				$getstudent = $this->student_m->get_single_student(array("username" => $username));

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);

				if($this->data['invoice'] && ($this->data['invoice']->studentID == $getstudent->studentID)) {

					$this->data["student"] = $this->student_m->get_student($this->data["invoice"]->studentID);

					$this->data["subview"] = "invoice/view";

					$this->load->view('_layout_main', $this->data);

				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		} elseif($usertype == "Parent") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$username = $this->session->userdata("username");

				$parent = $this->student_m->get_parent_info($username);

				$this->data["invoice"] = $this->invoice_m->get_single_invoice(array('invoiceID' => $id));

				if($this->data['invoice']) {

					$getstudent = $this->student_m->get_single_student(array("studentID" => $this->data['invoice']->studentID));

					if($this->data['invoice'] && ($parent->parentID == $getstudent->parentID)) {

						$this->data["student"] = $this->student_m->get_student($this->data["invoice"]->studentID);

						$this->data["subview"] = "invoice/view";

						$this->load->view('_layout_main', $this->data);

					} else {

						$this->data["subview"] = "error";

						$this->load->view('_layout_main', $this->data);

					}

				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		} else {

			$this->data["subview"] = "error";

			$this->load->view('_layout_main', $this->data);

		}

	}

	public function add_payment() {
		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin") {
			$invoiceID = $this->input->post("invoiceID");
			if($invoiceID != 0) {

				$this->data['invoiceID'] = $invoiceID;

				$this->data["invoice"] = $this->invoice_m->get_invoice($invoiceID);

				$this->data['amount'] = $this->data["invoice"]->amount;
				$this->data['paidamount'] = (!empty($this->data["invoice"]->paidamount))?$this->data["invoice"]->paidamount:0;

				$this->data["subview"] = "invoice/add_payment";

				$this->load->view('invoice/add_payment', $this->data);
			} else {

				$this->data["subview"] = "error";

				$this->load->view('error', $this->data);

			}
		} else {

			$this->data["subview"] = "error";

			$this->load->view('error', $this->data);

		}

	}

	public function add_payment_info() {
		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin") {
			$invoiceID = $this->input->post("invoiceID");
			$amount = $this->input->post("amount");
			$paymenttype = $this->input->post("paymenttype");
			if($invoiceID != 0) {
				$this->data['invoiceID'] = $invoiceID;
				$this->data['invoice'] = $this->invoice_m->get_invoice($invoiceID);
				$paidamount = (!empty($this->data['invoice']->paidamount))?$this->data['invoice']->paidamount:0;
				$amt = doubleval(($this->data['invoice']->amount+($this->data['invoice']->amount*6)/100)-($paidamount));
				$amount = doubleval($amount);
				if($amount <= $amt){
					if($amount < $amt){
						$array = array('paidamount'=>($amount+$paidamount),"status"=>1,"paymenttype"=>$paymenttype,"paiddate"=>date("Y-m-d"));
					}else{
						$array = array('paidamount'=>($amount+$paidamount),"status"=>2,"paymenttype"=>$paymenttype,"paiddate"=>date("Y-m-d"));
					}

					if(isset($_FILES["image"]['name']) && $_FILES["image"]['name'] !="") {

						if($this->data['invoice']->image != '') {

							unlink(FCPATH.'uploads/images/'.$this->data['invoice']->image);

						}

						$file_name = $_FILES["image"]['name'];

						$file_name_rename = $this->insert_with_image($this->data['invoice']->feetype);

			            $explode = explode('.', $file_name);

			            if(count($explode) >= 2) {

				            $new_file = $file_name_rename.'.'.$explode[1];

							$config['upload_path'] = "./uploads/images";

							$config['allowed_types'] = "gif|jpg|png";

							$config['file_name'] = $new_file;

							$config['max_size'] = '1024';

							$config['max_width'] = '3000';

							$config['max_height'] = '3000';



							$array['image'] = $new_file;

							$this->load->library('upload', $config);

							if(!$this->upload->do_upload("image")) {

								echo $this->upload->display_errors();

							} else {

								$data = array("upload_data" => $this->upload->data());

								$this->invoice_m->update_invoice($array, $invoiceID);

								$this->session->set_flashdata('success', $this->lang->line('menu_success'));

								// redirect(base_url("routine/index/$url"));
								echo "ok";

							}

						} else {

							echo "Invalid file";
						}

					}else{

						$this->invoice_m->update_invoice($array, $invoiceID);

						$this->session->set_flashdata('success', $this->lang->line('menu_success'));

						// redirect(base_url("routine/index/$url"));
						echo "ok";
					}
				}else{
					echo "amount is more";
				}

			}
		} 

	}

	public function call_items(){

		$classesID = $this->input->post('classesID');
		$item_no = $this->input->post('item_no');

		if((int)$classesID) {
			$this->data['classesID'] = $classesID;
			$this->data['item_no'] = $item_no;
			$this->data['feetypes'] = $this->feetype_m->get_feetype();
			$this->data['packages'] = $this->student_m->get_package($classesID);
			echo $html = $this->load->view('invoice/fill_items', $this->data, true);
		}
	}

	function insert_with_image($username) {

	    $random = rand(1, 10000000000000000);

	    $makeRandom = hash('sha512', $random. $username . config_item("encryption_key"));

	    return $makeRandom;

	}

	public function print_preview() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);

				if($this->data["invoice"]) {

					$this->data["student"] = $this->student_m->get_student($this->data["invoice"]->studentID);

					$this->data['parentes'] = $this->parentes_m->get_parentes($this->data["student"]->parentID);

					$this->load->library('html2pdf');

				    $this->html2pdf->folder('./assets/pdfs/');

				    $this->html2pdf->filename('Report.pdf');

				    $this->html2pdf->paper('a4', 'portrait');

				    $this->data['panel_title'] = $this->lang->line('panel_title');



				    $html = $this->load->view('invoice/pdf_preview', $this->data, true);

					$this->html2pdf->html($html);

					$this->html2pdf->create();



				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		}

	}

	public function viewReceipt() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);

				if($this->data["invoice"]) {

					$this->data["student"] = $this->student_m->get_student($this->data["invoice"]->studentID);
					if(count($this->data["student"])){
						$this->data['parentes'] = $this->parentes_m->get_parentes($this->data["student"]->parentID);
					}


				    $this->data['panel_title'] = $this->lang->line('panel_title');

				    $this->load->view('invoice/view_preview', $this->data);


				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		}

	}
	public function pdf_viewReceipt() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);

				if($this->data["invoice"]) {

					$this->data["student"] = $this->student_m->get_student($this->data["invoice"]->studentID);

					$this->data['parentes'] = $this->parentes_m->get_parentes($this->data["student"]->parentID);

					$this->load->library('html2pdf');

				    $this->html2pdf->folder('./assets/pdfs/');

				    $this->html2pdf->filename('Report.pdf');

				    $this->html2pdf->paper('a4', 'portrait');

				    $this->data['panel_title'] = $this->lang->line('panel_title');



				    $html = $this->load->view('invoice/print_preview', $this->data, true);

					$this->html2pdf->html($html);

					$this->html2pdf->create();



				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		}

	}



	public function send_mail() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = $this->input->post('id');

			if ((int)$id) {

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);

				if($this->data["invoice"]) {

					$this->data["student"] = $this->student_m->get_student($this->data["invoice"]->studentID);



					$this->load->library('html2pdf');

				    $this->html2pdf->folder('./assets/pdfs/');

				    $this->html2pdf->filename('Report.pdf');

				    $this->html2pdf->paper('a4', 'portrait');

				    $this->data['panel_title'] = $this->lang->line('panel_title');

				    $html = $this->load->view('invoice/pdf_preview', $this->data, true);

					$this->html2pdf->html($html);

					$this->html2pdf->create('save');



					if($path = $this->html2pdf->create('save')) {

					$this->load->library('email');

					$this->email->set_mailtype("html");

					$this->email->from($this->data["siteinfos"]->email, $this->data['siteinfos']->sname);

					$this->email->to($this->input->post('to'));

					$this->email->subject($this->input->post('subject'));

					$this->email->message($this->input->post('message'));

					$this->email->attach($path);

						if($this->email->send()) {

							$this->session->set_flashdata('success', $this->lang->line('mail_success'));

						} else {

							$this->session->set_flashdata('error', $this->lang->line('mail_error'));

						}

					}



				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		} else {

			$this->data["subview"] = "error";

			$this->load->view('_layout_main', $this->data);

		}

	}



	public function payment() {

		$usertype = $this->session->userdata("usertype");

		if($usertype == "Admin" || $usertype == "Accountant") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data['invoice'] = $this->invoice_m->get_invoice($id);

				if($this->data['invoice']) {

					if(($this->data['invoice']->paidamount != $this->data['invoice']->amount) && ($this->data['invoice']->status == 0 || $this->data['invoice']->status == 1)) {

						if($_POST) {

							$rules = $this->payment_rules();

							$this->form_validation->set_rules($rules);

							if ($this->form_validation->run() == FALSE) {

								$this->data["subview"] = "invoice/payment";

								$this->load->view('_layout_main', $this->data);

							} else {



								$payable_amount = $this->input->post('amount')+$this->data['invoice']->paidamount;

								if ($payable_amount > $this->data['invoice']->amount) {

									$this->session->set_flashdata('error', 'Payment amount is much than invoice amount');

									redirect(base_url("invoice/payment/$id"));

								} else {

									$this->post_data = $this->input->post();

									if ($this->input->post('payment_method') == 'Paypal') {

										$get_configs = $this->payment_settings_m->get_order_by_config();

										$this->post_data['id'] = $this->uri->segment(3);

										$this->invoice_data = $this->invoice_m->get_invoice($this->post_data['id']);

										$this->Paypal();

									} elseif($this->input->post('payment_method') == 'Cash') {

										$status = 0;

										if($payable_amount == $this->data['invoice']->amount) {

											$status = 2;

										} else {

											$status = 1;

										}



										$username = $this->session->userdata('username');

										$dbuserID = 0;

										$dbusertype = '';

										$dbuname = '';

										if($usertype == "Admin") {

											$user = $this->user_m->get_username_row("systemadmin", array("username" => $username));

											$dbuserID = $user->systemadminID;

											$dbusertype = $user->usertype;

											$dbuname = $user->name;

										} elseif($usertype == "Accountant") {

											$user = $this->user_m->get_username_row("user", array("username" => $username));

											$dbuserID = $user->userID;

											$dbusertype = $user->usertype;

											$dbuname = $user->name;

										}



										$nowpaymenttype = '';

										if(empty($this->data['invoice']->paymenttype)) {

											$nowpaymenttype = 'Cash';

										} else {

											if($this->data['invoice']->paymenttype == 'Cash') {

												$nowpaymenttype = 'Cash';

											} else {

												$exp = explode(',', $this->data['invoice']->paymenttype);

												if(!in_array('Cash', $exp)) {

													$nowpaymenttype =  $this->data['invoice']->paymenttype.','.'Cash';

												} else {

													$nowpaymenttype =  $this->data['invoice']->paymenttype;

												}

											}

										}



										$array = array(

											"paidamount" => $payable_amount,

											"status" => $status,

											"paymenttype" => $nowpaymenttype,

											"paiddate" => date('Y-m-d'),

											"userID" => $dbuserID,

											"usertype" => $dbusertype,

											'uname' => $dbuname

										);



										$payment_array = array(

											"invoiceID" => $id,

											"studentID"	=> $this->data['invoice']->studentID,

											"paymentamount" => $this->input->post('amount'),

											"paymenttype" => $this->input->post('payment_method'),

											"paymentdate" => date('Y-m-d'),

											"paymentmonth" => date('M'),

											"paymentyear" => date('Y')

										);



										$this->payment_m->insert_payment($payment_array);



										$studentID = $this->data['invoice']->studentID;

										$getstudent = $this->student_m->get_student($studentID);

										$nowamount = ($getstudent->paidamount)+($this->input->post('amount'));

										$this->student_m->update_student(array('paidamount' => $nowamount), $studentID);



										$this->invoice_m->update_invoice($array, $id);

										$this->session->set_flashdata('success', $this->lang->line('menu_success'));

										redirect(base_url("invoice/view/$id"));

									} elseif($this->input->post('payment_method') == 'Cheque') {

										$status = 0;

										if($payable_amount == $this->data['invoice']->amount) {

											$status = 2;

										} else {

											$status = 1;

										}



										$username = $this->session->userdata('username');

										$dbuserID = 0;

										$dbusertype = '';

										$dbuname = '';

										if($usertype == "Admin") {

											$user = $this->user_m->get_username_row("systemadmin", array("username" => $username));

											$dbuserID = $user->systemadminID;

											$dbusertype = $user->usertype;

											$dbuname = $user->name;

										} elseif($usertype == "Accountant") {

											$user = $this->user_m->get_username_row("user", array("username" => $username));

											$dbuserID = $user->userID;

											$dbusertype = $user->usertype;

											$dbuname = $user->name;

										}



										$nowpaymenttype = '';

										if(empty($this->data['invoice']->paymenttype)) {

											$nowpaymenttype = 'Cheque';

										} else {

											if($this->data['invoice']->paymenttype == 'Cheque') {

												$nowpaymenttype = 'Cheque';

											} else {

												$exp = explode(',', $this->data['invoice']->paymenttype);

												if(!in_array('Cheque', $exp)) {

													$nowpaymenttype =  $this->data['invoice']->paymenttype.','.'Cheque';

												} else {

													$nowpaymenttype =  $this->data['invoice']->paymenttype;

												}

											}

										}



										$array = array(

											"paidamount" => $payable_amount,

											"status" => $status,

											"paymenttype" => $nowpaymenttype,

											"paiddate" => date('Y-m-d'),

											"userID" => $dbuserID,

											"usertype" => $dbusertype,

											'uname' => $dbuname

										);



										$payment_array = array(

											"invoiceID" => $id,

											"studentID"	=> $this->data['invoice']->studentID,

											"paymentamount" => $this->input->post('amount'),

											"paymenttype" => $this->input->post('payment_method'),

											"paymentdate" => date('Y-m-d'),

											"paymentmonth" => date('M'),

											"paymentyear" => date('Y')

										);



										$this->payment_m->insert_payment($payment_array);



										$studentID = $this->data['invoice']->studentID;

										$getstudent = $this->student_m->get_student($studentID);

										$nowamount = ($getstudent->paidamount)+($this->input->post('amount'));

										$this->student_m->update_student(array('paidamount' => $nowamount), $studentID);



										$this->invoice_m->update_invoice($array, $id);

										$this->session->set_flashdata('success', $this->lang->line('menu_success'));

										redirect(base_url("invoice/view/$id"));

									} else {

										$this->data["subview"] = "invoice/payment";

										$this->load->view('_layout_main', $this->data);

									}

								}

							}

						} else {

							$this->data["subview"] = "invoice/payment";

							$this->load->view('_layout_main', $this->data);

						}

					} else {

						$this->data["subview"] = "error";

						$this->load->view('_layout_main', $this->data);

					}

				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		} elseif($usertype == "Student") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data['invoice'] = $this->invoice_m->get_invoice($id);

				$username = $this->session->userdata("username");

				$getstudent = $this->student_m->get_single_student(array("username" => $username));

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);



				if($this->data['invoice'] && ($this->data['invoice']->studentID == $getstudent->studentID)) {

					if(($this->data['invoice']->paidamount != $this->data['invoice']->amount) && ($this->data['invoice']->status == 0 || $this->data['invoice']->status == 1)) {

						if($_POST) {

							$rules = $this->payment_rules();

							unset($rules[1]);

							$this->form_validation->set_rules($rules);

							if ($this->form_validation->run() == FALSE) {

								$this->data["subview"] = "invoice/payment";

								$this->load->view('_layout_main', $this->data);

							} else {

								$payable_amount = $this->input->post('amount')+$this->data['invoice']->paidamount;

								if ($payable_amount > $this->data['invoice']->amount) {

									$this->session->set_flashdata('error', 'Payment amount is much than invoice amount');

									redirect(base_url("invoice/payment/$id"));

								} else {

									$this->post_data = $this->input->post();

									$this->post_data['id'] = $id;

									$this->invoice_data = $this->invoice_m->get_invoice($id);

									$this->Paypal();

								}

							}

						} else {

							$this->data["subview"] = "invoice/payment";

							$this->load->view('_layout_main', $this->data);

						}

					} else {

						$this->data["subview"] = "error";

						$this->load->view('_layout_main', $this->data);

					}

				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		} elseif($usertype == "Parent") {

			$id = htmlentities(mysql_real_escape_string($this->uri->segment(3)));

			if((int)$id) {

				$this->data['invoice'] = $this->invoice_m->get_invoice($id);

				$username = $this->session->userdata("username");

				$this->data["invoice"] = $this->invoice_m->get_invoice($id);



				if($this->data["invoice"]) {

					$getstudent = $this->student_m->get_single_student(array("studentID" => $this->data['invoice']->studentID));

					if($this->data['invoice'] && ($this->data['invoice']->studentID == $getstudent->studentID)) {

						if(($this->data['invoice']->paidamount != $this->data['invoice']->amount) && ($this->data['invoice']->status == 0 || $this->data['invoice']->status == 1)) {

							if($_POST) {

								$rules = $this->payment_rules();

								unset($rules[1]);

								$this->form_validation->set_rules($rules);

								if ($this->form_validation->run() == FALSE) {

									$this->data["subview"] = "invoice/payment";

									$this->load->view('_layout_main', $this->data);

								} else {

									$payable_amount = $this->input->post('amount')+$this->data['invoice']->paidamount;

									if ($payable_amount > $this->data['invoice']->amount) {

										$this->session->set_flashdata('error', 'Payment amount is much than invoice amount');

										redirect(base_url("invoice/payment/$id"));

									} else {

										$this->post_data = $this->input->post();

										$this->post_data['id'] = $id;

										$this->invoice_data = $this->invoice_m->get_invoice($id);

										$this->Paypal();

									}

								}

							} else {

								$this->data["subview"] = "invoice/payment";

								$this->load->view('_layout_main', $this->data);

							}

						} else {

							$this->data["subview"] = "error";

							$this->load->view('_layout_main', $this->data);

						}

					} else {

						$this->data["subview"] = "error";

						$this->load->view('_layout_main', $this->data);

					}



				} else {

					$this->data["subview"] = "error";

					$this->load->view('_layout_main', $this->data);

				}

			} else {

				$this->data["subview"] = "error";

				$this->load->view('_layout_main', $this->data);

			}

		} else {

			$this->data["subview"] = "error";

			$this->load->view('_layout_main', $this->data);

		}

	}



	/* Paypal payment start*/

	public function Paypal() {

		$api_config = array();

		$get_configs = $this->payment_settings_m->get_order_by_config();

		foreach ($get_configs as $key => $get_key) {

			$api_config[$get_key->config_key] = $get_key->value;

		}

		$this->data['set_key'] = $api_config;

		if($api_config['paypal_api_username'] =="" || $api_config['paypal_api_password'] =="" || $api_config['paypal_api_signature']==""){

			$this->session->set_flashdata('error', 'Paypal settings not available');

			redirect($_SERVER['HTTP_REFERER']);

		} else {

			$this->item_data = $this->post_data;

			$this->invoice_info = (array) $this->invoice_data;



			$params = array(

	  		'cancelUrl' 	=> base_url('invoice/getSuccessPayment'),

	  		'returnUrl' 	=> base_url('invoice/getSuccessPayment'),

	  		'invoice_id'	=> $this->item_data['id'],

	    	'name'		=> $this->invoice_info['student'],

	    	'description' 	=> $this->invoice_info['feetype'],

	    	'amount' 	=> number_format(floatval($this->item_data['amount']),2),

	    	'currency' 	=> $this->data["siteinfos"]->currency_code,

			);

			$this->session->set_userdata("params", $params);

			$gateway = Omnipay::create('PayPal_Express');

			$gateway->setUsername($api_config['paypal_api_username']);

			$gateway->setPassword($api_config['paypal_api_password']);

			$gateway->setSignature($api_config['paypal_api_signature']);



			$gateway->setTestMode($api_config['paypal_demo']);



			$response = $gateway->purchase($params)->send();



			if ($response->isSuccessful()) {

				// payment was successful: update database

			} elseif ($response->isRedirect()) {

				$response->redirect();

			} else {

			  // payment failed: display message to customer

			  echo $response->getMessage();

			}

		}

		/*omnipay Paypal end*/

	}



	public function getSuccessPayment() {

  		$userID = $this->userID();

  		$api_config = array();

		$get_configs = $this->payment_settings_m->get_order_by_config();

		foreach ($get_configs as $key => $get_key) {

			$api_config[$get_key->config_key] = $get_key->value;

		}

		$this->data['set_key'] = $api_config;



   		$gateway = Omnipay::create('PayPal_Express');

		$gateway->setUsername($api_config['paypal_api_username']);

		$gateway->setPassword($api_config['paypal_api_password']);

		$gateway->setSignature($api_config['paypal_api_signature']);



		$gateway->setTestMode($api_config['paypal_demo']);



		$params = $this->session->userdata('params');

  		$response = $gateway->completePurchase($params)->send();

  		$paypalResponse = $response->getData(); // this is the raw response object

  		$purchaseId = $_GET['PayerID'];

  		$this->data['invoice'] = $this->invoice_m->get_invoice($params['invoice_id']);

  		$recent_paidamount = $params['amount']+$this->data['invoice']->paidamount;

  		if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {

  			// Response

  			if ($purchaseId) {



				$status = 0;

				if($recent_paidamount == $this->data['invoice']->amount) {

					$status = 2;

				} else {

					$status = 1;

				}



				$usertype = $this->session->userdata("usertype");

				$username = $this->session->userdata('username');

				$dbuserID = 0;

				$dbusertype = '';

				$dbuname = '';

				if($usertype == "Admin") {

					$user = $this->user_m->get_username_row("systemadmin", array("username" => $username));

					$dbuserID = $user->systemadminID;

					$dbusertype = $user->usertype;

					$dbuname = $user->name;

				} elseif($usertype == "Accountant") {

					$user = $this->user_m->get_username_row("user", array("username" => $username));

					$dbuserID = $user->userID;

					$dbusertype = $user->usertype;

					$dbuname = $user->name;

				} elseif($usertype == "Student") {

					$user = $this->user_m->get_username_row("student", array("username" => $username));

					$dbuserID = $user->studentID;

					$dbusertype = $user->usertype;

					$dbuname = $user->name;

				} elseif($usertype == "Parent") {

					$user = $this->user_m->get_username_row("parent", array("username" => $username));

					$dbuserID = $user->parentID;

					$dbusertype = $user->usertype;

					$dbuname = $user->name;

				}



				$nowpaymenttype = '';

				if(empty($this->data['invoice']->paymenttype)) {

					$nowpaymenttype = 'Paypal';

				} else {

					if($this->data['invoice']->paymenttype == 'Paypal') {

						$nowpaymenttype = 'Paypal';

					} else {

						$exp = explode(',', $this->data['invoice']->paymenttype);

						if(!in_array('Paypal', $exp)) {

							$nowpaymenttype =  $this->data['invoice']->paymenttype.','.'Paypal';

						} else {

							$nowpaymenttype =  $this->data['invoice']->paymenttype;

						}

					}

				}



				$array = array(

					"paidamount" => $recent_paidamount,

					"status" => $status,

					"paymenttype" => $nowpaymenttype,

					"paiddate" => date('Y-m-d'),

					"userID" => $dbuserID,

					"usertype" => $dbusertype,

					'uname' => $dbuname

				);



				$payment_array = array(

					"invoiceID" => $params['invoice_id'],

					"studentID"	=> $this->data['invoice']->studentID,

					"paymentamount" => $params['amount'],

					"paymenttype" => 'Paypal',

					"paymentdate" => date('Y-m-d'),

					"paymentmonth" => date('M'),

					"paymentyear" => date('Y')

				);



				$this->payment_m->insert_payment($payment_array);



				$studentID = $this->data['invoice']->studentID;

				$getstudent = $this->student_m->get_student($studentID);

				$nowamount = ($getstudent->paidamount)+($params['amount']);

				$this->student_m->update_student(array('paidamount' => $nowamount), $studentID);



				$this->invoice_m->update_invoice($array, $params['invoice_id']);

				$this->session->set_flashdata('success', $this->lang->line('menu_success'));



  			} else {

  				$this->session->set_flashdata('error', 'Payer id not found!');

  			}

  			redirect(base_url("invoice/view/".$params['invoice_id']));

  		} else {



      		//Failed transaction

      		$this->session->set_flashdata('error', 'Payment not success!');

  			redirect(base_url("invoice/view/".$params['invoice_id']));



  		}

  	}

	/* Paypal payment end*/



	function call_all_student() {

		$classesID = $this->input->post('id');

		if((int)$classesID) {

			echo "<option value='". 0 ."'>". $this->lang->line('invoice_select_student') ."</option>";

			$students = $this->student_m->get_order_by_student(array('classesID' => $classesID));

			foreach ($students as $key => $student) {

				echo "<option value='". $student->studentID ."'>". $student->name ."</option>";

			}

		} else {

			echo "<option value='". 0 ."'>". $this->lang->line('invoice_select_student') ."</option>";

		}

	}



	function feetypecall() {

		$feetype = $this->input->post('feetype');

		if($feetype) {

			$allfeetypes = $this->feetype_m->allfeetype($feetype);



			foreach ($allfeetypes as $allfeetype) {

				echo "<li id='". $allfeetype->feetypeID ."'>".$allfeetype->feetype."</li>";

			}

		}

	}



	function date_valid($date) {

		if(strlen($date) <10) {

			$this->form_validation->set_message("date_valid", "%s is not valid dd-mm-yyyy");

	     	return FALSE;

		} else {

	   		$arr = explode("-", $date);

	        $dd = $arr[0];

	        $mm = $arr[1];

	        $yyyy = $arr[2];

	      	if(checkdate($mm, $dd, $yyyy)) {

	      		return TRUE;

	      	} else {

	      		$this->form_validation->set_message("date_valid", "%s is not valid dd-mm-yyyy");

	     		return FALSE;

	      	}

	    }

	}



	function unique_classID() {

		if($this->input->post('classesID') == 0) {

			$this->form_validation->set_message("unique_classID", "The %s field is required");

	     	return FALSE;

		}

		return TRUE;

	}



	function valid_number() {

		if($this->input->post('amount') && $this->input->post('amount') < 0) {

			$this->form_validation->set_message("valid_number", "%s is invalid number");

			return FALSE;

		}

		return TRUE;

	}



	function unique_paymentmethod() {

		if($this->input->post('payment_method') === '0') {

			$this->form_validation->set_message("unique_paymentmethod", "The %s field is required");

	     	return FALSE;

		} elseif($this->input->post('payment_method') === 'Paypal') {

			$api_config = array();

			$get_configs = $this->payment_settings_m->get_order_by_config();

			foreach ($get_configs as $key => $get_key) {

				$api_config[$get_key->config_key] = $get_key->value;

			}

			if($api_config['paypal_api_username'] =="" || $api_config['paypal_api_password'] =="" || $api_config['paypal_api_signature']==""){

				$this->form_validation->set_message("unique_paymentmethod", "Paypal settings required");

				return FALSE;

			}

		}

		return TRUE;

	}



	public function student_list() {

		$studentID = $this->input->post('id');

		if((int)$studentID) {

			$string = base_url("invoice/index/$studentID");

			echo $string;

		} else {

			redirect(base_url("invoice/index"));

		}

	}



	public function userID() {

		$usertype = $this->session->userdata('usertype');

		$username = $this->session->userdata('username');

		if ($usertype=="Admin") {

			$table = "systemadmin";

			$tableID = "systemadminID";

		} elseif($usertype=="Accountant" || $usertype=="Librarian") {

			$table = "user";

			$tableID = "userID";

		} else {

			$table = strtolower($usertype);

			$tableID = $table."ID";

		}

		$query = $this->db->get_where($table, array('username' => $username));

		$userID = $query->row()->$tableID;

		return $userID;

	}

}



/* End of file invoice.php */

/* Location: .//D/xampp/htdocs/school/mvc/controllers/invoice.php */

