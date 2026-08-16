import { Routes } from '@angular/router';
import { PersonasTable } from '@components/personas-table/personas-table';

export const routes: Routes = [
    {
        path: '',
        redirectTo: 'personas',
        pathMatch: 'full'
    },
    {
        path: 'personas',
        component: PersonasTable
    }
];
