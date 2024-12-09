<?php

namespace App\Services\IndustryClass;

use App\Contracts\Interfaces\IndustryClass\JournalPresenceInterface;
use App\Enums\PresenceEnum;
use App\Enums\UploadDiskEnum;
use App\Http\Requests\JournalPresentRequest;
use App\Http\Requests\JournalRequest;
use App\Http\Requests\JournalUpdateRequest;
use App\Models\Journal;
use App\Traits\UploadTrait;

class JournalPresenceService
{
    private JournalPresenceInterface $journalPresence;

    public function __construct(JournalPresenceInterface $journalPresence)
    {
        $this->journalPresence = $journalPresence;
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function store($journal_presence, Journal $journal): void
    {
        foreach ($journal_presence as $key => $value) {
            $data['journal_id'] = $journal->id;
            $data['student_classroom_id'] = $key;
            $data['status'] = $value == 'present' ? PresenceEnum::PRESENT->value : ($value == 'permit' ? PresenceEnum::PERMIT->value : ($value == 'sick' ? PresenceEnum::SICK->value : ($value == 'alpha' ? PresenceEnum::ALPHA->value : '')));
            $this->journalPresence->store($data);
        }
    }

        /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function update($journal_presence, Journal $journal): void
    {
        foreach ($journal_presence as $key => $value) {
            $data['status'] = $value == 'present' ? PresenceEnum::PRESENT->value : ($value == 'permit' ? PresenceEnum::PERMIT->value : ($value == 'sick' ? PresenceEnum::SICK->value : ($value == 'alpha' ? PresenceEnum::ALPHA->value : '')));
            $this->journalPresence->update($journal->id, $key, $data);
        }
    }
}
