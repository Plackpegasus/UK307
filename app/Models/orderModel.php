<?php
/**
 * Created by PhpStorm.
 * User: H3E
 * Date: 25.03.2018
 * Time: 20:06
 */

class Order
{
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
        if($this->name !== "")
            $boolean = TRUE;

        return $boolean;
    }

    private function vailedEmail()
    {
        $boolean = FALSE;
        if($this->email !== "")
            $boolean = TRUE;

        return $boolean;
    }

    public function __construct($name, $email, $phonenumber, $conzert, $discount, $paystatus)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phonenumber = $phonenumber;
        $this->conzert = $conzert;
        $this->discount = $discount;
        $this->paystatus = $paystatus;
    }

    public function createOrder()
    {
        $conn = core/connectToDatabase();

        /*check if it is all vailed*/
        $boolean = FALSE;

        $boolean = $this->vailedName();
        $boolean = $this->vailedEmail();

        if($boolean === FALSE)
            return "Error";

        /*create statement*/
        $stmt = $conn->prepare("insert into konsert_tickets.tickets_tab() VALUES (:NAME, :EMAIL, :PHONENUMBER, :CONZERT, :DISCONNECT,:PAYSTATUS)");

        /*all binds need to do*/
        $stmt->bindParam(':NAME', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':EMAIL', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':PHONENUMBER', $this->phonenumber, PDO::PARAM_STR);
        $stmt->bindParam(':CONZERT', $this->conzert, PDO::PARAM_STR);
        $stmt->bindParam(':DISCONNECT', $this->discount, PDO::PARAM_INT);
        $stmt->bindParam(':PAYSTATUS', $this->paystatus, PDO::PARAM_BOOL);

        $stmt->execute();

    }

    public function setPaystatus()
    {
        $this->paystatus = !$this->paystatus;
    }
}

?>