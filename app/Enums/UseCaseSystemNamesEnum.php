<?php

namespace App\Enums;

/**
 * Class UseCaseSystemNamesEnum
 * @package App\Enums
 */
final class UseCaseSystemNamesEnum
{
    /**
     * Use case "Register"
     * @var string
     */
    public const REGISTER = 'register';

    /**
     * Use case "Login"
     * @var string
     */
    public const LOGIN = 'login';

    /**
     * Use case "Show detail user"
     * @var string
     */
    public const SHOW_DETAIL_USER = 'show_detail_user';

    /**
     * Use case "Update specific user"
     * @var string
     */
    public const UPDATE_SPECIFIC_USER = 'update_specific_user';

    /**
     * Use case "Create document template"
     * @var string
     */
    public const CREATE_DOCUMENT_TEMPLATE = 'create_document_template';

    /**
     * Use case "Get document templates"
     * @var string
     */
    public const GET_DOCUMENT_TEMPLATES = 'get_document_templates';

    /**
     * Use case "Delete document template"
     * @var string
     */
    public const DELETE_DOCUMENT_TEMPLATE = 'delete_document_template';
}
