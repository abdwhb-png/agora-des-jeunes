<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    case VIEW_DASHBOARD = 'view_dashboard';

        // Content Management
    case MANAGE_AGORA_SESSIONS = 'manage_agora_sessions';
    case MANAGE_POLLS = 'manage_polls';
    case MANAGE_FAQS = 'manage_faqs';
    case MANAGE_TRAININGS = 'manage_trainings';
    case MANAGE_JOB_OFFERS = 'manage_job_offers';
    case MANAGE_SCHOLARSHIPS = 'manage_scholarships';
    case MANAGE_TENDERS = 'manage_tenders';
    case MANAGE_DEPARTEMENTS = 'manage_departements';

        // User Management
    case INVITE_USER = 'invite_user';
    case VIEW_USERS = 'view_users';
    case CREATE_USER = 'create_user';
    case EDIT_USER = 'edit_user';
    case DELETE_USER = 'delete_user';

        // Manager Management
    case VIEW_MANAGERS = 'view_managers';
    case CREATE_MANAGER = 'create_manager';
    case EDIT_MANAGER = 'edit_manager';
    case DELETE_MANAGER = 'delete_manager';

        // Admin Management
    case VIEW_ADMINS = 'view_admins';
    case CREATE_ADMIN = 'create_admin';
    case EDIT_ADMIN = 'edit_admin';
    case DELETE_ADMIN = 'delete_admin';

        // Super Admin Management (if necessary)
    case VIEW_SUPERADMINS = 'view_superadmins';
    case CREATE_SUPERADMIN = 'create_superadmin';
    case EDIT_SUPERADMIN = 'edit_superadmin';
    case DELETE_SUPERADMIN = 'delete_superadmin';

        // Role Management
    case VIEW_ROLES = 'view_roles';
    case CREATE_ROLE = 'create_role';
    case EDIT_ROLE = 'edit_role';
    case DELETE_ROLE = 'delete_role';

        // Permission Management
    case VIEW_PERMISSIONS = 'view_permissions';
    case CREATE_PERMISSION = 'create_permission';
    case EDIT_PERMISSION = 'edit_permission';
    case DELETE_PERMISSION = 'delete_permission';

        // Advanced Configuration
    case MANAGE_CONFIGURATION = 'manage_configuration';
    case MANAGE_LOGS = 'manage_logs';
    case ACCESS_INTERNAL_API = 'access_internal_api';
    case MANAGE_DATABASE = 'manage_database';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
