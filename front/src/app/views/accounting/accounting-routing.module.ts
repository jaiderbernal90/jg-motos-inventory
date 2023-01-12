import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { NoAuthGuard } from '../../shared/guards/no-auth.guard';

const routes: Routes = [
  {
    path: 'ventas',
    canActivate: [ NoAuthGuard ],
    data: {
        title: 'Ventas'
    },
    loadChildren: () => import('../../views/accounting/sales/sales.module').then(m => m.SalesModule),
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AccountingRoutingModule { }
