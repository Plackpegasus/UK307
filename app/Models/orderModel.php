<?php
/**
 * Created by PhpStorm.
 * User: H3E
 * Date: 25.03.2018
 * Time: 20:06
 */

class Order
{
    private $id;
    private $name;
    private $email;
    private $phonenumber;
    private $conzert;
    private $discount;
    private $paystatus;

    /**
     * Order constructor.
     * @param $name
     * @param $email
     * @param $phonenumber
     * @param $conzert
     * @param $discount
     * @param $paystatus
     */

    private function vailedName()
    {
        $boolean = FALSE;
        if($this->name === "" or (strlen($this->name) <= 2))
            $boolean = TRUE;

        return $boolean;
    }

    private function vailedEmail()
    {
        $boolean = FALSE;
        if($this->email === "")
            $boolean = TRUE;

        return $boolean;
    }

    private function vailedConzert()
    {
        $boolean = FALSE;

        $conn = connectToDatabase();
        $stmt = $conn->prepare('SELECT * from concert_tab t WHERE t.name = :conzert;');

        $stmt->bindParam(':conzert', $this->conzert);
        if(is_null($stmt->fetch()))
            $boolean = TRUE;

        return $boolean;
    }

    private function vailedDiscount()
    {
        $boolean = FALSE;

        $conn = connectToDatabase();
        $stmt = $conn->prepare('SELECT * from discount_tab t WHERE t.id = :discount;');

        $stmt->bindParam(':discount', $this->conzert);
        if(is_null($stmt->fetch()))
        {
            $boolean = TRUE;
        }

        return $boolean;
    }

    public function __construct($id, $name, $email, $phonenumber, $conzert, $discount, $paystatus = 1)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
        $this->conzert = $conzert;
        $this->discount = $discount;
        $this->paystatus = $paystatus;
    }

    public function createOrder()
    {
        $conn = connectToDatabase();

        /*check if it is all vailed*/
        $boolean = TRUE;

        $boolean = $this->vailedName();
        if($boolean === TRUE)
            return 0;
        $boolean = $this->vailedEmail();
        if($boolean === TRUE)
            return 0;
        $boolean = $this->vailedConzert();
        if($boolean === TRUE)
            return 0;
        $boolean = $this->vailedDiscount();
        if($boolean === TRUE)
            return 0;

        /*create statement*/
        $stmt = $conn->prepare('insert into konsert_tickets.tickets_tab (fk_id_concert, fk_id_discount, fk_id_status, name, email, phonenumber) VALUES (:conzert, :discount,  :paystatus, :name, :email, :phonenumber)');

        /*all binds need to do*/
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phonenumber', $this->phonenumber);
        $stmt->bindParam(':conzert', $this->conzert);
        $stmt->bindParam(':discount', $this->discount);
        $stmt->bindParam(':paystatus', $this->paystatus);

        $stmt->execute();
    }

    public function setPaystatus()
    {
        $this->paystatus = !$this->paystatus;
    }

    public function editOrder()
    {
        $conn = core/connectToDatabase();

        /*create statement*/
        $stmt = $conn->prepare("use konsert_tickets; select * in from tickets_tab where id = ? ");

        $stmt->bindParam(':NAME', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':EMAIL', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':PHONENUMBER', $this->phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':CONZERT', $this->conzert, PDO::PARAM_STR);
    }
}

?>