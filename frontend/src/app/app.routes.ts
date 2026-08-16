import { Routes } from '@angular/router';
import { PersonasTable } from '@components/personas-table/personas-table';
import { PersonasForm } from '@components/personas-form/personas-form';
import { PersonasInforme } from './components/personas-informe/personas-informe';
import { PersonasInformeList } from './components/personas-informe-list/personas-informe-list';

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
    },
    {
        path: 'personas/:id',
        component: PersonasForm
    },
    {
        path: 'personas/informe/:id',
        component: PersonasInformeList
    },
    {
        path: 'personas/informe/ver/:informe_id',
        component: PersonasInforme,
    },
    {
        path: 'personas/informe/nuevo/:persona_id',
        component: PersonasInforme
    }
];
