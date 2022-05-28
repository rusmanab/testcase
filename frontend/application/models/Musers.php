<?php
class Musers extends MY_model
{

    protected static $table = 'm_users';
    protected static $pid   = 'id';

    public function userLogin($usernama, $password)
    {
        $q = "SELECT * FROM m_users WHERE username='" . $usernama . "' AND password='" . $password . "' AND status='1'";

        $res = $this->db->query($q);
        return $res->row();
    }

    public function cekOtoritas($url, $level)
    {
        $q = "SELECT id FROM m_user_menu WHERE not_allow='" . $url . "' AND user_level_id='" . $level . "'";
        $res = $this->db->query($q);
        return $res->row();
    }

    public function getDataTable($level = '3')
    {
        $sIndexColumn = 'id';

        $columns = array(
            array(
                'db' => 'id',  'dt' => 0, 'suffix' => 'm',
                'formatter' => function ($d, $row) {

                    return '<input type="checkbox" class="form-check-input check-table" value="'.$d.'">';
                }
            ),
            array(
                'db' => 'username',  'dt' => 1, 'suffix' => 'm',
                'formatter' => function ($d, $row) {
                    $html = $row['username'] . "
                <div class='table-links'>
                <a href='users/details/" . $row['id'] . "' class='mr-2'>Edit</a>
                <span class='text-mute mr-2'>|</span>
                <a href='' class='btnDel text-danger' id='btnDel' data-id='" . $row['id'] . "'>Delete</a>
                </div>";
                    return $html;
                }
            ),
            array('db' => 'nama_lengkap',  'dt' => 2, 'suffix' => 'm'),
            array('db' => 'email',  'dt' => 3, 'suffix' => 'm'),
            array('db' => 'phone',  'dt' => 4, 'suffix' => 'm'),
            array('db' => 'role',  'dt' => 5, 'suffix' => 'l',),
            array('db' => 'status',  'dt' => 6, 'suffix' => 'm'),
            // array(
            //     'db' => 'id',  'dt' => 6, 'suffix' => 'm',
            //     'formatter' => function ($d, $row) {

            //         return '<a href="users/details/' . $row['id'] . '"><button class="btn btn-block bg-gradient-primary btn-sm">Details</button></a><button class="btn btn-block bg-gradient-danger btn-sm btnDel" id="btnDel" data-id="' . $row['id'] . '">Delete</button>';
            //     }
            // )
            array(
                'db' => 'id',  'dt' => 7, 'suffix' => 'm',
                'formatter' => function ($d, $row) {

                    return '<p>Created<br>2020/11/28 at 9:05 am</p>';
                }
            )
        );

        $whereAnd = "";
        if ($level != 3) {
        }

        $q = "SELECT m.id, m.username, m.nama_lengkap, m.email,user_level_id, l.role, m.phone,";
        $q .= " CASE WHEN m.status = 1 THEN 'Active' ELSE 'Not Active' END AS status";
        $q .= " FROM m_users m RIGHT JOIN m_user_level l ON m.user_level_id = l.id  WHERE isdelete = '0'"; // m.isdelete = 0
        $result = $this->simple($_GET, self::$table, $sIndexColumn, $columns, $q, 1);
        echo json_encode($result);
    }
    public function getLevel($level = '3')
    {
        $q = "SELECT * FROM m_user_level";
        if ($level == '2') {
            $q = "SELECT * FROM m_user_level WHERE id !=3";
        } elseif ($level == '1') {
            $q = "SELECT * FROM m_user_level WHERE id =1";
        }

        $res = $this->db->query($q);
        return $res->result();
    }
}
