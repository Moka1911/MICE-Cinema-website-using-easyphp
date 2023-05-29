<?php
class Main_model extends CI_Model
{
    function can_login($username,$password){
        $this->db->where('MUsername', $username);
        $this->db->where('MPassword', $password);
        $query = $this->db->get('member');
        // Select * From member Where MUsername = '$username' AND MPassword = '$password';
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->MemberID;
        }
        else
        {
            $this->db->where('ManagerUsername', $username);
            $this->db->where('ManagerPassword', $password);
            $query2 = $this->db->get('staff');

            if($query2->num_rows() > 0)
            {
                $row = $query2->row();
                return $row->EmployeeNo;
            }
            else
            {
                return false;
            }
        }


    }









}