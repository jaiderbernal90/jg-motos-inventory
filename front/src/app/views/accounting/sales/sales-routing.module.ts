import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AddSalesComponent } from './pages/add-sales/add-sales.component';
import { SalesComponent } from './pages/sales/sales.component';
import { ViewBailsComponent } from './pages/view-bails/view-bails.component';
import { AddBailsComponent } from './pages/add-bails/add-bails.component';

const routes: Routes = [
  {
    path: '',
    component: SalesComponent,
  },
  {
    path: 'crear',
    component: AddSalesComponent,
    data: {
      title: 'Crear',
      headerDisplay: "none"
    }
  },
  {
    path: 'editar/:id',
    component: AddSalesComponent,
    data: {
      title: 'Editar',
      headerDisplay: "none"
    }
  },
  {
    path: 'abonos/:id',
    data: {
      title: 'Abonos'
    },
    children:[
      {
        path:'',
        component: ViewBailsComponent,
      },
      {
        path: 'crear',
        component: AddBailsComponent,
        data: {
          title: 'Crear'
        }
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SalesRoutingModule { }
