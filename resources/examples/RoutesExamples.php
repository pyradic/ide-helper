<?php /** @noinspection AutoloadingIssuesInspection */

/** @noinspection PhpUnused */

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
            '/',
            'admin/test',
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
            'admin/clients/activities',
            'admin/clients/activities/create',
            'admin/clients/activities/{activity}',
            'admin/clients/activities/{activity}/edit',
            'admin/clients/activities/{activity}/copy',
            'admin/clients/{client}/activities/choose',
            'admin/clients/{client}/activities/{activity}/assign',
            'admin/clients/{client}/activities/{activity}/unassign',
            'admin/agenda/preview',
            'admin/agenda/test',
            'admin/agenda/event/create',
            'admin/agenda/event/{event}',
            'admin/agenda/event/{event}/edit',
            'admin/agenda/event/{event}/delete',
            'admin/clients/requester/intake/{client}/view',
            'admin/clients/requester/intake/{client}/create',
            'admin/clients/requester/intake/{client}/edit',
            'admin/clients/care/intake/{client}/view',
            'admin/clients/care/intake/{client}/create',
            'admin/clients/careintake/{client}/edit',
            'admin/clients/{client}/caretaker/intake',
            'admin/clients/{client}/caretaker/intake/create',
            'admin/clients/{client}/caretaker/intake/edit',
            'admin/clients/caretaker/intake_caregivers',
            'admin/clients/caretaker/intake_caregivers/create',
            'admin/clients/caretaker/intake_caregivers/{intakeCaregiver}/edit',
            'admin/clients/caretaker/intake_hours',
            'admin/clients/caretaker/intake_hours/create',
            'admin/clients/caretaker/intake_hours/{intakeHour}/edit',
            'admin/clients/caretaker/intake_overpressure',
            'admin/clients/caretaker/intake_overpressure/create',
            'admin/clients/caretaker/intake_overpressure/{intakeOverpressure}/edit',
            'admin/clients/caretaker/intake_provided_care',
            'admin/clients/caretaker/intake_provided_care/create',
            'admin/clients/caretaker/intake_provided_care/{intakeProvidedCare}/edit',
            'admin/clients/caretaker/intake_restrictions',
            'admin/clients/caretaker/intake_restrictions/create',
            'admin/clients/caretaker/intake_restrictions/{intakeRestriction}/edit',
            'admin/clients/registrations/actions',
            'admin/clients/registrations/actions/create',
            'admin/clients/registrations/actions/{action}/edit',
            'admin/clients/registrations/registrations/{registration}',
            'admin/clients/registrations/registrations/{registration}/edit',
            'admin/clients/registrations/registrations/{registration}/delete',
            'admin/clients/registrations/registrations/subject_field/{category}/{registration?}',
            'admin/clients/registrations/registrations',
            'admin/clients/registrations/registrations/{client}/{clientRole?}',
            'admin/clients/registrations/registrations/{client}/create/{clientRole}',
            'admin/clients/registrations/{registration}/reports',
            'admin/clients/registrations/{registration}/reports/create',
            'admin/clients/registrations/reports/edit/{report}',
            'admin/clients/registrations/reports/view/{report}',
            'admin/clients/registrations/categories',
            'admin/clients/registrations/categories/create',
            'admin/clients/registrations/categories/edit/{category}',
            'admin/clients/registrations/categories/{category}/subjects',
            'admin/clients/registrations/categories/{category}/subjects/create',
            'admin/clients/registrations/categories/{category}/subjects/edit/{subject}',
            'admin/clients',
            'admin/clients/create',
            'admin/clients/{client}',
            'admin/clients/{client}/edit',
            'admin/clients/{client}/edit/documents',
            'admin/clients/{client}/roles',
            'admin/clients/{client}/dossiers/create/{clientRole}',
            'admin/clients/{client}/dossiers/close/{dossier}',
            'admin/clients/{client}/groups/choose',
            'admin/clients/{client}/groups/assign/{group}',
            'admin/clients/{client}/groups/unassign/{group}',
            'admin/clients/groups',
            'admin/clients/groups/create',
            'admin/clients/groups/{group}/{client?}',
            'admin/clients/groups/{group}/edit',
            'admin/clients/{client}/advisors/{clientRole}',
            'admin/clients/{client}/advisor/assign/{clientRole}/{advisor}',
            'admin/clients/{client}/advisor/unassign/{clientRole}/{advisor}',
            'admin/clients/settings',
            'admin/clients/instances',
            'admin/clients/instances/create',
            'admin/clients/instances/{id}/edit',
            'admin/clients/caseload',
            'admin/clients/caseload/{userId}',
            'admin/clients/roles',
            'admin/clients/roles/create',
            'admin/clients/roles/{clientRole}/edit',
            'admin/clients/roles/{clientRole}/ajax-edit',
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
            'admin/clients/{client}/courses/intake/view',
            'admin/clients/{client}/courses/intake/create',
            'admin/clients/{client}/courses/intake/edit',
            'admin/departments',
            'admin/departments/create',
            'admin/departments/{id}/edit',
            'admin/api/departments',
            'admin/select_department/{slug?}',
            'admin/deselect_department',
            'admin/departments/{id}/enable',
            'admin/departments/{id}//disable',
            'admin/departments/settings',
            'admin/departments/preferences',
            'admin/faq/questions',
            'admin/faq/questions/{question}',
            'admin/faq/questions/create',
            'admin/faq/questions/edit/{id}',
            'admin/faq/categories',
            'admin/faq/categories/create',
            'admin/faq/categories/edit/{id}',
            'admin/faq',
            'admin/file-manager',
            'admin/file-manager/data',
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
            'admin/notes',
            'admin/notes/create',
            'admin/notes/{note}',
            'admin/notes/{note}/edit',
            'admin/clients/{client}/requester/intake',
            'admin/clients/{client}/requester/intake/create',
            'admin/clients/{client}/requester/intake/edit',
            'admin/clients/requester/intake/groups',
            'admin/clients/requester/intake/groups/create',
            'admin/clients/requester/intake/groups/edit/{group}',
            'admin/clients/requester/requests',
            'admin/clients/requester/requests/{request}',
            'admin/clients/requester/requests/{request}/edit',
            'admin/clients/requester/requests/{request}/delete',
            'admin/clients/requester/requests/{request}/close',
            'admin/clients/requester/requests/{request}/open',
            'admin/clients/requester/requests/{request}/match',
            'admin/clients/{client}/requester/requests',
            'admin/clients/{client}/requester/requests/{request}',
            'admin/clients/{client}/requester/requests/create',
            'admin/clients/{client}/requester/requests/{request}/edit',
            'admin/clients/{client}/requester/requests/{request}/close',
            'admin/clients/{client}/requester/requests/{request}/match',
            'admin/clients/requester/match',
            'admin/clients/requester/match/{match}',
            'admin/clients/requester/match/create/{request}/{volunteerIntake}',
            'admin/clients/requester/match/{match}/edit',
            'admin/clients/requester/match/{match}/close',
            'admin/clients/requester/match/{match}/open',
            'admin/clients/requester/categories',
            'admin/clients/requester/categories/create',
            'admin/clients/requester/categories/{category}/edit',
            'admin/clients/requester/reason_closed',
            'admin/clients/requester/reason_closed/create',
            'admin/clients/requester/reason_closed/{reasonClosed}/edit',
            'admin/clients/requester/reason_unfilled',
            'admin/clients/requester/reason_unfilled/create',
            'admin/clients/requester/reason_unfilled/{reasonUnfilled}/edit',
            'admin/clients/{client}/requester/caretakers/select',
            'admin/clients/{client}/requester/caretakers/assign/{caretakerClient}',
            'admin/clients/{client}/requester/caretakers/unassign/{caretakerClient}',
            'admin/clients/{client}/volunteer/intake',
            'admin/clients/{client}/volunteer/intake/create',
            'admin/clients/{client}/volunteer/intake/edit',
            'admin/activity_log',
            'admin/activity_log/edit/{id}',
            'admin/jira_widget/{id}/table',
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
            'admin/table-demo',
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
            'admin/vxe_table',
            'admin/vxe_table/query/{pageSize}/{currentPage}',
            'admin/vxe_table/query/{pageSize}/{currentPage}',
        ];
    }
}
