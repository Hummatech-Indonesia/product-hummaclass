<?php

namespace App\Contracts\Repositories\Configuration;

use App\Contracts\Interfaces\Configuration\PrivacyPolicyInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\PrivacyPolicy;

class PrivacyPolicyRepository  extends BaseRepository implements PrivacyPolicyInterface
{
    public function __construct(PrivacyPolicy $privacyPolicy)
    {
        $this->model = $privacyPolicy;
    }

    /**
     * Method show
     *
     * @return mixed
     */
    public function show(): mixed
    {
        return $this->model->firstOrFail();
    }
    /**
     * Method update
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(array $data): mixed
    {
        return $this->show()->update($data);
    }
}
