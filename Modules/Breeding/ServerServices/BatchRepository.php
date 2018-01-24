<?php
namespace Modules\Breeding\ServerServices;

class BatchRepository extends \Mumux\Server\Repository
{

    public function getAll($id_space)
    {

        $sql = "SELECT breeding_batches.*, stock_batches.* ";
        $sql .= "FROM breeding_batches ";
        $sql .= "INNER JOIN stock_batches ON breeding_batches.id_stock_batch = stock_batches.id ";
        $sql .= "WHERE breeding_batches.id_space=?";

        $req = $this->runRequest($sql, array($id_space));
        return $req->fetchAll();
    }

    public function getAllOpened($id_space)
    {
        $sql = "SELECT breeding_batches.id as id, stock_batches.name, stock_batches.created_date ";
        $sql .= "FROM breeding_batches ";
        $sql .= "INNER JOIN stock_batches ON breeding_batches.id_stock_batch = stock_batches.id ";
        $sql .= "WHERE breeding_batches.id_space=? AND stock_batches.quantity > 0";

        $req = $this->runRequest($sql, array($id_space));
        return $req->fetchAll();
    }

    public function getAllClosed($id_space)
    {
        $sql = "SELECT breeding_batches.id as id, stock_batches.name, stock_batches.created_date ";
        $sql .= "FROM breeding_batches ";
        $sql .= "INNER JOIN stock_batches ON breeding_batches.id_stock_batch = stock_batches.id ";
        $sql .= "WHERE breeding_batches.id_space=? AND stock_batches.quantity = 0";

        $req = $this->runRequest($sql, array($id_space));
        return $req->fetchAll();
    }

    public function add($parameters)
    {
        $sql = "INSERT INTO stock_batches (name, created_date, initial_quantity, quantity, id_product, origin) VALUES (?,?,?,?,?,?)";
        $this->runRequest($sql, array(
            $parameters["name"],
            $parameters["created_date"],
            $parameters["initial_quantity"],
            $parameters["initial_quantity"],
            $parameters["id_product"],
            "breeding"
        ));
        $id_stock = $this->getLastInsertId();


        $id_male_spawer = 0;
        if (isset($parameters["id_male_spawner"])) {
            $id_male_spawer = $parameters["id_male_spawner"];
        }
        $id_female_spawer = 0;
        if (isset($parameters["id_female_spawner"])) {
            $id_female_spawer = $parameters["id_female_spawner"];
        }

        $sql2 = "INSERT INTO breeding_batches (id_stock_batch, id_space, id_male_spawner, id_female_spawner, id_destination, chipped, comment) VALUES (?,?,?,?,?,?,?) ";
        $this->runRequest($sql2, array(
            $id_stock,
            $parameters["id_space"],
            $id_male_spawer,
            $id_female_spawer,
            $parameters["id_destination"],
            $parameters["chipped"],
            $parameters["comment"]
        ));
        $id = $this->getLastInsertId();

        $parameters["id"] = $id;
        $parameters["id_stock_batch"] = $id_stock;
        return $parameters;
    }

    public function getOne($id_space, $id)
    {

        $sql = "SELECT stock_batches.*, breeding_batches.* ";
        $sql .= "FROM breeding_batches ";
        $sql .= "INNER JOIN stock_batches ON breeding_batches.id_stock_batch = stock_batches.id ";
        $sql .= "WHERE breeding_batches.id=?";

        $req = $this->runRequest($sql, array($id));
        if ($req->rowCount() > 0) {
            return $req->fetch();
        } else {
            return array("error" => "Breeding batch get one empty result for id " . $id);
        }

    }

    public function set($parameters)
    {
        $sql1 = "SELECT id_stock_batch FROM breeding_batches WHERE id=?";
        $id_stock_batch = $this->runRequest($sql1, array($parameters["id"]))->fetch();
        //echo "id stock batch = " . $id_stock_batch[0] . "<br/>";

        $sql = "UPDATE stock_batches SET name=?, created_date=?, initial_quantity=?, id_product=?, origin=? WHERE id=?";
        $this->runRequest($sql, array(
            $parameters["name"],
            $parameters["created_date"],
            $parameters["initial_quantity"],
            $parameters["id_product"],
            "breeding",
            $id_stock_batch[0]
        ));

        $id_male_spawer = 0;
        if (isset($parameters["id_male_spawner"])) {
            $id_male_spawer = $parameters["id_male_spawner"];
        }
        $id_female_spawer = 0;
        if (isset($parameters["id_female_spawner"])) {
            $id_female_spawer = $parameters["id_female_spawner"];
        }

        $sql2 = "UPDATE breeding_batches SET id_space=?, id_male_spawner=?, id_female_spawner=?, id_destination=?, chipped=?, comment=? WHERE id=? ";
        $this->runRequest($sql2, array(
            $parameters["id_space"],
            $id_male_spawer,
            $id_female_spawer,
            $parameters["id_destination"],
            $parameters["chipped"],
            $parameters["comment"],
            $parameters["id"]
        )); 

        //print_r( $parameters );
        return $parameters;
    }

    public function delete($id)
    {

        $sql = "SELECT id_stock_batch FROM breeding_batches WHERE id=?";
        $stockID = $this->runRequest($sql, array($id));

        $sql1 = "DELETE FROM breeding_batches WHERE id=?";
        $this->runRequest($sql1, array($id));

        $sql2 = "DELETE FROM stock_batches WHERE id=?";
        $this->runRequest($sql2, array($stockID[0]));
    }

    public function updateQuantity($id)
    {

        // losse
        $sql = "SELECT * FROM stock_mouvements WHERE id_batch=? AND origin=? AND type=?";
        $losses = $this->runRequest($sql, array($id, "breeding", -1))->fetchAll();
        $quantity_losse = 0;
        foreach ($losses as $l) {
            $quantity_losse += $l["quantity"];
        }

        // sales
        $sql2 = "SELECT * FROM stock_mouvements WHERE id_batch=? AND origin=? AND type=?";
        $salesitems = $this->runRequest($sql2, array($id, "estore", -1))->fetchAll();
        $quantity_sold = 0;
        foreach ($salesitems as $s) {
            $quantity_sold += $s["quantity"];
        }

        // start
        $sql5 = "SELECT id_stock_batch FROM breeding_batches WHERE id=?";
        $id_stock = $this->runRequest($sql5, array($id))->fetch();

        $sql3 = "SELECT sexing_female_num, sexing_male_num FROM breeding_batches WHERE id=?";
        $quantity_startarray = $this->runRequest($sql3, array($id))->fetch();
        $quantity_female = $quantity_startarray[0];
        $quantity_male = $quantity_startarray[1];

        $sql6 = "SELECT initial_quantity FROM stock_batches WHERE id=?";
        $quantity_startarray = $this->runRequest($sql6, array($id_stock[0]))->fetch();

        $quantity_start = $quantity_startarray[0];
        
        // update quantity
        $quantity = $quantity_start - $quantity_losse - $quantity_sold - $quantity_female - $quantity_male;
        $sql4 = "UPDATE breeding_batches SET quantity_sale=?, quantity_losse=? WHERE id=?";
        $this->runRequest($sql4, array($quantity_sold, $quantity_losse, $id));



        $sql6 = "UPDATE stock_batches SET quantity=? WHERE id=?";
        $this->runRequest($sql6, array($quantity, $id_stock[0]));
    }

    public function sexing($id_batch, $parameters)
    {

        // sexing data
        $num_females = $parameters["num_female"];
        $num_males = $parameters["num_male"];

        // create new batchs
        $sql = "SELECT * FROM breeding_batches WHERE id=?";
        $batchInfo = $this->runRequest($sql, array($id_batch))->fetch();

        $sql2 = "SELECT * FROM stock_batches WHERE id=?";
        $stockBatch = $this->runRequest($sql2, array($batchInfo["id_stock_batch"]))->fetch();        

        // female batch
        $femaleBatchData = $this->add(array(
            "name" => $stockBatch["name"] . "f",
            "created_date" => $stockBatch["created_date"],
            "initial_quantity" => $num_females,
            "id_product" => $stockBatch["id_product"],
            "id_space" => $batchInfo["id_space"],
            "id_male_spawner" => $batchInfo["id_male_spawner"],
            "id_female_spawner" => $batchInfo["id_female_spawner"],
            "id_destination" => $batchInfo["id_destination"],
            "chipped" => $batchInfo["chipped"],
            "comment" => $batchInfo["comment"]
        ));
        $this->updateQuantity($femaleBatchData["id"]);

        // male batch
        $maleBatchData = $this->add(array(
            "name" => $stockBatch["name"] . "m",
            "created_date" => $stockBatch["created_date"],
            "initial_quantity" => $num_males,
            "id_product" => $stockBatch["id_product"],
            "id_space" => $batchInfo["id_space"],
            "id_male_spawner" => $batchInfo["id_male_spawner"],
            "id_female_spawner" => $batchInfo["id_female_spawner"],
            "id_destination" => $batchInfo["id_destination"],
            "chipped" => $batchInfo["chipped"],
            "comment" => $batchInfo["comment"]
        ));
        $this->updateQuantity($maleBatchData["id"]);

        // decrease the batch count
        $sql1 = "UPDATE breeding_batches SET sexing_female_num=?, sexing_male_num=?, "
            . "sexing_date=?, sexing_f_batch_id=?, sexing_m_batch_id=? WHERE id=?";
        $this->runRequest($sql1, array(
            $num_females, $num_males,
            date("Y-m-d", time()),
            $femaleBatchData["id"], $maleBatchData["id"], $id_batch
        ));
        $this->updateQuantity($id_batch);

        return array( "femalename" => $stockBatch["name"] . "f", "malename" => $stockBatch["name"] . "m" );
    }

}