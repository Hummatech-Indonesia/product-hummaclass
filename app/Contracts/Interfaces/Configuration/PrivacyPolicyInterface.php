<?php

namespace App\Contracts\Interfaces\Configuration;

interface PrivacyPolicyInterface
{
    /**
     * Method show
     *
     * @return mixed
     */
    public function show(): mixed;
    /**
     * Method update
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(array $data): mixed;
}
