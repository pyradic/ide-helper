<?php /** @noinspection AutoloadingIssuesInspection *//** @noinspection PhpUnused */

namespace Pyro\IdeHelper\Examples;

class RoutesExamples
{
    public static function uris()
    {
        return [
        'form/handle/{key}',
'entry/handle/restore/{addon}/{namespace}/{stream}/{id}',
'entry/handle/export/{addon}/{namespace}/{stream}',
'locks/touch',
'locks/release',
'_dusk/login/{userId}/{guard?}',
'_dusk/logout/{guard?}',
'_dusk/user/{guard?}',
'log-viewer',
'log-viewer/logs',
'log-viewer/logs/delete',
'log-viewer/logs/{date}',
'log-viewer/logs/{date}/download',
'log-viewer/logs/{date}/{level}',
'log-viewer/logs/{date}/{level}/search',
'/',
'admin/settings',
'admin/settings/{type}',
'admin/settings/{type}/{addon}',
'admin/preferences',
'admin/preferences/{type}',
'admin/preferences/{type}/{addon}',
'streams/blocks-field_type/choose/{field}',
'streams/blocks-field_type/form/{field}/{extension}',
'admin/boolean-field_type/toggle',
'admin/dashboard',
'admin/dashboard/manage',
'admin/dashboard/create',
'admin/dashboard/edit/{id}',
'admin/dashboard/view/{dashboard}',
'admin/dashboard/widgets',
'admin/dashboard/widgets/create',
'admin/dashboard/widgets/edit/{id}',
'admin/dashboard/widgets/choose',
'admin/dashboard/widgets/save',
'streams/file-field_type/index/{key}',
'streams/file-field_type/choose/{key}',
'streams/file-field_type/selected',
'streams/file-field_type/exists/{folder}',
'streams/file-field_type/upload/{folder}/{key}',
'streams/file-field_type/handle',
'streams/file-field_type/recent',
'grid-field_type/choose/{field}',
'grid-field_type/form/{field}/{stream}',
'admin/grids',
'admin/grids/create',
'admin/grids/edit/{id}',
'installer',
'installer/delete',
'installer/install',
'installer/run/{key}',
'installer/process/{key?}',
'streams/multiple-field_type/json/{key}',
'streams/multiple-field_type/index/{key}',
'streams/multiple-field_type/selected/{key}',
'streams/relationship-field_type/index/{key}',
'streams/relationship-field_type/selected/{key}',
'repeater-field_type/form/{field}',
'admin/repeaters',
'admin/repeaters/create',
'admin/repeaters/edit/{id}',
'robots.txt',
'sitemap.xml',
'sitemap/{addon}/{file}.xml',
'users/self',
'@{username}',
'login',
'logout',
'register',
'users/activate',
'users/password/reset',
'users/password/forgot',
'admin',
'auth/login',
'auth/logout',
'admin/login',
'admin/logout',
'streams/wysiwyg-field_type/index',
'streams/wysiwyg-field_type/choose',
'streams/wysiwyg-field_type/selected',
'streams/wysiwyg-field_type/exists/{folder}',
'streams/wysiwyg-field_type/upload/{folder}',
'streams/wysiwyg-field_type/handle',
'streams/wysiwyg-field_type/recent',
'admin/activities',
'admin/activities/create',
'admin/activities/edit/{activity}',
'admin/activities/view/{activity}',
'admin/clients/activities/assign/{client}/{activity?}',
'admin/clients/activities/unassign/{client}/{activity}',
'admin/clients/registrations/actions',
'admin/clients/registrations/actions/create',
'admin/clients/registrations/actions/edit/{action}',
'admin/clients/registrations/registrations/edit/{registration}',
'admin/clients/registrations/registrations/view/{registration}',
'admin/clients/registrations/registrations/delete/{registration}',
'admin/clients/registrations/registrations/subject_field/{category}/{registration?}',
'admin/clients/registrations/registrations/{client?}/{clientRole?}',
'admin/clients/registrations/registrations/{client}/create/{clientRole}',
'admin/clients/registrations/reports/{client}/{clientRole}',
'admin/clients/registrations/reports/{client}/create/{clientRole}',
'admin/clients/registrations/reports/edit/{report}',
'admin/clients/registrations/reports/view/{report}',
'admin/clients/registrations/categories',
'admin/clients/registrations/categories/create',
'admin/clients/registrations/categories/edit/{category}',
'admin/clients/registrations/categories/{category}/subjects',
'admin/clients/registrations/categories/{category}/subjects/create',
'admin/clients/registrations/categories/{category}/subjects/edit/{subject}',
'admin/clients/instances',
'admin/clients/instances/create',
'admin/clients/instances/edit/{id}',
'admin/clients/groups',
'admin/clients/groups/create',
'admin/clients/groups/edit/{id}',
'admin/clients/advisors',
'admin/clients/advisors/create',
'admin/clients/advisors/edit/{id}',
'admin/clients/caseload',
'admin/clients/caseload/{userId}',
'admin/clients/roles',
'admin/clients/roles/create',
'admin/clients/roles/edit/{id}',
'admin/clients/roles/ajax-edit/{id}',
'admin/clients/documents/{client}',
'admin/clients/documents/create/{clientId}',
'admin/clients/documents/edit/{id}',
'admin/clients/documents/view/{id}',
'admin/clients',
'admin/clients/create',
'admin/clients/edit/{client}',
'admin/clients/view/{client}/roles',
'admin/clients/view/{client}/advisors/{clientRole}',
'admin/clients/view/{client}/advisor/{clientRole}/{advisor}',
'admin/clients/view/{client}',
'admin/clients/settings',
'admin/clients/contacts/create/{client}',
'admin/clients/contacts',
'admin/clients/contacts/view/{contact}',
'admin/clients/contacts/edit/{contact}',
'admin/clients/contacts/delete/{contact}',
'admin/core',
'admin/core/instances',
'admin/core/instances/create',
'admin/core/instances/edit/{instance}',
'admin/core/education-levels',
'admin/core/education-levels/create',
'admin/core/education-levels/edit/{education_level}',
'admin/departments',
'admin/departments/create',
'admin/departments/edit/{id}',
'admin/api/departments',
'admin/select_department/{slug?}',
'admin/deselect_department',
'admin/departments/enable/{id}',
'admin/departments/disable/{id}',
'admin/departments/settings',
'admin/departments/preferences',
'admin/faq/questions',
'admin/faq/questions/create',
'admin/faq/questions/edit/{id}',
'admin/faq/categories',
'admin/faq/categories/create',
'admin/faq/categories/edit/{id}',
'admin/faq',
'streams/files-field_type/index/{key}',
'streams/files-field_type/choose/{key}',
'streams/files-field_type/selected',
'streams/files-field_type/exists/{folder}',
'streams/files-field_type/upload/{folder}/{key}',
'streams/files-field_type/handle',
'streams/files-field_type/recent',
'admin/files',
'admin/files/where',
'admin/files/move',
'admin/files/upload/choose',
'admin/files/upload/handle',
'admin/files/upload/recent',
'admin/files/upload/{folder}',
'admin/files/edit/{id}',
'admin/files/view/{id}',
'admin/files/exists/{folder}',
'admin/files/folders',
'admin/files/folders/create',
'admin/files/folders/edit/{id}',
'admin/files/disks',
'admin/files/disks/choose',
'admin/files/disks/create',
'admin/files/disks/edit/{id}',
'admin/files/upload/{disk}/{path?}',
'files/{folder}/{name}',
'files/thumb/{folder}/{name}',
'files/stream/{folder}/{name}',
'files/download/{folder}/{name}',
'streams/multiple_departments-field_type/json/{key}',
'streams/multiple_departments-field_type/index/{key}',
'streams/multiple_departments-field_type/selected/{key}',
'admin/clients/requester/intake/{client}/view',
'admin/clients/requester/intake/{client}/create',
'admin/clients/requester/intake/{client}/edit',
'admin/clients/requester/intake/groups',
'admin/clients/requester/intake/groups/create',
'admin/clients/requester/intake/groups/edit/{group}',
'admin/clients/requester/requests',
'admin/clients/requester/requests/{client}',
'admin/clients/requester/requests/{client}/create',
'admin/clients/requester/requests/{client}/edit/{request}',
'admin/clients/requester/requests/{client}/view/{request}',
'admin/clients/requester/requests/delete/{request}',
'admin/clients/requester/requests/close/{request}',
'admin/clients/requester/requests/open/{request}',
'admin/clients/requester/categories',
'admin/clients/requester/categories/create',
'admin/clients/requester/categories/edit/{category}',
'admin/activity_log',
'admin/activity_log/create',
'admin/activity_log/edit/{id}',
'admin/menus',
'admin/menus/choose',
'admin/menus/create',
'admin/menus/edit/{id}',
'admin/menus/links/{menu?}',
'admin/menus/links/{menu}/tree',
'admin/menus/links/{menu}/create/{type}/{parent?}',
'admin/menus/links/{menu}/edit/{id}',
'admin/menus/links/{menu}/view/{id}',
'admin/menus/links/{menu}/change/{id}',
'admin/menus/links/delete/{id}',
'admin/menus/links/choose/{menu}/{parent?}',
'streams/pivot-field_type/json/{key}',
'streams/pivot-field_type/index/{key}',
'streams/pivot-field_type/selected/{key}',
'admin/grids/fields',
'admin/grids/fields/choose',
'admin/grids/fields/create',
'admin/grids/fields/edit/{id}',
'admin/grids/fields/change/{id}',
'admin/grids/assignments/{stream}',
'admin/grids/assignments/{stream}/choose',
'admin/grids/assignments/{stream}/create',
'admin/grids/assignments/{stream}/edit/{id}',
'admin/repeaters/fields',
'admin/repeaters/fields/choose',
'admin/repeaters/fields/create',
'admin/repeaters/fields/edit/{id}',
'admin/repeaters/fields/change/{id}',
'admin/repeaters/assignments/{stream}',
'admin/repeaters/assignments/{stream}/choose',
'admin/repeaters/assignments/{stream}/create',
'admin/repeaters/assignments/{stream}/edit/{id}',
'admin/clients/contacts',
'admin/clients/contacts/create',
'admin/files/versions/{id}',
        ];
    }
}