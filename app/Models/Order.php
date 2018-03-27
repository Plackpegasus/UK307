<?php
/**
 * Created by PhpStorm.
 * User: H3E
 * Date: 25.03.2018
 * Time: 20:06
 */

const SELECTS_ORDER = ["CONSTRUCTOR" => ["ALL" => "SELECT * from konsert_tickets.tickets_tab t ORDER BY t.id",
                                        "VIEW" => "SELECT * from konsert_tickets.tickets_tab t WHERE  t.fk_id_status = 1 ORDER BY t.buy_date"]];

class Order
{
    private $id;
    private $Person;
    private $Consert;
    private $Discount;
    private $Status;

    public function __construct($id = null, $Person = null, $Consert = null, $Discount = null, $Status = null)
    {
        $this->id = $id;
        $this->Person = $Person;
        $this->Consert = $Consert;
        $this->Discount = $Discount;
        $this->Status = $Status;
    }

    public function createOrder()
    {
        $conn = connectToDatabase();

        /*create statement*/
        $stmt = $conn->prepare('insert into konsert_tickets.tickets_tab (fk_id_concert, fk_id_discount, fk_id_status, name, email, phonenumber) VALUES (:consert, :discount,  :status, :name, :email, :phonenumber)');

        /*all binds need to do*/
        $stmt->bindParam(':name', $this->Person->getName());
        $stmt->bindParam(':email', $this->Person->getEmail());
        $stmt->bindParam(':phonenumber', $this->Person->getPhonenumber());
        $stmt->bindParam(':consert', $this->Consert->getId());
        $stmt->bindParam(':discount', $this->Discount->getId());
        $stmt->bindParam(':status', $this->Status->getId());

        $stmt->execute();
    }

    public function update()
    {
        $conn = connectToDatabase();

        $stmt = $conn->prepare('update konsert_tickets.tickets_tab set name = :name, email= :email, phonenumber = :phonenumber,  fk_id_concert = :concert, fk_id_status = :status WHERE id = :id;');

        $name = $this->Person->getName();
        $email = $this->Person->getEmail();
        $phonenumber = $this->Person->getPhonenumber();
        $cid= $this->Consert->getId();
        $sid = $this->Status->getId();

        /*all binds need to do*/
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phonenumber', $phonenumber);
        $stmt->bindParam(':concert', $cid);
        $stmt->bindParam(':status', $sid);

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();
    }

    public static function changeStatusIdByOrderId($id, $fk)
    {
        $conn = connectToDatabase();
        $stmt = $conn->prepare(SELECTS_STATUS["INSERT"]["CHANGESTATUSIDBYORDERID"]);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fk', $fk);

        $stmt->execute();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getPerson()
    {
        return $this->Person;
    }

    /**
     * @return null
     */
    public function getConsert()
    {
        return $this->Consert;
    }

    /**
     * @return null
     */
    public function getDiscount()
    {
        return $this->Discount;
    }

    /**
     * @return null
     */
    public function getStatus()
    {
        return $this->Status;
    }
}

?>