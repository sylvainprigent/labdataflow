<?php
namespace Mumux\Server;

class Cache
{

        protected static $bdd;

        /**
         * Load the urls into the cach table
         * Call this function to generate the cache
         */
        public function load()
        {
        // URLS
                $this->createTableURL();
                $this->loadUrls();
        }

        /**
         * Implement the URL loading
         */
        public function loadUrls()
        {
        
                // get the modules list
                $modulesNames = \Mumux\Configuration::get("Modules");
        
                // load each modules
                foreach ($modulesNames as $moduleName) {
        
                    // get the routing class
                        $routingFile = "Modules/" . $moduleName . "/" . ucfirst($moduleName) . "ServerRouting.php";
                        if (file_exists($routingFile)) {
                                $this->addRoutsToDatabase($moduleName, $routingFile);
                        } else {
                                throw new \Exception("The module '$moduleName' has a no routing file");
                        }
                }
        }

        /**
         * Get all the route information to add it to the database
         * @param type $moduleName Name of the module
         * @param type $routingClassUrl url of the controller
         */
        protected function addRoutsToDatabase($moduleName, $routingFile)
        {

                //require($routingFile);
                $className = "\\Modules\\" . ucfirst($moduleName) . "\\" . ucfirst($moduleName) . "ServerRouting";

                $routingClass = new $className();
                $routingClass->listRouts();
                for ($r = 0; $r < $routingClass->count(); $r++) {
                        $identifier = $routingClass->getIdentifier($r);
                        $requestType = $routingClass->getRequestType($r);
                        $path = $routingClass->getPath($r);
                        $route = $routingClass->getRoute($r);
                        $actions = $routingClass->getAction($r);
                        $gets = $routingClass->getGet($r);
                        $getsRegexp = $routingClass->getGetRegexp($r);

                        $this->setCacheUrl($identifier, $requestType, $path, $moduleName, $route, $actions, $gets, $getsRegexp);

                }
        }

        protected function setCacheUrl($identifier, $requestType, $path, $module, $route, $actions, $gets, $getsRegexp)
        {
        
                // insert the urls
                $id = $this->setCacheUrlDB($identifier, $requestType, $path, $module, $route, $actions, count($gets));
        
                // instert the gets
                for ($g = 0; $g < count($gets); $g++) {
                        $this->setCacheUrlGetDB($id, $gets[$g], $getsRegexp[$g]);
                }
        }

        /**
         * Request to add a route to the database
         * @param type $identifier
         * @param type $url
         * @param type $module
         * @param type $controller
         * @param type $action
         * @return type
         */
        protected function setCacheUrlDB($identifier, $requestType, $path, $module, $route, $action, $argsnum)
        {
                
                //echo "identifier = " . $identifier . "<br/>";
                //echo "isApi = " . $isApi . "<br/>";

                $id = $this->getChacheUrlID($identifier);
                //echo 'id = ' . $id . "<br/>";
                if ($id > 0) {
                    //echo "update cache_urls begin <br/>";
                        $sql = "UPDATE cache_api_urls SET identifier=?, request=?, path=?, module=?, route=?, action=?, argsnum=? WHERE id=?";
                        $this->runRequest($sql, array($identifier, $requestType, $path, $module, $route, $action, $argsnum, $id));
                    //echo "update cache_urls end <br/>";
                } else {
                    //echo "insert cache_urls begin <br/>";
                        $sql = "INSERT INTO cache_api_urls (identifier, request, path, module, route, action, argsnum) VALUES(?,?,?,?,?,?,?) ";
                        $this->runRequest($sql, array($identifier, $requestType, $path, $module, $route, $action, $argsnum));
                        $id = $this->getDatabase()->lastInsertId();
                    //echo "insert cache_urls end <br/>";
                }
                return $id;
        }

        /**
         * Request to add a route get parameters to the database
         * @param type $id_url
         * @param type $name
         * @param type $regexp
         * @return type
         */
        protected function setCacheUrlGetDB($id_url, $name, $regexp)
        {
        
                //echo "name = " . $name; echo "<br/>";
                //echo "regexp = " . $regexp; echo "<br/>";
                //echo "id_url = " . $id_url; echo "<br/>";

                $id = $this->getChacheUrlGetID($id_url, $name);
                //echo "id = "; print_r($id); echo "<br/>";
                if ($id > 0) {
                    //echo "UPDATE cache_urls_gets begin <br/>";
                        $sql = "UPDATE cache_api_urls_gets SET `url_id`=?, `name`=?, `regexp`=? WHERE id=?";
                        $this->runRequest($sql, array($id_url, $name, $regexp, $id));
                    //echo "UPDATE cache_urls_gets end <br/>";
                } else {
                    //echo "INSERT cache_urls_gets begin <br/>";
                        $sql = "INSERT INTO cache_api_urls_gets (`url_id`, `name`, `regexp`) VALUES(?,?,?) ";
                        $this->runRequest($sql, array($id_url, $name, $regexp));
                        $id = $this->getDatabase()->lastInsertId();
                    //echo "INSERT cache_urls_gets end <br/>";
                }
                return $id;
        }

        /**
         * get a get parameter cache route id
         * @param type $id_url
         * @param type $name
         * @return boolean
         */
        protected function getChacheUrlGetID($id_url, $name)
        {
                $sql = "SELECT id FROM cache_api_urls_gets WHERE url_id=? AND name=?";
                $req = $this->runRequest($sql, array($id_url, $name));
                if ($req->rowCount() == 1) {
                        $tmp = $req->fetch();
                        return $tmp[0];
                }
                return false;
        }

        /**
         * get a get parameter cache route id
         * @param type $identifier
         * @return boolean
         */
        protected function getChacheUrlID($identifier)
        {
                $sql = "SELECT id FROM cache_api_urls WHERE identifier=?";
                $req = $this->runRequest($sql, array($identifier));
                if ($req->rowCount() == 1) {
                        $tmp = $req->fetch();
                        return $tmp[0];
                }
                return false;
        }

        /**
         * Remove all the cache
         */
        protected function freeTableURL()
        {
        
                //if ($this->isTable("cache_urls")){
                $sql = "TRUNCATE TABLE cache_api_urls";
                $this->runRequest($sql);
                //}
                //if ($this->isTable("cache_urls_gets")){
                $sqlg = "TRUNCATE TABLE cache_api_urls_gets";
                $this->runRequest($sqlg);
                //}
        }

        /**
         * Create the cache tables
         */
        protected function createTableURL()
        {
                $sql = "CREATE TABLE IF NOT EXISTS `cache_api_urls` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `identifier` varchar(255) NOT NULL DEFAULT '',
                        `request` varchar(255) NOT NULL DEFAULT '',
                        `path` varchar(255) NOT NULL DEFAULT '',
                        `module` varchar(255) NOT NULL DEFAULT '',
                        `route` varchar(255) NOT NULL DEFAULT '',
                        `action` varchar(255) NOT NULL DEFAULT '',
                        `argsnum` int(11) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`)
                );";

                $this->runRequest($sql);


                $sqlg = "CREATE TABLE IF NOT EXISTS `cache_api_urls_gets` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `url_id` int(11) NOT NULL,
                        `name` varchar(255) NOT NULL DEFAULT '',
                        `regexp` varchar(255) NOT NULL DEFAULT '',	
                PRIMARY KEY (`id`)
                );";

                $this->runRequest($sqlg);
        }

        /**
         * get the information of a route from it path
         * @param type $path
         * @return type
         */
        public function getURLInfos($requestType, $path, $argsNum)
        {
                $sql = "SELECT * FROM cache_api_urls WHERE path=? AND request=? AND argsnum=?";
                $urlInfo = $this->runRequest($sql, array($path, $requestType, $argsNum))->fetch();

                $sqlg = "SELECT * FROM cache_api_urls_gets WHERE url_id=?";
                $urlInfo["gets"] = $this->runRequest($sqlg, array($urlInfo["id"]))->fetchAll();

                return $urlInfo;
        }

        protected function runRequest($request, $params = null)
        {
                if ($params == null) {
                        $result = self::getDatabase()->query($request);
                } else {
                        $result = self::getDatabase()->prepare($request);

                        $result->execute($params);
                }
                return $result;
        }

        /**
         * Return an object that connect the database and initialize the connection if needed
         * 
         * @return PDO Objet PDO of the database connections
         */
        protected static function getDatabase()
        {
                if (self::$bdd === null) {
            // load the database informations
                        $dsn = \Mumux\Configuration::get("dsn");
                        $login = \Mumux\Configuration::get("login");
                        $pwd = \Mumux\Configuration::get("pwd");

            // Create connection
                        self::$bdd = new \PDO($dsn, $login, $pwd, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
                        self::$bdd->exec("SET CHARACTER SET utf8");
                }
                return self::$bdd;
        }

        /**
         * 
         * @param type $tableName
         * @param type $columnName
         * @param type $columnType
         * @param type $defaultValue
         */
        public function addColumn($tableName, $columnName, $columnType, $defaultValue)
        {

                $sql = "SHOW COLUMNS FROM `" . $tableName . "` LIKE '" . $columnName . "'";
                $pdo = $this->runRequest($sql);
                $isColumn = $pdo->fetch();
                if ($isColumn == false) {
                        $sql = "ALTER TABLE `" . $tableName . "` ADD `" . $columnName . "` " . $columnType . " NOT NULL DEFAULT '" . $defaultValue . "'";
                        $pdo = $this->runRequest($sql);
                }
        }
}
