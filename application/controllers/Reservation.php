<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Reservation extends REST_Controller {

    public function __construct($config = 'rest') {
        parent::__construct($config);
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->database();
    }

    public function index_get() 
    {
        $id_reservation = $this->get('id_reservation');
        if ($id_reservation == '') {
            $reservation = $this->db->get('reservation')->result();
        } else {
            $this->db->where('id_reservation', $id_reservation);
            $reservation = $this->db->get('reservation')->result();
        }
        $this->response($reservation, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $data = array(
            'id_reservation' => $this->post('id_reservation'), // Automatically generated by the model
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'namarental' => $this->post('namarental'),
            'email' => $this->post('email'),
            'logo' => $this->post('logo'),
            'nohp' => $this->post('nohp'),
            'bio' => $this->post('bio'),
            'level' => $this->post('level')
        );

        $insert = $this->db->insert('reservation', $data);
        if ($insert) {
            $this->response($data, REST_Controller::HTTP_CREATED);
        }
    }

    public function index_put()
    {
        $id_reservation = $this->put('id_reservation');
        $data = array(
                    'id_reservation' => $this->post('id_reservation'), // Automatically generated by the model
                    'username' => $this->post('username'),
                    'password' => $this->post('password'),
                    'namarental' => $this->post('namarental'),
                    'email' => $this->post('email'),
                    'logo' => $this->post('logo'),
                    'nohp' => $this->post('nohp'),
                    'bio' => $this->post('bio'),
                    'level' => $this->post('level')
                );
        $this->db->where('id_reservation', $id_reservation);
        $update = $this->db->update('reservation', $data);
        if ($update) {
            $this->response($data,  REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'FALSE', REST_Controller::HTTP_NOT_FOUND));
        }
    }

    public function index_delete()
    {
        $id_reservation = $this->delete('id_reservation');
        $this->db->where('id_reservation', $id_reservation);
        $delete = $this->db->delete('reservation');
        if ($delete) {
            $this->response(array('status' => 'success'), REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'FALSE', REST_Controller::HTTP_NOT_FOUND));
        }
    }
}