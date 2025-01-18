<?php

namespace App\Libraries\MyACL\Services;

use App\Libraries\MyACL\DTO\Services\AccessManagerMutationInputDTO;
use App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface;
use App\Libraries\MyACL\Interfaces\Repositories\AccessManagerRepositoryInterface;
use App\Libraries\MyACL\Interfaces\Services\AccessManagerServiceInterface;
use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Enums\Services\ResponseConditionEnum;
use TheBachtiarz\Base\Enums\Services\ResponseHttpCodeEnum;
use TheBachtiarz\Base\Enums\Services\ResponseStatusEnum;
use TheBachtiarz\Base\Services\AbstractService;
use TheBachtiarz\OAuth\Helpers\AuthTokenHelper;
use TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface;

class AccessManagerService extends AbstractService implements AccessManagerServiceInterface
{
    public function __construct(
        protected AccessManagerRepositoryInterface $accessManagerRepository,
    ) {
        parent::__construct(
            response: new ResponseDataDTO(),
        );
    }

    public function createOrUpdate(AccessManagerMutationInputDTO $input): ResponseDataDTO
    {
        try {
            $user = AuthTokenHelper::currentAuthenticatable();
            assert($user instanceof AuthUserInterface);

            $entity = app(AccessManagerInterface::class);
            $entity->setSourceAccessId($input->sourceId);
            $entity->setCreatedBy($user->getIdentifier());

            if ($input->code) {
                $entity = $this->accessManagerRepository->findByCode($input->code);
            }

            $entity->setName($input->name);
            $entity->setAccess($input->access);

            $process = $this->accessManagerRepository->createOrUpdate($entity);

            $this->setResponse(new ResponseDataDTO(
                condition: ResponseConditionEnum::TRUE,
                status: ResponseStatusEnum::SUCCESS,
                httpCode: ResponseHttpCodeEnum::CREATED,
                message: 'Successfully create or update access manager',
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
