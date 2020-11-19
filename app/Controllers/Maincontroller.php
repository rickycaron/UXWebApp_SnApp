<?php


namespace App\Controllers;


class Maincontroller extends \CodeIgniter\Controller
{
    private $menu_model;
    private $database_model;
    private $data;
    private $userName = "Maarten";

    /**
     * Maincontroller constructor.
     */
    public function __construct() {
        $this->menu_model = new \Menu_model();
        $this->database_model = new \Database_model();
    }

    private function set_common_data($header_icon_1, $header_icon_2) {
        $this->data['header_icon_1'] = $header_icon_1;
        $this->data['header_icon_2'] = $header_icon_2;
    }

    public function leaderboardSelect() {
        $this->set_common_data('eco', 'search');

        //add your code here...
        $this->data['content'] = view('leaderboardSelect'); //replace by your own view
        $this->data['title'] = 'Leaderboard Select';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('leaderboardSelect');
        return view("mainTemplate", $this->data);
    }

    public function leaderboard() {
        $this->set_common_data('arrow_back', 'search');

        $this->data['content'] = view('leaderboard');
        $this->data['title'] = 'Leaderboard';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('leaderboardSelect');
        return view("mainTemplate", $this->data);
    }

    public function hub() {
        $this->set_common_data('eco', 'search');

        //get current user
        $userIdArray = $this->database_model->getUserID($this->userName);
        $userID = $userIdArray[0]->id;

        //get friends of current user
        $friendsArray = $this->database_model->getFriendsUserName($userID);

        //check if the url contains parameter for new observations
        $variableActive = $this->request->getVar('extra');
        if ($variableActive != null) {
            $getMoreObservations = $_GET['extra'];
            $lastDate = $_GET['lastDate'];
            $lastTime = $_GET['lastTime'];
            $tomorrow = $_GET['tomorrow'];

            if (strcasecmp($getMoreObservations, 'true') == 0) {
                //get more observations from friends from current users
                $data3['observations'] = $this->database_model->getMoreObservationsForHub($friendsArray, $lastDate, $tomorrow, $lastTime);
                return view('hubPage', $data3);
            }
        }

        //get observations from friends from current users
        $data2['observations'] = $this->database_model->getFirstObservationsForHub($friendsArray);

        $this->data['content'] = view('hubPage', $data2); //replace by your own view
        $this->data['title'] = 'Observation Feed';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('hub');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js','showMoreFriendsObservations.js');
        return view("mainTemplate", $this->data);
    }

    public function groups() {
        $this->set_common_data('eco', 'search');

        //add your code here...
        $this->data['content'] = view('groupsOverviewPage'); //replace by your own view
        $this->data['title'] = 'Groups';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('groups');
        return view("mainTemplate", $this->data);
    }

    public function group() {
        $this->set_common_data('arrow_back', 'search');

        //add your code here...
        $this->data['content'] = view('groupPage'); //replace by your own view
        $this->data['title'] = 'Group';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('groups');
        return view("mainTemplate", $this->data);
    }

    public function profile() {
        $this->set_common_data('search', 'menu');

        //add your code here...
        $this->data['content'] = view('profile'); //replace by your own view
        $this->data['title'] = 'Profile';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('profile');
        return view("mainTemplate", $this->data);
    }

    public function addObservation() {
        $this->set_common_data('eco', 'search');

        //add your code here...
        $this->data['content'] = view('addobservation'); //replace by your own view
        $this->data['title'] = 'Add Observation';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('addObservation');
        $this->data['scripts_to_load'] = array('jquery-3.5.1.min.js','plantAPI.js', 'previewPicture.js');
        return view("mainTemplate", $this->data);

    }

    public function friendList() {
        $this->set_common_data('arrow_back', 'search');

        //add your code here...
        $this->data['content'] = view('friendList'); //replace by your own view
        $this->data['title'] = 'Friend List';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('addObservation');
        return view("mainTemplate", $this->data);
    }

    public function search() {
        $this->set_common_data('arrow_back', 'search');

        //add your code here...
        $this->data['content'] = view('search'); //replace by your own view
        $this->data['title'] = 'Search';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('addObservation');
        return view("mainTemplate", $this->data);
    }
    public function login() {
        $this->data=[];
        $this->set_common_data('eco', 'eco');

        //add your code here...
        helper(['form']);//to remain the user's typed value if the login fails
        $this->data['error_message'] =' ';
        if ($this->request->getMethod() === 'post' && $this->validate([
                'email'  => 'required|min_length[3]|max_length[40]|valid_email|is_not_unique[user.email]',
                'password'=>'required|min_length[6]|max_length[50]'
            ]))
        {
            //check the password
            $email= $this->request->getPost('email');
            $password=$this->request->getPost('password');
            $searchresult=$this->database_model->validateUser($email,$password);
            if ($searchresult==0){
                //password is correct
                // set global username to use in other views (to query the database)
                $this->userName = $this->database_model->getUsername($email);
                //return hub
                return redirect()->to('hub');
            }
            else if($searchresult==1){
                //password is wrong
                $this->data['error_message'] = 'Wrong password. Try again or click Forgot password to reset it.';
            }
            else if ($searchresult==2){
                //user doesn't exsit
                $this->data['error_message'] = 'Invalid username. Please register one account.';

            }
            else if ($searchresult==3){
                //multiple accounts with the same user name,
                $this->data['error_message'] = 'Multiple accounts with the same email exsit. Please consult our software developer!';
            }
        }
        $this->data['content'] = view('login'); //replace by your own view
        return view("extraTemplate", $this->data);
    }
    public function loginFromObservation() {
        $this->set_common_data('eco', 'eco');

        //add your code here...
        $this->data['content'] = view('loginFromObservation'); //replace by your own view
        $this->data['title'] = 'Login From Observation';


        return view("extraTemplate", $this->data);
    }
    public function register() {
        $this->data=[];
        $this->set_common_data('eco', 'eco');
        //add your code here...
        helper(['form']);
        if ($this->request->getMethod() === 'post' && $this->validate([
                'username' => 'required|min_length[3]|max_length[255]|alpha_dash|is_unique[user.username]',
                'email'  => 'required|min_length[3]|max_length[40]|valid_email|is_unique[user.email]',
                'password'=>'required|min_length[6]|max_length[50]',
                'password_confirm'=>'matches[password]'
            ]))
        {
            $username= $this->request->getPost('username');
            $email= $this->request->getPost('email');
            $password=$this->request->getPost('password');
            $this->database_model-> insertUser($username,$password,$email);

            return redirect()->to('hub');

        }
        else
        {
            $this->data['content'] = view('register'); //replace by your own view
            return view("extraTemplate", $this->data);
        }

    }
    public function forgotPassword() {
        $this->set_common_data('eco', 'eco');

        //add your code here...
        $this->data['content'] = view('forgotPassword'); //replace by your own view
        $this->data['title'] = 'Forgot Password';


        return view("extraTemplate", $this->data);
    }
    public function resetPassword() {
        $this->set_common_data('eco', 'eco');

        //add your code here...
        $this->data['content'] = view('resetPassword'); //replace by your own view
        $this->data['title'] = 'Reset Password';


        return view("extraTemplate", $this->data);
    }
    public function anobservation() {
        $this->set_common_data('eco', 'search');

        //add your code here...
        $this->data['content'] = view('anobservation'); //replace by your own view
        $this->data['title'] = 'Observation';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('none');
        return view("mainTemplate", $this->data);
    }
    public function edit_profile() {
        $this->set_common_data('arrow_back', 'search');

        //add your code here...
        $this->data['content'] = view('edit_profile'); //replace by your own view
        $this->data['title'] = 'edit profile';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('addObservation');
        return view("mainTemplate", $this->data);
    }
    public function account() {
        $this->set_common_data('arrow_back', 'search');

        //add your code here...
        $this->data['content'] = view('account'); //replace by your own view
        $this->data['title'] = 'Account';

        $this->data['menu_items'] = $this->menu_model->get_menuitems('addObservation');
        return view("mainTemplate", $this->data);
    }
}