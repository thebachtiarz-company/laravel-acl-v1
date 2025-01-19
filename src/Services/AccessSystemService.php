<?php

namespace TheBachtiarz\ACL\Services;

use TheBachtiarz\ACL\DTO\Services\AccessSystemMutationInputDTO;
use TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;
use TheBachtiarz\ACL\Interfaces\Repositories\AccessSystemRepositoryInterface;
use TheBachtiarz\ACL\Interfaces\Services\AccessSystemServiceInterface;
use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Enums\Services\ResponseConditionEnum;
use TheBachtiarz\Base\Enums\Services\ResponseHttpCodeEnum;
use TheBachtiarz\Base\Enums\Services\ResponseStatusEnum;
use TheBachtiarz\Base\Services\AbstractService;
use TheBachtiarz\OAuth\Helpers\AuthTokenHelper;
use TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface;

class AccessSystemService extends AbstractService implements AccessSystemServiceInterface
{
    public function __construct(
        protected AccessSystemRepositoryInterface $accessSystemRepository,
    ) {
        parent::__construct(
            response: new ResponseDataDTO(),
        );
    }

    public function createOrUpdate(AccessSystemMutationInputDTO $input): ResponseDataDTO
    {
        try {
            $user = AuthTokenHelper::currentAuthenticatable();
            assert($user instanceof AuthUserInterface);

            $entity = app(AccessSystemInterface::class);
            $entity->setAddress($input->address);
            $entity->setCreatedBy($user->getIdentifier());

            if ($input->code) {
                $entity = $this->accessSystemRepository->findByCode($input->code);
            } else {
                $entityByAddress = $this->accessSystemRepository->throwIfNullEntity(false)->findByAddress($input->address);

                throw_if($entityByAddress, 'Exception', 'Access with current address already exist.');
            }

            $entity->setName($input->name);
            $entity->setDescription($input->description);
            $entity->setAccess($input->access);

            $process = $this->accessSystemRepository->createOrUpdate($entity);

            $this->setResponse(new ResponseDataDTO(
                condition: ResponseConditionEnum::TRUE,
                status: ResponseStatusEnum::SUCCESS,
                httpCode: ResponseHttpCodeEnum::CREATED,
                message: 'Successfully create or update access system',
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
