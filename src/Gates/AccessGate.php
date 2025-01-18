<?php

namespace App\Libraries\MyACL\Gates;

use App\Libraries\MyACL\Interfaces\Models\AccessManagerInterface;
use App\Libraries\MyACL\Interfaces\Models\UserAccessInterface;
use App\Libraries\MyACL\Interfaces\Repositories\AccessSystemRepositoryInterface;
use App\Libraries\MyACL\Interfaces\Repositories\UserAccessRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use TheBachtiarz\Admin\Helpers\Model\AuthUserModelHelper;
use TheBachtiarz\OAuth\Interfaces\Models\AuthUserInterface;

class AccessGate
{
    /**
     * Gate status condition
     */
    protected static bool $status = true;

    /**
     * Defined user
     */
    protected static ?AuthUserInterface $user = null;

    /**
     * User access collection
     *
     * @var Collection<\App\Libraries\MyACL\Interfaces\Models\UserAccessInterface>
     */
    protected static Collection $userAccessCollection;

    /**
     * No header access message
     */
    protected static string $noHeaderAccess = 'Access Denied';

    /**
     * No mutator access message
     */
    protected static string $noMutatorAccess = 'Unauthorized';

    // ? Public Methods

    /**
     * Gate process
     *
     * @param string $methodLocation Use magic "__METHOD__" constant variable
     *
     * @throws AuthenticationException
     * @throws AuthorizationException
     */
    public static function can(string $methodLocation = ''): void
    {
        if (!static::$status) {
            return;
        }

        static::userAuthorize();

        if (in_array(static::$user->getIdentifier(), AuthUserModelHelper::getAdminList())) {
            return;
        }

        $access = app(AccessSystemRepositoryInterface::class)->findAddressOrCreate($methodLocation)->getAccess() ?? [];

        if (count($access) == 0) {
            return;
        }

        static::manageBeforeProcess();

        static::defineUserAccessCollection();

        static::manageBetweenProcess();

        static::authorizationProcess(requestedAccess: $access);

        static::manageAfterProcess();
    }

    /**
     * Check if user can access
     *
     * @param string $methodLocation Use magic "__METHOD__" constant variable
     */
    public static function check(string $methodLocation = ''): bool
    {
        try {
            static::can($methodLocation);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Enable Access gate
     */
    public static function enable(): static
    {
        static::$status = true;

        return new static();
    }

    /**
     * Disable Access gate
     */
    public static function disable(): static
    {
        static::$status = false;

        return new static();
    }

    // ? Protected Methods

    /**
     * Define user access collection
     */
    protected static function defineUserAccessCollection(): void
    {
        static::$userAccessCollection = app(UserAccessRepositoryInterface::class)->getBelongsToUser(static::$user);
    }

    /**
     * Authorization process
     */
    protected static function authorizationProcess(array $requestedAccess): void
    {
        $decodedAccessList = static::decodeAccessEntity();

        foreach ($requestedAccess as $key => $acc) {
            [$h, $m] = explode(separator: ':', string: $acc);

            $acm = @$decodedAccessList[$h] ?? [];

            if (count($acm) == 0) {
                throw new AuthorizationException(static::$noHeaderAccess);
            }

            if (!in_array($m, $acm)) {
                throw new AuthorizationException(static::$noMutatorAccess);
            }
        }
    }

    /**
     * Do something before process
     */
    protected static function manageBeforeProcess(): void {}

    /**
     * Do something between process
     */
    protected static function manageBetweenProcess(): void {}

    /**
     * Do something after process
     */
    protected static function manageAfterProcess(): void {}

    // ? Private Methods

    /**
     * User authorize
     */
    private static function userAuthorize(): void
    {
        static::$user ??= Auth::hasUser() ? Auth::user() : null;

        if (!static::$user) {
            throw new AuthenticationException();
        }
    }

    /**
     * Decode current Access entity
     */
    private static function decodeAccessEntity(): array
    {
        $abilities = [];

        foreach (static::$userAccessCollection as $uac => $userAccess) {
            assert($userAccess instanceof UserAccessInterface);

            $accessManager = $userAccess->accessManager()->get()->first();
            assert($accessManager instanceof AccessManagerInterface);

            foreach ($accessManager->getAccess() ?? [] as $acm => $access) {
                [$header, $mutator] = explode(separator: ':', string: $access);

                $abilities[$header][] = $mutator;
            }
        }

        return $abilities;
    }

    // ? Getter Modules

    // ? Setter Modules

    /**
     * Set defined user
     */
    public static function setUser(AuthUserInterface $user): static
    {
        static::$user = $user;

        return new static();
    }
}
