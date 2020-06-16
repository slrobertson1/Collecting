<?php
namespace Collecting\Permissions\Assertion;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\ResourceInterface;
use Zend\Permissions\Acl\Role\RoleInterface;

/**
 * Does the user have permission to view a collecting item's user email?
 */
class HasUserEmailPermissionAssertion extends AbstractAssertion
{
    public function assert(Acl $acl, RoleInterface $role = null,
        ResourceInterface $resource = null, $privilege = null
    ) {
        if ($this->roleHasPermission($role)) {
            return true;
        }

        return false;
    }
}
