<?php
namespace Mumux\Client;

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
                        $routingFile = "Modules/" . $moduleName . "/ClientRoutes.json";
                        if (file_exists($routingFile)) {
                                $this->addRoutsToDatabase($moduleName, $routingFile);
                        } else {
                                throw new \Exception("The module '$moduleName' has a no client routing file");
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

                $routes = \json_decode(\file_get_contents($routingFile));
                if (is_array($routes)) {
                        foreach ($routes as $route) {

                                $routeArray = json_decode(json_encode($route), true);

                                $identifier = $routeArray["identifier"];
                                $path = $routeArray["path"];
                                $component = $routeArray["component"];
                                $layout = $routeArray["layout"];

                                $this->setCacheUrl($identifier, $path, $component, $layout, $moduleName);
                        }
                }
        }

        protected function setCacheUrl($identifier, $path, $component, $layout, $moduleName)
        {
                $id = $this->getChacheUrlID($identifier);
                //echo 'id = ' . $id . "<br/>";
                if ($id > 0) {
                    //echo "update cache_urls begin <br/>";
                        $sql = "UPDATE cache_client_urls SET identifier=?, path=?, component=?, layout=?, module=? WHERE id=?";
                        $this->runRequest($sql, array($identifier, $path, $component, $layout, $moduleName, $id));
                    //echo "update cache_urls end <br/>";
                } else {
                    //echo "insert cache_urls begin <br/>";
                        $sql = "INSERT INTO cache_client_urls (identifier, path, component, layout, module) VALUES(?,?,?,?,?) ";
                        $this->runRequest($sql, array($identifier, $path, $component, $layout, $moduleName));
                        $id = $this->getDatabase()->lastInsertId();
                    //echo "insert cache_urls end <br/>";
                }
                return $id;
        }

        public function getRouteInfo($path)
        {
                $sql = "SELECT * FROM cache_client_urls WHERE path=?";
                return $this->runRequest($sql, array($path))->fetch();
        }

        /**
         * get a get parameter cache route id
         * @param type $identifier
         * @return boolean
         */
        protected function getChacheUrlID($identifier)
        {
                $sql = "SELECT id FROM cache_client_urls WHERE identifier=?";
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
                $sql = "TRUNCATE TABLE cache_client_urls";
                $this->runRequest($sql);
        }

        /**
         * Create the cache tables
         */
        protected function createTableURL()
        {
                $sql = "CREATE TABLE IF NOT EXISTS `cache_client_urls` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `identifier` varchar(255) NOT NULL DEFAULT '',
                        `path` varchar(255) NOT NULL DEFAULT '',
                        `component` varchar(255) NOT NULL DEFAULT '',
                        `layout` varchar(255) NOT NULL DEFAULT '',
                        `module` varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
                );";

                $this->runRequest($sql);
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

}
