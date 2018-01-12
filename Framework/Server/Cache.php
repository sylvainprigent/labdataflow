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
                        $routingFile = "Modules/" . $moduleName . "/ServerRoutes.json";
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
                //echo "add routes module:" . $moduleName . "<br/>";
                $routes = json_decode(\file_get_contents($routingFile));
                foreach ($routes as $rout) {

                        $routeArray = json_decode(json_encode($rout), true);

                        $identifier = $routeArray["identifier"];
                        $requestType = $routeArray["request"];
                        $path = $routeArray["path"];
                        $route = $routeArray["route"];
                        $action = $routeArray["action"];

                        $pathRegex = $path;
                        if (isset($routeArray["gets"])) {
                                foreach ($routeArray["gets"] as $get) {
                                        $pathRegex = \str_replace($get["name"], $get["regex"], $pathRegex);
                                }
                        }

                        $this->setCacheUrl($identifier, $requestType, $path, $pathRegex, $moduleName, $route, $action);
                }
        }

        protected function setCacheUrl($identifier, $requestType, $path, $pathRegex, $module, $route, $action)
        {
                $id = $this->getChacheUrlID($identifier);
                //echo 'id = ' . $id . "<br/>";
                if ($id > 0) {
                    //echo "update cache_urls begin <br/>";
                        $sql = "UPDATE cache_api_urls SET identifier=?, request=?, path=?, pathregex=?, module=?, route=?, action=? WHERE id=?";
                        $this->runRequest($sql, array($identifier, $requestType, $path, $pathRegex, $module, $route, $action, $id));
                    //echo "update cache_urls end <br/>";
                } else {
                    //echo "insert cache_urls begin <br/>";
                        $sql = "INSERT INTO cache_api_urls (identifier, request, path, pathregex, module, route, action) VALUES (?,?,?,?,?,?,?) ";
                        $this->runRequest($sql, array($identifier, $requestType, $path, $pathRegex, $module, $route, $action));
                        $id = $this->getDatabase()->lastInsertId();
                    //echo "insert cache_urls end <br/>";
                }
                return $id;
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
                $sql = "TRUNCATE TABLE cache_api_urls";
                $this->runRequest($sql);
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
                        `pathregex` varchar(255) NOT NULL DEFAULT '',
                        `module` varchar(255) NOT NULL DEFAULT '',
                        `route` varchar(255) NOT NULL DEFAULT '',
                        `action` varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
                );";

                $this->runRequest($sql);
        }

        /**
         * get the information of a route from it path
         * @param type $path
         * @return type
         */
        public function getURLInfos($requestType, $path)
        {
                $sql = "SELECT * FROM cache_api_urls WHERE pathregex=? AND request=?";
                $urlInfo = $this->runRequest($sql, array($path, $requestType))->fetch();
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
