<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EmployeePositionEnum: string implements HasLabel
{
    case CEO = 'ceo';
    case MANAGER = 'manager';
    case SUPERVISOR = 'supervisor';
    case TEAMLEADER = 'team_leader';
    case WEBDEVELOPER = 'web_developer';
    case MOBILEDEVELOPER = 'mobile_developer';
    case FRONTENDDEVELOPER = 'frontend_developer';
    case BACKENDDEVELOPER = 'backend_developer';
    case FULLSTACKDEVELOPER = 'fullstack_developer';
    case PLAYBOOKMASTER = 'playbook_master';
    case UIDESIGNER = 'ui_designer';
    case INTERN = 'intern';
    case TRAINEE = 'trainee';    

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CEO => 'CEO',
            self::MANAGER => 'Manager',
            self::SUPERVISOR => 'Supervisor',
            self::TEAMLEADER => 'Team Leader',
            self::WEBDEVELOPER => 'Web Developer',
            self::MOBILEDEVELOPER => 'Mobile Developer',
            self::FRONTENDDEVELOPER => 'Frontend Developer',
            self::BACKENDDEVELOPER => 'Backend Developer',
            self::FULLSTACKDEVELOPER => 'Fullstack Developer',
            self::PLAYBOOKMASTER => 'Playbook Master',
            self::UIDESIGNER => 'UI Designer',
            self::INTERN => 'Intern',
            self::TRAINEE => 'Trainee',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
