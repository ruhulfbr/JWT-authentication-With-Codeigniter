<?php
require APPPATH . '/libraries/CreatorJwt.php';

class Jwt_token extends CI_Controller
{
    public function __construct()
    {
        
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
    }


    public function index(){
        echo 'csdasdf';
    }
    /*************Ganerate token this function use**************/

    public function LoginToken()
    {

        $tokenData['userid'] = 'ruhul01749';
        $tokenData['username'] = 'Ruhul';
        $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
        $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
        echo json_encode(array('Token'=> $jwtToken));
    }
     

    public function logout(){
        $received_Token = $this->input->request_headers('Authorization');
        $token = $received_Token['Token'];
        if(empty($token)){
            $res['type'] = "Success";
            $res['message'] = "User logout succesfully";
            $res['code'] = "1004";
            $res['hash'] = md5('a2450d51d3253c05f7aa6f68842db88b');
            echo json_encode($res);
        }else if(!empty($token)){
             try
            {
                $jwtData = $this->objOfJwt->DecodeToken($token);
                $res['type'] = "Error";
                $res['message'] = "Logout Failed";
                $res['code'] = "1004";
                $res['hash'] = md5('a2450d51d3253c05f7aa6f68842db88b');
                echo json_encode($res);
            }
            catch (Exception $e)
                {
                $res['type'] = "Success";
                $res['message'] = "User logout succesfully";
                $res['code'] = "1004";
                $res['hash'] = md5('a2450d51d3253c05f7aa6f68842db88b');
                echo json_encode($res);
            }
        }
    }

   /*************Use for token then fetch the data**************/
         
    public function GetTokenData()
    {
    $received_Token = $this->input->request_headers('Authorization');
        try
        {
            $jwtData = $this->objOfJwt->DecodeToken($received_Token['Token']);
            echo json_encode($jwtData);
        }
        catch (Exception $e)
            {
            http_response_code('401');
            echo json_encode(array( "status" => false, "message" => $e->getMessage()));exit;
        }
    }
}
        