<?php

namespace App\Libraries\MyACL\Services;

use App\Libraries\MyACL\DTO\Services\SourceAccessMutationInputDTO;
use App\Libraries\MyACL\Interfaces\Models\SourceAccessInterface;
use App\Libraries\MyACL\Interfaces\Repositories\SourceAccessRepositoryInterface;
use App\Libraries\MyACL\Interfaces\Services\SourceAccessServiceInterface;
use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Enums\Services\ResponseConditionEnum;
use TheBachtiarz\Base\Enums\Services\ResponseHttpCodeEnum;
use TheBachtiarz\Base\Enums\Services\ResponseStatusEnum;
use TheBachtiarz\Base\Services\AbstractService;
use TheBachtiarz\OAuth\Helpers\AuthTokenHelper;
use TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface;

class SourceAccessService extends AbstractService implements SourceAccessServiceInterface
{
    public function __construct(
        protected SourceAccessRepositoryInterface $sourceAccessRepository,
    ) {
        parent::__construct(
            response: new ResponseDataDTO(),
        );
    }

    public function createOrUpdate(SourceAccessMutationInputDTO $input): ResponseDataDTO
    {
        try {
            $user = AuthTokenHelper::currentAuthenticatable();
            assert($user instanceof AuthUserInterface);

            $entity = app(SourceAccessInterface::class);
            $entity->setCreatedBy($user->getIdentifier());

            if ($input->code) {
                $entity = $this->sourceAccessRepository->findByCode($input->code);
            }

            $entity->setName($input->name);
            $entity->setAccess($input->access);

            $process = $this->sourceAccessRepository->createOrUpdate($entity);

            $this->setResponse(new ResponseDataDTO(
                condition: ResponseConditionEnum::TRUE,
                status: ResponseStatusEnum::SUCCESS,
                httpCode: ResponseHttpCodeEnum::CREATED,
                message: 'Successfully create or update source access',
                data: $process->simpleListMap(),
                model: $process,
            ));
        } catch (\Throwable $th) {
            $this->log($th, 'error');

            $this->setResponse(new ResponseDataDTO(
                message: $th->getMessage(),
            ));
        }

        return $this->getResponse();
    }
}
