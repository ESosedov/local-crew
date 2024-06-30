<?php

namespace App\Model\User\Factory;

use App\Entity\EventRequest;
use App\Model\User\CandidateModel;
use Doctrine\Common\Collections\Collection;

class CandidateModelFactory
{
    public function __construct(private UserPublicModelFactory $userPublicModelFactory)
    {
    }

    public function fromEventRequest(EventRequest $eventRequest): CandidateModel
    {
        $userModel = $this->userPublicModelFactory->fromUser($eventRequest->getCreatedBy());

        return new CandidateModel(
            $userModel,
            $eventRequest->getId(),
        );
    }

    /**
     * @param EventRequest[]|Collection $eventRequests
     *
     * @return CandidateModel[]
     */
    public function fromEventRequests(array|Collection $eventRequests): array
    {
        $result = [];
        foreach ($eventRequests as $eventRequest) {
            $result[] = $this->fromEventRequest($eventRequest);
        }

        return $result;
    }
}
