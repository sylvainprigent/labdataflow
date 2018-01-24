<?php
namespace Mumux\Client;

use Mumux\Configuration;


class I18n
{

    protected $lang;
    protected $translations;

    public function __construct($language = "")
    {

        // get the user language
        if ($language != ""){
            $this->lang = $language;
        }
        else{
            $this->lang = "en";
            $supportedLangs = \Mumux\Configuration::get("languages");
            $clientLanguages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            foreach ($clientLanguages as $lang) {
                if (in_array($lang, $supportedLangs)) {
                    $this->lang = $lang;
                    break;
                }
            }
        }
        
        


        // get all the trasnlations
        $modules = \Mumux\Configuration::get("Modules");
        $this->translations = array();
        foreach ($modules as $module) {
            $trFile = "Modules/" . \ucfirst($module) . "/Clienti18n/i18n." . $this->lang . ".json";
            if (\file_exists($trFile)) {
                $this->translations[\strtolower($module)] = \json_decode(\file_get_contents($trFile), true);
            }
        }
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function tr($identifier)
    {
        $identifierArray = explode(".", $identifier);
        if (count($identifierArray) >= 3) {
            $module = $identifierArray[1];
            $char = $identifierArray[2];
            if (isset($this->translations[$module][$char])) {
                return $this->translations[$module][$char];
            }
        }
        return $identifier;
    }

    public function translate($page)
    {

        $identifiers = $this->getAlli18nIdentifiers($page);
        foreach ($identifiers as $identifier) {
            $identifierArray = explode(".", $identifier);
            if (count($identifierArray) >= 3) {
                $module = $identifierArray[1];
                $char = $identifierArray[2];
                if (isset($this->translations[$module][$char])) {
                    $page = str_replace($identifier, $this->translations[$module][$char], $page);
                }
            }
        }
        return $page;
    }

    protected function getAlli18nIdentifiers($page)
    {

        $fnd = array();

        $positions = $this->getAlli18n($page);
        foreach ($positions as $pos) {

            $offset = 0;
            $found = false;
            while (!$found) {

                $char = substr($page, $pos + 5 + $offset, 1);
                if ($char == '"' || $char == ' ' || $char == ">" || $char == "<" || $char == "'"  || $char == ":" || $char == "," || $offset > 255) {
                    $found = true;
                }
                $offset++;
            }
            $fnd[] = substr($page, $pos, 4 + $offset);

        }
        return $fnd;
    }

    protected function getAlli18n($haystack)
    {
        $needle = "i18n.";
        $fnd = array();
        $pos = 0;

        while ($pos <= strlen($haystack)) {
            $pos = strpos($haystack, $needle, $pos);
            if ($pos > -1) {
                $fnd[] = $pos++;
                continue;
            }
            break;
        }
        return $fnd;
    }

}