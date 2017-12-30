<?php 
namespace Mumux\Server;

/**
 * Class defining a request.
 *
 * @author Sylvain Prigent
 */
class Request
{
    /**
     * String containing the request type (get, post, put, Delete...)
     */
    private $type;
    /**
     * Table containg the request parameters
     */
    private $parameters;

    private $headers;

    /**
     * Constructor
     *
     * @param array $parameters
     *        	Parameters of the request
     */
    public function __construct($type, $parameters)
    {
        $this->type = $type;
        $this->parameters = $parameters;

        $this->headers = \getallheaders();
    }

    public function getType(){
        return $this->type;
    }

    /**
     * Return true if a parameter exists in the request and is not empty
     *
     * @param string $name
     *        	Name of the parameter
     * @return bool True if the parameter exists and is not empty
     */
    public function isParameterNotEmpty($name)
    {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

    /**
     * Return true if a parameter exists in the request
     *
     * @param string $name
     *        	Name of the parameter
     * @return bool True if the parameter exists and is not empty
     */
    public function isParameter($name)
    {
        return (isset($this->parameters[$name]));
    }

    /**
     * Return the value of a parameter
     *
     * @param string $name
     *        	Name of the parameter
     * @return string Value of the parameter
     * @throws Exception If the parameter does not exist in the request
     */
    public function getParameter($name, $clean = true)
    {
        if ($this->isParameter($name)) {
            if ($clean) {
                return $this->clean($this->parameters[$name]);
            } else {
                return $this->parameters[$name];
            }
        } else {
            throw new \Exception("Parameter '$name' is not in the request");
        }
    }

    public function getParameters(){
        return $this->parameters;
    }

    public function getHeader($name){

        if (isset($this->headers[$name])){
            return $this->headers[$name];
        }
        return false;
    }

    /**
     * Return the value of a parameter
     *
     * @param string $name
     *        	Name of the parameter
     * @return string Value of the parameter, or en empty string if the parameter is not set
     */
    public function getParameterNoException($name, $clean = true)
    {
        if ($this->isParameter($name)) {
            if ($clean) {
                return $this->clean($this->parameters[$name]);
            } else {
                return $this->parameters[$name];
            }
        } else {
            return '';
        }
    }

    /**
     * Return a parameter after cleaning html characters
     * @param string $value 
     *  Value of the parameter to clean
     * @return string Cleaned parameter
     */
    public function clean($value)
    {
        if (is_array($value)) {
            return $value;
        }
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }


}