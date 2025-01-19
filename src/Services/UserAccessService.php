<?php

namespace TheBachtiarz\ACL\Services;

use TheBachtiarz\ACL\DTO\Services\UserAccessMutationInputDTO;
use TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface;
use TheBachtiarz\ACL\Interfaces\Repositories\UserAccessRepositoryInterface;
use TheBachtiarz\ACL\Interfaces\Services\UserAccessServiceInterface;
use TheBachtiarz\Base\DTOs\Services\ResponseDataDTO;
use TheBachtiarz\Base\Enums\Services\ResponseConditionEnum;
use TheBachtiarz\Base\Enums\Services\ResponseHttpCodeEnum;
use TheBachtiarz\Base\Enums\Services\ResponseStatusEnum;
use TheBachtiarz\Base\Services\AbstractService;
use TheBachtiarz\OAuth\Helpers\AuthTokenHelper;
use TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface;

class UserAccessService extends AbstractService implements UserAccessServiceInterface
{
    public function __construct(
        protected UserAccessRepositoryInterface $userAccessRepository,
    ) {
        parent::__construct(
            response: new ResponseDataDTO(),
        );
    }

    public function createOrReplace(UserAccessMutationInputDTO $input): ResponseDataDTO
    {
        try {
            $user = AuthTokenHelper::currentAuthenticatable();
            assert($user instanceof AuthUserInterface);

            $builder = app(UserAccessInterface::class)::{'query'}();
            assert($builder instanceof \Illuminate\Database\Eloquent\Builder);

            $builder->where(column: UserAccessInterface::ATTRIBUTE_USER_ID, operator: '=', value: $input->userId);
            $builder->where(column: UserAccessInterface::ATTRIBUTE_SOURCE_ACCESS_ID, operator: '=', value: $input->sourceAccessId);
            $builder->where(column: UserAccessInterface::ATTRIBUTE_ACCESS_MANAGER_ID, operator: '=', value: $input->accessManagerId);
            $builder->delete();

            $entity = app(UserAccessInterface::class);
            $entity->setUserId($input->userId);
            $entity->setSourceAccessId($input->sourceAccessId);
            $entity->setAccessManagerId($input->accessManagerId);
            $entity->setGrantedBy($user->getIdentifier());

            $process = $this->userAccessRepository->createOrUpdate($entity);

            $this->setResponse(new ResponseDataDTO(
                condition: ResponseConditionEnum::TRUE,
                status: ResponseStatusEnum::SUCCESS,
                httpCode: ResponseHttpCodeEnum::CREATED,
                message: 'Successfully create or update user access',
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
