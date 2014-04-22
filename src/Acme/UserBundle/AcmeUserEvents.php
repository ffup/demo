<?php

namespace Acme\UserBundle;

/**
 * Contains all events thrown in the AcmeUserBundle
 */
final class AcmeUserEvents
{
    /**
     * The CHANGE_PASSWORD_INITIALIZE event occurs when the change password process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a Acme\UserBundle\Event\GetResponseUserEvent instance.
     */
    const CHANGE_PASSWORD_INITIALIZE = 'acme_user.change_password.edit.initialize';

    /**
     * The CHANGE_PASSWORD_SUCCESS event occurs when the change password form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a Acme\UserBundle\Event\FormEvent instance.
     */
    const CHANGE_PASSWORD_SUCCESS = 'acme_user.change_password.edit.success';

    /**
     * The CHANGE_PASSWORD_COMPLETED event occurs after saving the user in the change password process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const CHANGE_PASSWORD_COMPLETED = 'acme_user.change_password.edit.completed';

    /**
     * The GROUP_CREATE_INITIALIZE event occurs when the group creation process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a Acme\UserBundle\Event\GroupEvent instance.
     */
    const GROUP_CREATE_INITIALIZE = 'acme_user.group.create.initialize';

    /**
     * The GROUP_CREATE_SUCCESS event occurs when the group creation form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a Acme\UserBundle\Event\FormEvent instance.
     */
    const GROUP_CREATE_SUCCESS = 'acme_user.group.create.success';

    /**
     * The GROUP_CREATE_COMPLETED event occurs after saving the group in the group creation process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterGroupResponseEvent instance.
     */
    const GROUP_CREATE_COMPLETED = 'acme_user.group.create.completed';

    /**
     * The GROUP_DELETE_COMPLETED event occurs after deleting the group.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterGroupResponseEvent instance.
     */
    const GROUP_DELETE_COMPLETED = 'acme_user.group.delete.completed';

    /**
     * The GROUP_EDIT_INITIALIZE event occurs when the group editing process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a Acme\UserBundle\Event\GetResponseGroupEvent instance.
     */
    const GROUP_EDIT_INITIALIZE = 'acme_user.group.edit.initialize';

    /**
     * The GROUP_EDIT_SUCCESS event occurs when the group edit form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a Acme\UserBundle\Event\FormEvent instance.
     */
    const GROUP_EDIT_SUCCESS = 'acme_user.group.edit.success';

    /**
     * The GROUP_EDIT_COMPLETED event occurs after saving the group in the group edit process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterGroupResponseEvent instance.
     */
    const GROUP_EDIT_COMPLETED = 'acme_user.group.edit.completed';

    /**
     * The PROFILE_EDIT_INITIALIZE event occurs when the profile editing process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a Acme\UserBundle\Event\GetResponseUserEvent instance.
     */
    const PROFILE_EDIT_INITIALIZE = 'acme_user.profile.edit.initialize';

    /**
     * The PROFILE_EDIT_SUCCESS event occurs when the profile edit form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a Acme\UserBundle\Event\FormEvent instance.
     */
    const PROFILE_EDIT_SUCCESS = 'acme_user.profile.edit.success';

    /**
     * The PROFILE_EDIT_COMPLETED event occurs after saving the user in the profile edit process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const PROFILE_EDIT_COMPLETED = 'acme_user.profile.edit.completed';

    /**
     * The REGISTRATION_INITIALIZE event occurs when the registration process is initialized.
     *
     * This event allows you to modify the default values of the user before binding the form.
     * The event listener method receives a Acme\UserBundle\Event\UserEvent instance.
     */
    const REGISTRATION_INITIALIZE = 'acme_user.registration.initialize';

    /**
     * The REGISTRATION_SUCCESS event occurs when the registration form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a Acme\UserBundle\Event\FormEvent instance.
     */
    const REGISTRATION_SUCCESS = 'acme_user.registration.success';

    /**
     * The REGISTRATION_COMPLETED event occurs after saving the user in the registration process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const REGISTRATION_COMPLETED = 'acme_user.registration.completed';

    /**
     * The REGISTRATION_CONFIRM event occurs just before confirming the account.
     *
     * This event allows you to access the user which will be confirmed.
     * The event listener method receives a Acme\UserBundle\Event\GetResponseUserEvent instance.
     */
    const REGISTRATION_CONFIRM = 'acme_user.registration.confirm';

    /**
     * The REGISTRATION_CONFIRMED event occurs after confirming the account.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const REGISTRATION_CONFIRMED = 'acme_user.registration.confirmed';

    /**
     * The RESETTING_RESET_INITIALIZE event occurs when the resetting process is initialized.
     *
     * This event allows you to set the response to bypass the processing.
     * The event listener method receives a Acme\UserBundle\Event\GetResponseUserEvent instance.
     */
    const RESETTING_RESET_INITIALIZE = 'acme_user.resetting.reset.initialize';

    /**
     * The RESETTING_RESET_SUCCESS event occurs when the resetting form is submitted successfully.
     *
     * This event allows you to set the response instead of using the default one.
     * The event listener method receives a Acme\UserBundle\Event\FormEvent instance.
     */
    const RESETTING_RESET_SUCCESS = 'acme_user.resetting.reset.success';

    /**
     * The RESETTING_RESET_COMPLETED event occurs after saving the user in the resetting process.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\FilterUserResponseEvent instance.
     */
    const RESETTING_RESET_COMPLETED = 'acme_user.resetting.reset.completed';

    /**
     * The SECURITY_IMPLICIT_LOGIN event occurs when the user is logged in programmatically.
     *
     * This event allows you to access the response which will be sent.
     * The event listener method receives a Acme\UserBundle\Event\UserEvent instance.
     */
    const SECURITY_IMPLICIT_LOGIN = 'acme_user.security.implicit_login';
}

