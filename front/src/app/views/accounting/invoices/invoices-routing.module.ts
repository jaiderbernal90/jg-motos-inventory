import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AddInvoicesComponent } from './pages/add-invoices/add-invoices.component';
import { InvoicesComponent } from './pages/invoices/invoices.component';

const routes: Routes = [
  {
    path: '',
    component: InvoicesComponent,
  },
  {
    path: 'crear',
    component: AddInvoicesComponent,
    data: {
      title: 'Crear',
    }
  },
  {
    path: 'editar/:id',
    component: AddInvoicesComponent,
    data: {
      title: 'Editar',
    }
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class InvoicesRoutingModule { }
