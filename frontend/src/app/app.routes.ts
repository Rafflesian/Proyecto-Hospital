import { Routes } from '@angular/router';
import { PersonasTable } from '@components/personas-table/personas-table';
import { PersonasForm } from '@components/personas-form/personas-form';

export const routes: Routes = [
    {
        path: '',
        redirectTo: 'personas',
        pathMatch: 'full'
    },
    {
        path: 'personas',
        component: PersonasTable
    },
    {
        path: 'personas/nuevo',
        component: PersonasForm
    }
];
