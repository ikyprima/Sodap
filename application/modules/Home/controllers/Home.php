<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller
{
    public $data;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->model('Home_model');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');

    }

    public function index(){
        if (!$this->ion_auth->logged_in()){
            redirect('Home/login', 'refresh');
        }elseif ($this->ion_auth->is_admin()){
            redirect('Cpanel', 'refresh');
        }else{
            redirect('User', 'refresh');
        }





    }

    public function logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('Home', 'refresh');
    }

    public function getnama_pns($id)
    {

        $pns = $this->Home_model->get_namapns($id);
        echo "<option value=''>Pilih Pns</option>";
        foreach ($pns as $k) {
            echo "<option value='{$k->kd}'>{$k->nm}</option>";
        }
    }

    public function pilihpns($id)
    {
        $pns = $this->Home_model->getpns_byid($id);
        foreach ($pns as $row) {
            $arr = array(

                'nip' => $row->nip,
                'nama' => $row->nama,
                'parent_id' => $row->parent_id,
                'id_opd' => $row->id_opd

            );
        }
        // minimal PHP 5.2
        echo json_encode($arr);


    }

    public function tes()
    {
        //$pns=$this->Home_model->getpns_byid($id);
        $tes = $this->ion_auth->users()->result();

        $tmparray = array();
        foreach ($tes as $row) {
            $tmparray[] = array(

                'email' => $row->email,
                'username' => $row->username


            );
        }
        $akhir = array(
            'detail' => $tmparray
        );
        // minimal PHP 5.2
        header('Content-Type: application/json');
        echo json_encode($tmparray);


    }

    public function vuser($group_id = NULL)
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('Home/login', 'refresh');
        } // jika admin yang login
        elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            redirect('Home', 'refresh');
        } else {
            $current_user = $this->ion_auth->user()->row();
            $this->user_id = $current_user->id;
            $this->data['current_user'] = $current_user;
            $this->data['users'] = $this->ion_auth->users($group_id)->result();

            $this->template->load('temp_admin', 'v_list_user', $this->data);
        }

    }
public function passchange()
    {

            $user = $this->ion_auth->user()->row();
            $this->data['user'] = $user;
            $this->data['current_user_menu'] = '';
            $this->load->library('form_validation');



                                //$group_ids = $this->input->post('groups');

                        $new_data['status'] = 0;
                        if(strlen($this->input->post('password'))>=6) $new_data['password'] = $this->input->post('password');






  if ($this->ion_auth->update($user->id, $new_data))
            {
                    // check to see if we are creating the user
                    // redirect them back to the admin page

                    //$this->postal->add($this->ion_auth->messages(),'success');
                    redirect('/Home');

            }
            else
            {
                    $this->data['password'] = array(
                            'name'  => 'password',
                            'id'    => 'password',
                            'type'  => 'password',
                            'placeholder' => 'password',
                            'value' => $this->form_validation->set_value('password'),
                            'class'=>'input100',

                    );
                    $this->data['password_confirm'] = array(
                            'name'  => 'password_confirm',
                            'id'    => 'password_confirm',
                            'type'  => 'password',
                            'placeholder' => 'password konfirmasi',
                            'value' => $this->form_validation->set_value('password_confirm'),
                            'class'=>'input100',
                    );
                   $this->_render_page('updatepass',$this->data);

            }

    }
    public function create()
    {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $identity_column_email = $this->config->item('identity_email', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

        $this->data['page_title'] = 'Create useriuiui';
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First name', 'trim');
        $this->form_validation->set_rules('last_name', 'Last name', 'trim');
        $this->form_validation->set_rules('company', 'Company', 'trim');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        // $this->form_validation->set_rules('username','Username','trim|required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('username', 'nip', 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[' . $tables['users'] . '.' . $identity_column_email . ']');
        }
        // $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('groups[]', 'Groups', 'required|integer');

        if ($this->form_validation->run() === FALSE) {
            $this->data['groups'] = $this->ion_auth->groups()->result();
            $this->load->helper('form');
            $this->data['opd'] = $this->Home_model->get_namaopd();
            $this->template->load('temp_admin', 'v_user_baru', $this->data);
        } else {

            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $group_ids = $this->input->post('groups');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'id_pns' => $this->input->post('edtnamapns'),
                'parent_id' => $this->input->post('parent_id')
            );
            $this->ion_auth->register($username, $password, $email, $additional_data, $group_ids);
            //$this->postal->add($this->ion_auth->messages(),'success');
            redirect('Home/vuser');
        }
    }





    //Ini function login api
    public function loginapi()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = $this->ion_auth->login($username, $password);


        if (!empty($result)) {
            $this->set_response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }

    //Ini function login

    public function login()
    {


        if ($this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('Admin', 'refresh');
        } else {
            $this->data['title'] = $this->lang->line('login_heading');

            //validate form input
            $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
            $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

            if ($this->form_validation->run() == true) {
                // check to see if the user is logging in
                // check for "remember me"
                $remember = (bool)$this->input->post('remember');

                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('Home', 'refresh');
                } else {
                    // if the login was un-successful
                    // redirect them back to the login page
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('Home/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                }
            } else {
                // the user is not logging in so display the login page
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['identity'] = array('name' => 'identity',
                    'id' => 'identity',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('identity'),
                );
                $this->data['password'] = array('name' => 'password',
                    'id' => 'password',
                    'type' => 'password',
                );


                $this->_render_page('login', $this->data);
            }

        }


    }
public function update()
    {
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('Home/login', 'refresh');
        }
            $this->data['page_title'] = 'User Profile';
            $user = $this->ion_auth->user()->row();
            $this->data['user'] = $user;
            $this->data['current_user_menu'] = '';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
            $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
            $this->form_validation->set_rules('born','Tempat Lahir','trim|required');
            $this->form_validation->set_rules('date_born','Tanggal Lahir','trim|required');
            $this->form_validation->set_rules('addres','alamat','trim');
            $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
            $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
            $this->form_validation->set_rules('password','Password','min_length[6]');
            $this->form_validation->set_rules('password_confirm','Password confirmation','matches[password]');
            if ($this->form_validation->run() == true)
            {
                                $new_data = array
                                    (
                                    'first_name'        => $this->input->post('first_name'),
                                    'last_name'         => $this->input->post('last_name'),
                                    'company'           => $this->input->post('company'),
                                    'phone'             => $this->input->post('phone'),
                                    'date_born'         => $this->input->post('date_born'),
                                    'addres'            => $this->input->post('addres'),
                                    'born'              => $this->input->post('born')
                                    );
                                    if(strlen($this->input->post('password'))>=6) $new_data['password'] = $this->input->post('password');


            }

            if ($this->form_validation->run() == true && $this->ion_auth->update($user->id, $new_data))
            {
                    // check to see if we are creating the user
                    // redirect them back to the admin page

                    $this->postal->add($this->ion_auth->messages(),'success');
                    redirect('/User/profile');

            }
            else
            {
                    // display the create user form
                    // set the flash data error message if there is one

                    $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                    $this->data['identity'] = array(
                            'name'  => 'identity',
                            'id'    => 'identity',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('identity',$user->username),
                            'class' => 'form-control',
                            'readonly' => true,
                    );


                    $this->data['first_name'] = array(
                            'name'  => 'first_name',
                            'id'    => 'first_name',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('first_name',$user->first_name),
                            'class' => 'form-control',
                    );


                    $this->data['last_name'] = array(
                            'name'  => 'last_name',
                            'id'    => 'last_name',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('last_name',$user->last_name),
                            'class' => 'form-control',
                    );
                    $this->data['born'] = array(
                            'name'  => 'born',
                            'id'    => 'born',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('born',$user->born),
                            'class' => 'form-control',
                    );
                    $this->data['date_born'] = array(
                            'name'  => 'date_born',
                            'id'    => 'datepicker',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('date_born',$user->date_born),
                            'class' => 'form-control',
                    );
                    $this->data['addres'] = array(
                        'name'=>'addres',
                        'id'=>'addres',
                        'rows'=>'3',
                        'class'=>'form-control',
                        'value' => $this->form_validation->set_value('addres',$user->addres),
                    );
                    $this->data['email'] = array(
                            'name'  => 'email',
                            'id'    => 'email',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('email',$user->email),
                            'class'=>'form-control',
                          'readonly' => true,
                    );
                    $this->data['company'] = array(
                            'name'  => 'company',
                            'id'    => 'company',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('company',$user->company),
                            'class'=>'form-control',
                    );
                    $this->data['phone'] = array(
                            'name'  => 'phone',
                            'id'    => 'phone',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('phone',$user->phone),
                            'class'=>'form-control',
                    );
                    $this->data['password'] = array(
                            'name'  => 'password',
                            'id'    => 'password',
                            'type'  => 'password',
                            'value' => $this->form_validation->set_value('password'),
                            'class'=>'form-control',
                    );
                    $this->data['password_confirm'] = array(
                            'name'  => 'password_confirm',
                            'id'    => 'password_confirm',
                            'type'  => 'password',
                            'value' => $this->form_validation->set_value('password_confirm'),
                            'class'=>'form-control',
                    );

                    $this->template->load('temp_user','v_user_profil',$this->data);

            }

}





    public function _render_page($view, $data = null, $returnhtml = false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }
}
