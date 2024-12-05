<?php

namespace App\Services\IndustryClass;

use App\Enums\UploadDiskEnum;
use App\Http\Requests\JournalRequest;
use App\Http\Requests\JournalUpdateRequest;
use App\Models\Journal;
use App\Traits\UploadTrait;

class JournalService
{
    use UploadTrait;

    /**
     * store
     *
     * @param  mixed $request
     * @return array
     */
    public function store(JournalRequest $request): array|bool
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload(UploadDiskEnum::JOURNAL->value, $request->file('image'));
        }

        return $data;
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $school
     * @return array
     */
    public function update(JournalUpdateRequest $request, Journal $journal): array|bool
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $this->remove($journal->image);
            $data['image'] = $this->upload(UploadDiskEnum::JOURNAL->value, $request->file('image'));
        } else {
            $data['image'] = $journal->image;
        }

        return $data;
    }

    public function delete(Journal $journal): void
    {
        $this->remove($journal->image);
    }
}
