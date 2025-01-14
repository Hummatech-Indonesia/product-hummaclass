<?php

namespace App\Contracts\Repositories\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\JournalPresenceInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\JournalPresence;

class JournalPresenceRepository extends BaseRepository implements JournalPresenceInterface
{
    public function __construct(JournalPresence $journalPresence)
    {
        $this->model = $journalPresence;
    }

    /**
     * Method store
     *
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }
    
    /**
     * Method update
     *
     * @param mixed $id [explicite description]
     * @param array $data [explicite description]
     *
     * @return mixed
     */
    public function update(mixed $journal_id, mixed $student_classroom_id, array $data): mixed
    {
        return $this->model->query()->where('journal_id', $journal_id)->where('student_classroom_id', $student_classroom_id)->update($data);
    }
    /**
     * Method delete
     *
     * @param mixed $id [explicite description]
     *
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        //  return $this->show($id)->delete();
        return 0;
    }
}
