<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	 
	 function __construct()
	{
		parent::__construct();	 
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		$this->load->library('table');
	}
	
	public function index()
	{	
		$this->load->view('homepage');
	}
	public function login_page()
	{	
		//'http://localhost:8080/MICE/application/Main/login_page'
		$this->load->view("LoginPage");
	}
	public function profile_page()
	{	
		$this->load->view('profile-fake');
	}
	public function confirmation_page()
	{	
		$this->load->view('confirmation-page');
	}
	public function finance_page()
	{	
		$this->load->view('financepage');
	}
	public function booking_page()
	{
		$this->load->view('bookingpage');
	}
	function Login_Validation()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run())
		{
			//true
			$username = $this->input->POST('username');
			$password = $this->input->POST('password');

			$this->load->model('main_model');
			if($MemberID =$this->main_model->can_login($username, $password))
			{
				$session_data = array(  
					'username'     =>     $username  ,
					'userID'       =>     $MemberID
			   );  
			   $this->session->set_userdata($session_data);  
			   redirect(site_url('Main/index'));
			}
			else
			{
				$this->session->set_flashdata('error','Invalid Username and Password');
				redirect(site_url('Main/login_page'));
			}

		}
		else
		{
			//false
			$this->login_page();
		}
	}

	function logout()  
      {  
           $this->session->unset_userdata('username');
		   $this->session->unset_userdata('userID'); 
           redirect(site_url('Main/index')); 
      }

	function Update_info()
	{
		$First_name = $this->input->POST('First_name');
		$Last_name = $this->input->POST('Last_name');
		$Address = $this->input->POST('Address');
		$Phone = $this->input->POST('Mobile_Number');
		$DoB = $this->input->POST('Date_of_Birth');
		$Gender = $this->input->POST('Gender');

		if($this->session->userdata('userID')>=1000000){
			$user = $this->session->userdata('userID');
			$this->db->query("Update member SET first_name ='$First_name', last_name ='$Last_name', Address ='$Address', PhoneNo ='$Phone', DoB ='$DoB', Gender = '$Gender' WHERE MemberID= '$user';");
			$this->user_bookings();
		}
		else{
			$user = $this->session->userdata('userID');
			$this->db->query("Update staff SET first_name ='$First_name', last_name ='$Last_name', Address ='$Address', PhoneNo ='$Phone', DoB ='$DoB', Gender ='$Gender' WHERE EmployeeNo= '$user';");
			$this->user_bookings();
		}
		

	}

	public function user_bookings(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('booking');
		$crud->set_subject('booking');
		$crud->columns('BookingID', 'NoofSeats', 'MainGoer' ,'ShowingNo', 'Date');
		$crud->fields( 'NoofSeats', 'MainGoer','ShowingNo','Date');
		$crud->display_as('NoofSeats','Seats');
		$crud->display_as('MainGoer','Name');
		$crud->where(['booking.MemberID' => $this->session->userdata('userID')]);
		$crud->unset_add();
		$crud->unset_edit();
		$output = $crud->render();
		$this->user_bookings_output($output);
	}

	function user_bookings_output($output = null){
		$this->load->view('profile-fake.php',$output);
	}

	public function film(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('film');
		$crud->set_subject('film');
		$crud->columns('FilmID', 'Released', 'Title' ,'Director', 'Classification', 'Duration' ,'Description', 'ImagePath');
		$crud->fields( 'Released', 'Title' ,'Director', 'Classification', 'Duration' ,'Description', 'ImagePath');
		$crud->display_as('FilmID','Film ID');
		$crud->display_as('	ImagePath','Image Path');
		$output = $crud->render();
		$this->film_output($output);
	}

	function film_output($output = null){
		$this->load->view('managerpage.php',$output);
	}

	public function screen(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('screen');
		$crud->set_subject('screen');
		$crud->columns('CinemaID', 'ScreenNo', 'Seats' ,'SeatPrice');
		$crud->fields('CinemaID', 'ScreenNo', 'Seats' ,'SeatPrice');
		$crud->display_as('CinemaID','Cinema ID');
		$crud->display_as('ScreenNo','Screen No');
		$crud->display_as('SeatPrice','Seat Price');
		$output = $crud->render();
		$this->screen_output($output);
	}

	function screen_output($output = null){
		$this->load->view('managerpage.php',$output);
	}

	public function showing(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('showing');
		$crud->set_subject('showing');
		$crud->columns('ShowingNo', 'CinemaID', 'ScreenNo' ,'FilmID');
		$crud->fields( 'ShowingNo','CinemaID', 'ScreenNo' ,'FilmID');
		$crud->display_as('CinemaID','Cinema ID');
		$crud->display_as('ScreenNo','Screen No');
		$crud->display_as('ShowingNo','Showing No');
		$crud->display_as('FilmID','Film ID');
		$output = $crud->render();
		$this->showing_output($output);
	}

	function showing_output($output = null){
		$this->load->view('managerpage.php',$output);
	}

	public function performance(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('performance');
		$crud->set_subject('performance');
		$crud->columns('ShowingNo', 'Date', 'Time' ,'SeatsLeft');
		$crud->fields( 'ShowingNo', 'Date', 'Time' ,'SeatsLeft');
		$crud->display_as('ShowingNo','Showing No');
		$crud->display_as('SeatsLeft','Seats Left');
		$output = $crud->render();
		$this->performance_output($output);
	}

	function performance_output($output = null){
		$this->load->view('managerpage.php',$output);
	}

	public function Cinema(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('cinema');
		$crud->set_subject('cinema');
		$crud->columns('CinemaID', 'CName', 'Location' ,'Address','ManagerID');
		$crud->fields('CinemaID', 'CName', 'Location' ,'Address','ManagerID');
		$crud->display_as('CName','Cinema Name');
		$output = $crud->render();
		$this->Cinema_output($output);
	}

	function Cinema_output($output = null){
		$this->load->view('managerpage.php',$output);
	}
	public function members(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('member');
		$crud->set_subject('member');
		$crud->columns('MemberID', 'Title', 'first_name' ,'last_name', 'DoB', 'Joined', 'Status', 'Gender', 'Email', 'Address', 'PhoneNo', 'MUsername', 'is_staff');
		$crud->fields( 'Title', 'first_name' ,'last_name', 'DoB', 'Joined', 'Status', 'Gender', 'Email', 'Address', 'PhoneNo');
		$crud->display_as('first_name','First Name');
		$crud->display_as('last_name','Last Name');
		$output = $crud->render();
		$this->members_output($output);
	}

	function members_output($output = null){
		$this->load->view('managerpage.php',$output);
	}

	public function booking(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('booking');
		$crud->set_subject('booking');
		$crud->columns('BookingID', 'NoofSeats', 'ShowingNo', 'Date', 'MemberID');
		$crud->fields( 'BookingID', 'NoofSeats', 'ShowingNo', 'Date', 'MemberID');
		$crud->display_as('ShowingNo','Showing No');
		$crud->display_as('BookingID','Booking ID');
		$crud->display_as('NoofSeats','Seats');
		$crud->display_as('MainGoer','Name');
		$crud->display_as('MemberID','Member ID');
		$output = $crud->render();
		$this->booking_output($output);
	}

	function booking_output($output = null){
		$this->load->view('managerpage.php',$output);
	}


	public function staff(){
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('staff');
		$crud->set_subject('staff');
		$crud->columns('EmployeeNo', 'Name', 'Address' , 'PhoneNo', 'DoB', 'Date_Joined', 'Salary', 'Supervisor', 'CinemaID');
		$crud->fields( 'Name', 'Address' , 'PhoneNo', 'DoB', 'Salary', 'Supervisor');
		$crud->display_as('EmployeeNo','Employee No');
		$crud->display_as('PhoneNo','Phone No');
		$crud->display_as('DoB','Date of Birth');
		$crud->display_as('CinemaID','Cinema ID');
		$crud->display_as('Date_Joined','Date Joined');
		$output = $crud->render();
		$this->staff_output($output);
	}

	function staff_output($output = null){
		$this->load->view('managerpage.php',$output);
	}

	public function finance_report(){
		$output = $this->db->query(
		'SELECT  Title ,ShowingNo, Tickets_sold, Tickets_sold*SeatPrice As Money_gained
		From screen natural join film natural join (SELECT ShowingNo,count(ShowingNo) AS \'Tickets_sold\'
		From booking
		Group by ShowingNo) As T2;
		');
		$this->finance_report_output($output);
}
	function finance_report_output($output = null){
		$this->load->view('financepage.php',$output);
	}

	public function Add_booking(){
		$Seat = $this->input->get_post("Seat");
		$FilmID = $_GET['FilmID'];
		$cinema = $this->input->get_post("Cinema");
		$showing = $this->db->query("Select ShowingNo,Time
		From cinema natural join screen natural join showing natural join film natural join performance
		where FilmID = $FilmID and CName= '$cinema'
		Group by ShowingNo,Time;
		");
		$row = $showing->row();
		$showing_no = $row->ShowingNo;
		$user = $this->session->userdata('userID');
		$Date = $this->input->get_post("Date");
		$user_name = $this->session->userdata('username');
		$status_query = $this->db->query("Select * from member where MUsername = '$user_name';");
		$row = $status_query->row();
		$status = $row->Status;
		
		if ($user >= 1000000 && $status == 'Active'){
			$this->db->query("Update performance Set SeatsLeft = SeatsLeft-$Seat where ShowingNo = $showing_no;");
			$Booking_id = $this->db->query("Select max(BookingID) as 'BookingID' From booking where ShowingNo= $showing_no and NoofSeats = $Seat and Date = '$Date' and MemberID = $user;");
			$this->db->query("Insert into booking (NoofSeats,ShowingNo,Date,MemberID) Values ('$Seat', '$showing_no', '$Date', '$user');");
			$this->load->view('confirmation-page.php');
		}
		else if($user < 1000000 && $status == 'Active'){
			$this->db->query("Update performance Set SeatsLeft = SeatsLeft-$Seat where ShowingNo = $showing_no;");
			$Manager_account = $this->db->query("Select * from member where MUsername = '$user_name' and is_staff = 1;");
			$row = $Manager_account->row();
			$Manager_User_account = $row->MemberID;
			$this->db->query("Insert into booking (NoofSeats,ShowingNo,Date,MemberID) Values ('$Seat', '$showing_no', '$Date', '$Manager_User_account');");
			$this->load->view('confirmation-page.php');
		}
		else{
			$data = array('error' => 'Please renew your membership to be able to make a booking');
			$this->load->view('confirmation-page.php',$data);
		}
		

		
}

}