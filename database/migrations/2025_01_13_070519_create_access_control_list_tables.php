<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TheBachtiarz\ACL\Interfaces\Models\AccessManagerInterface;
use TheBachtiarz\ACL\Interfaces\Models\AccessSystemInterface;
use TheBachtiarz\ACL\Interfaces\Models\SourceAccessInterface;
use TheBachtiarz\ACL\Interfaces\Models\UserAccessInterface;
use TheBachtiarz\ACL\Models\AccessManager;
use TheBachtiarz\ACL\Models\SourceAccess;
use TheBachtiarz\OAuth\Models\AuthUser;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(SourceAccessInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(SourceAccessInterface::ATTRIBUTE_CODE)->unique();
            $table->string(SourceAccessInterface::ATTRIBUTE_NAME);
            $table->json(SourceAccessInterface::ATTRIBUTE_ACCESS);
            $table->string(SourceAccessInterface::ATTRIBUTE_CREATED_BY);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create(AccessManagerInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SourceAccess::class, column: AccessManagerInterface::ATTRIBUTE_SOURCE_ACCESS_ID)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string(AccessManagerInterface::ATTRIBUTE_CODE)->unique();
            $table->string(AccessManagerInterface::ATTRIBUTE_NAME);
            $table->json(AccessManagerInterface::ATTRIBUTE_ACCESS);
            $table->string(AccessManagerInterface::ATTRIBUTE_CREATED_BY);
            $table->timestamps();
        });

        Schema::create(UserAccessInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AuthUser::class, column: UserAccessInterface::ATTRIBUTE_USER_ID)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(SourceAccess::class, column: UserAccessInterface::ATTRIBUTE_SOURCE_ACCESS_ID)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(AccessManager::class, column: UserAccessInterface::ATTRIBUTE_ACCESS_MANAGER_ID)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string(UserAccessInterface::ATTRIBUTE_GRANTED_BY);
            $table->timestamps();
        });

        Schema::create(AccessSystemInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(AccessSystemInterface::ATTRIBUTE_CODE)->unique();
            $table->string(AccessSystemInterface::ATTRIBUTE_ADDRESS)->unique();
            $table->string(AccessSystemInterface::ATTRIBUTE_NAME);
            $table->string(AccessSystemInterface::ATTRIBUTE_DESCRIPTION)->nullable();
            $table->json(AccessSystemInterface::ATTRIBUTE_ACCESS);
            $table->string(AccessSystemInterface::ATTRIBUTE_CREATED_BY);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(AccessSystemInterface::TABLE_NAME);
        Schema::dropIfExists(UserAccessInterface::TABLE_NAME);
        Schema::dropIfExists(AccessManagerInterface::TABLE_NAME);
        Schema::dropIfExists(SourceAccessInterface::TABLE_NAME);
    }
};
