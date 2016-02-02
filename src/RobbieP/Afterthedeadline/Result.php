<?php

namespace RobbieP\Afterthedeadline;

use RobbieP\Afterthedeadline\Error\ErrorBag;

class Result
{
    protected $errorBag = [];
    protected $resultArray = [];

    /**
     * Result constructor.
     *
     * @param $results
     */
    public function __construct($results)
    {
        if (isset($results['error']) && !empty($results['error'])) {
            if (!isset($results['error']['type'])) {
                foreach ($results['error'] as $result) {
                    $this->addError($result);
                }
            } else {
                $this->addError($results['error']);
            }
        }
    }

    /**
     * @param $result
     */
    private function addError($result)
    {
        $this->errorBag[] = ErrorBag::get($result['type'], $result);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if (!empty($this->errorBag)) {
            foreach ($this->errorBag as $k => $error) {
                $this->resultArray[] = $error;
            }

            return $this->resultArray;
        }
    }
}
